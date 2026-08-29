<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\MediaItem;
use App\Models\Project;
use App\Models\Setting;
use App\Models\Testimonial;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PersistenceTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create([
            'email'    => 'admin@mahaconstruction.com',
            'password' => Hash::make('secret123'),
            'role'     => 'admin',
        ]);
    }

    /**
     * Test that single file image/video upload persists physical file, DB record, and valid URL.
     */
    public function test_single_upload_persists_file_and_database_record(): void
    {
        $fakeImage = UploadedFile::fake()->create('custom_luxury_facade.jpg', 500, 'image/jpeg');

        $response = $this->actingAs($this->admin)
            ->withSession(['admin_authenticated' => true])
            ->postJson('/api/upload', [
                'file' => $fakeImage,
            ]);

        $response->assertCreated();
        $data = $response->json();

        $this->assertTrue($data['success']);
        $this->assertStringStartsWith('/uploads/', $data['url']);
        $this->assertNotEmpty($data['filename']);

        // Verify physical file exists on disk
        $physicalPath = public_path('uploads/' . $data['filename']);
        $this->assertFileExists($physicalPath);

        // Verify database persistence
        $this->assertDatabaseHas('media', [
            'filename' => $data['filename'],
            'filepath' => $data['url'],
        ]);

        // Clean up uploaded test artifact
        if (file_exists($physicalPath)) {
            @unlink($physicalPath);
        }
    }

    /**
     * Test that running database migrations & seeders is non-destructive
     * and NEVER overwrites existing admin-created projects, custom settings, or uploaded media.
     */
    public function test_seeder_is_idempotent_and_never_overwrites_existing_admin_content(): void
    {
        // 1. Admin creates a custom project with uploaded media URLs
        $customProject = Project::create([
            'name'               => 'Emerald Penthouse Landmark',
            'client'             => 'Mr. Ramanathan',
            'location'           => 'Chennai, Tamil Nadu',
            'budget'             => '₹18.5 Crore',
            'completion_date'    => 'August 2026',
            'duration'           => '16 Months',
            'architecture_style' => 'Modernist Ultra-Luxury',
            'description'        => 'Custom penthouse with private infinity pool and smart automation.',
            'image_urls'         => ['/uploads/custom_facade_1.jpg', '/uploads/custom_facade_2.jpg'],
            'video_url'          => '/uploads/custom_tour_video.mp4',
            'category'           => 'residential',
            'is_featured'        => true,
        ]);

        // 2. Admin sets custom guidebook and intro video settings
        Setting::updateOrCreate(
            ['key' => 'guidebook_pdf_url'],
            ['value' => '/uploads/custom_admin_guidebook.pdf']
        );
        Setting::updateOrCreate(
            ['key' => 'intro_video_url'],
            ['value' => '/uploads/custom_intro_walkthrough.mp4']
        );

        $initialProjectCount = Project::count();

        // 3. Simulate multiple deployment re-seeds (e.g. php artisan db:seed)
        $seeder = new DatabaseSeeder();
        $seeder->run();
        $seeder->run();

        // 4. Verify custom project and uploaded media references were NOT wiped or overwritten
        $refetchedProject = Project::find($customProject->id);
        $this->assertNotNull($refetchedProject);
        $this->assertEquals('Emerald Penthouse Landmark', $refetchedProject->name);
        $this->assertEquals(['/uploads/custom_facade_1.jpg', '/uploads/custom_facade_2.jpg'], $refetchedProject->image_urls);
        $this->assertEquals('/uploads/custom_tour_video.mp4', $refetchedProject->video_url);

        // 5. Verify custom settings were preserved intact
        $guidebookSetting = Setting::where('key', 'guidebook_pdf_url')->first();
        $this->assertEquals('/uploads/custom_admin_guidebook.pdf', $guidebookSetting->value);

        $introSetting = Setting::where('key', 'intro_video_url')->first();
        $this->assertEquals('/uploads/custom_intro_walkthrough.mp4', $introSetting->value);

        // 6. Verify project count did not duplicate or get overwritten by default sample projects
        $this->assertEquals($initialProjectCount, Project::count());
    }

    /**
     * Test media item deletion endpoint removes both DB record and physical file.
     */
    public function test_media_item_deletion_removes_physical_file_and_record(): void
    {
        $fakeFile = UploadedFile::fake()->create('delete_me.pdf', 1024, 'application/pdf');

        $uploadRes = $this->actingAs($this->admin)
            ->withSession(['admin_authenticated' => true])
            ->postJson('/api/upload', ['file' => $fakeFile]);

        $uploadRes->assertCreated();
        $mediaId = $uploadRes->json('media.id');
        $filename = $uploadRes->json('filename');
        $filePath = public_path('uploads/' . $filename);

        $this->assertFileExists($filePath);
        $this->assertDatabaseHas('media', ['id' => $mediaId]);

        // Delete via API
        $deleteRes = $this->actingAs($this->admin)
            ->withSession(['admin_authenticated' => true])
            ->deleteJson('/api/media/' . $mediaId);

        $deleteRes->assertOk();
        $this->assertDatabaseMissing('media', ['id' => $mediaId]);
        $this->assertFileDoesNotExist($filePath);
    }

    /**
     * Test full upload -> project creation -> public page rendering flow.
     */
    public function test_uploaded_media_displays_on_public_website(): void
    {
        // 1. Upload an image
        $fakeImage = UploadedFile::fake()->create('facade_hero.jpg', 300, 'image/jpeg');
        $uploadRes = $this->actingAs($this->admin)
            ->withSession(['admin_authenticated' => true])
            ->postJson('/api/upload', ['file' => $fakeImage]);
        $uploadRes->assertCreated();
        $imageUrl = $uploadRes->json('url');
        $filename = $uploadRes->json('filename');

        // 2. Create project using uploaded image URL
        $createRes = $this->actingAs($this->admin)
            ->withSession(['admin_authenticated' => true])
            ->postJson('/api/projects', [
                'name'        => 'Horizon Oceanfront Estate',
                'category'    => 'villa',
                'image_urls'  => [$imageUrl],
                'is_featured' => true,
            ]);
        $createRes->assertCreated();

        // 3. Verify public projects page renders the exact uploaded image URL
        $publicRes = $this->get('/projects');
        $publicRes->assertOk();
        $publicRes->assertSee('Horizon Oceanfront Estate');
        $publicRes->assertSee($imageUrl);

        // 4. Verify public home page renders the featured project
        $homeRes = $this->get('/');
        $homeRes->assertOk();
        $homeRes->assertSee('Horizon Oceanfront Estate');

        // Clean up
        $filePath = public_path('uploads/' . $filename);
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
    }
}
