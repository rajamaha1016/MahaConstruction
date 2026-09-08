<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use App\Services\YouTubeSyncService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class YouTubeVideoSyncTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create([
            'email'    => 'admin@mahaconstructions.com',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);
    }

    public function test_anonymous_requests_cannot_delete_youtube_videos(): void
    {
        $this->deleteJson('/api/youtube/videos/TEST_VID_01')
            ->assertStatus(401);
    }

    public function test_anonymous_requests_cannot_restore_youtube_videos(): void
    {
        $this->postJson('/api/youtube/videos/TEST_VID_01/restore')
            ->assertStatus(401);
    }

    public function test_admin_can_delete_youtube_video_and_it_persists_as_hidden(): void
    {
        // Seed initial synced videos
        $sampleVideos = [
            ['youtubeId' => 'VID_100', 'title' => 'Video One', 'videoUrl' => 'https://youtube.com/embed/VID_100'],
            ['youtubeId' => 'VID_200', 'title' => 'Video Two', 'videoUrl' => 'https://youtube.com/embed/VID_200'],
            ['youtubeId' => 'VID_300', 'title' => 'Video Three', 'videoUrl' => 'https://youtube.com/embed/VID_300'],
        ];

        Setting::updateOrCreate(['key' => 'youtube_synced_videos'], ['value' => json_encode($sampleVideos)]);
        Setting::updateOrCreate(['key' => 'youtube_video_count'], ['value' => '3']);

        $res = $this->actingAs($this->admin)
            ->withSession(['admin_authenticated' => true])
            ->deleteJson('/api/youtube/videos/VID_200');

        $res->assertOk();
        $res->assertJson([
            'success'    => true,
            'count'      => 2,
            'deleted_id' => 'VID_200',
        ]);

        // Verify hidden blacklist setting contains VID_200
        $hiddenIds = YouTubeSyncService::getHiddenVideoIds();
        $this->assertContains('VID_200', $hiddenIds);

        // Verify synced videos setting has 2 items and VID_200 is gone
        $syncedSetting = Setting::where('key', 'youtube_synced_videos')->first();
        $remaining = json_decode($syncedSetting->value, true);
        $this->assertCount(2, $remaining);
        $this->assertNotContains('VID_200', array_column($remaining, 'youtubeId'));

        // Verify filterHiddenVideos strips it even if an RSS or API re-fetch includes it
        $refetched = [
            'count' => 3,
            'videos' => $sampleVideos,
        ];
        $filtered = YouTubeSyncService::filterHiddenVideos($refetched);
        $this->assertEquals(2, $filtered['count']);
        $this->assertNotContains('VID_200', array_column($filtered['videos'], 'youtubeId'));
    }

    public function test_admin_can_restore_previously_deleted_youtube_video(): void
    {
        // Add VID_999 to hidden list
        Setting::updateOrCreate(
            ['key' => 'youtube_hidden_video_ids'],
            ['value' => json_encode(['VID_999', 'VID_888'])]
        );

        $res = $this->actingAs($this->admin)
            ->withSession(['admin_authenticated' => true])
            ->postJson('/api/youtube/videos/VID_999/restore');

        $res->assertOk();
        $res->assertJson(['success' => true]);

        // Verify VID_999 is unhidden
        $hiddenIds = YouTubeSyncService::getHiddenVideoIds();
        $this->assertNotContains('VID_999', $hiddenIds);
        $this->assertContains('VID_888', $hiddenIds);
    }
}
