<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\MediaItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ChunkedUploadTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create([
            'password' => Hash::make('secret123'),
            'role'     => 'admin',
        ]);
    }

    public function test_chunked_upload_stores_parts_and_assembles_lossless_file(): void
    {
        $uploadId = 'test_up_' . time();
        $chunk1Data = 'PART_1_BINARY_DATA_OF_LARGE_VIDEO_STREAM_';
        $chunk2Data = 'PART_2_BINARY_DATA_OF_LARGE_VIDEO_STREAM_';
        $chunk3Data = 'PART_3_FINAL_STREAM_DATA_4K_60FPS_LOSSLESS';
        $expectedFullContent = $chunk1Data . $chunk2Data . $chunk3Data;

        // 1. Upload Chunk 0
        $fileChunk0 = UploadedFile::fake()->createWithContent('part_0.part', $chunk1Data);
        $res0 = $this->actingAs($this->admin)
            ->withSession(['admin_authenticated' => true])
            ->postJson('/api/upload/chunk', [
                'upload_id'    => $uploadId,
                'chunk_index'  => 0,
                'total_chunks' => 3,
                'chunk'        => $fileChunk0,
            ]);
        $res0->assertOk()->assertJson(['success' => true, 'chunk_index' => 0]);

        // 2. Upload Chunk 1
        $fileChunk1 = UploadedFile::fake()->createWithContent('part_1.part', $chunk2Data);
        $res1 = $this->actingAs($this->admin)
            ->withSession(['admin_authenticated' => true])
            ->postJson('/api/upload/chunk', [
                'upload_id'    => $uploadId,
                'chunk_index'  => 1,
                'total_chunks' => 3,
                'chunk'        => $fileChunk1,
            ]);
        $res1->assertOk()->assertJson(['success' => true, 'chunk_index' => 1]);

        // 3. Upload Chunk 2
        $fileChunk2 = UploadedFile::fake()->createWithContent('part_2.part', $chunk3Data);
        $res2 = $this->actingAs($this->admin)
            ->withSession(['admin_authenticated' => true])
            ->postJson('/api/upload/chunk', [
                'upload_id'    => $uploadId,
                'chunk_index'  => 2,
                'total_chunks' => 3,
                'chunk'        => $fileChunk2,
            ]);
        $res2->assertOk()->assertJson(['success' => true, 'chunk_index' => 2]);

        // 4. Call Finish to assemble
        $finishRes = $this->actingAs($this->admin)
            ->withSession(['admin_authenticated' => true])
            ->postJson('/api/upload/finish', [
                'upload_id'    => $uploadId,
                'filename'     => 'test_luxury_villa_tour.mp4',
                'total_chunks' => 3,
                'total_size'   => strlen($expectedFullContent),
            ]);

        $finishRes->assertCreated();
        $data = $finishRes->json();
        $this->assertTrue($data['success']);
        $this->assertNotEmpty($data['url']);
        $this->assertNotEmpty($data['filename']);

        // Verify the file was created in public/uploads/
        $assembledPath = public_path('uploads/' . $data['filename']);
        $this->assertFileExists($assembledPath);

        // Verify 100% byte-for-byte lossless content equality
        $actualContent = file_get_contents($assembledPath);
        $this->assertEquals($expectedFullContent, $actualContent);

        // Verify MediaItem was created in DB
        $this->assertDatabaseHas('media', [
            'filename' => $data['filename'],
        ]);

        clearstatcache();
        // Verify temporary chunk folder was cleaned up
        $this->assertDirectoryDoesNotExist(storage_path('app' . DIRECTORY_SEPARATOR . 'chunks' . DIRECTORY_SEPARATOR . $uploadId));

        // Clean up test file
        if (file_exists($assembledPath)) {
            @unlink($assembledPath);
        }
    }

    public function test_abort_chunked_upload_cleans_up_directory(): void
    {
        $uploadId = 'test_abort_' . time();
        $chunkData = 'PARTIAL_DATA';

        $fileChunk = UploadedFile::fake()->createWithContent('part_0.part', $chunkData);
        $this->actingAs($this->admin)
            ->withSession(['admin_authenticated' => true])
            ->postJson('/api/upload/chunk', [
                'upload_id'    => $uploadId,
                'chunk_index'  => 0,
                'total_chunks' => 5,
                'chunk'        => $fileChunk,
            ])->assertOk();

        clearstatcache();
        $this->assertDirectoryExists(storage_path('app' . DIRECTORY_SEPARATOR . 'chunks' . DIRECTORY_SEPARATOR . $uploadId));

        // Abort
        $abortRes = $this->actingAs($this->admin)
            ->withSession(['admin_authenticated' => true])
            ->postJson('/api/upload/abort', [
                'upload_id' => $uploadId,
            ]);

        $abortRes->assertOk()->assertJson(['success' => true]);
        clearstatcache();
        $this->assertDirectoryDoesNotExist(storage_path('app' . DIRECTORY_SEPARATOR . 'chunks' . DIRECTORY_SEPARATOR . $uploadId));
    }
}
