<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MediaItem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class MediaUploadController extends Controller
{
    /**
     * Standard single-file upload (for images, small videos, logos, PDFs up to 100MB)
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'max:102400', // 100MB direct upload
                'mimes:jpg,jpeg,png,gif,webp,svg,mp4,mov,webm,mkv,avi,m4v,pdf',
            ],
        ]);

        $file         = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $safeName     = preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName);
        $filename     = time() . '_' . $safeName;

        $uploadDir = public_path('uploads');
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $file->move($uploadDir, $filename);

        $url = '/uploads/' . $filename;

        $media = MediaItem::create([
            'filename' => $filename,
            'filepath' => $url,
            'filetype' => $file->getClientMimeType() ?: 'application/octet-stream',
        ]);

        return response()->json([
            'success'  => true,
            'url'      => $url,
            'filename' => $filename,
            'media'    => $media,
            'size'     => file_exists($uploadDir . '/' . $filename) ? filesize($uploadDir . '/' . $filename) : 0,
        ], 201);
    }

    /**
     * Upload a single chunk for a large file (supports up to 2GB files sliced in 5-10MB chunks)
     */
    public function uploadChunk(Request $request)
    {
        $request->validate([
            'upload_id'    => 'required|string|max:64',
            'chunk_index'  => 'required|integer|min:0',
            'total_chunks' => 'required|integer|min:1',
            'chunk'        => 'required|file',
        ]);

        $uploadId    = preg_replace('/[^a-zA-Z0-9_-]/', '', $request->input('upload_id'));
        $chunkIndex  = (int) $request->input('chunk_index');
        $totalChunks = (int) $request->input('total_chunks');

        if (empty($uploadId)) {
            return response()->json(['success' => false, 'message' => 'Invalid upload ID'], 422);
        }

        $chunksBase = storage_path('app' . DIRECTORY_SEPARATOR . 'chunks');
        if (!is_dir($chunksBase)) {
            mkdir($chunksBase, 0777, true);
        }

        $chunkDir = $chunksBase . DIRECTORY_SEPARATOR . $uploadId;
        if (!is_dir($chunkDir)) {
            mkdir($chunkDir, 0777, true);
        }

        $chunkFile = $request->file('chunk');
        $targetPart = $chunkDir . DIRECTORY_SEPARATOR . 'part_' . $chunkIndex;
        if (file_exists($targetPart)) {
            @unlink($targetPart);
        }
        copy($chunkFile->getRealPath(), $targetPart);

        return response()->json([
            'success'     => true,
            'upload_id'   => $uploadId,
            'chunk_index' => (int) $chunkIndex,
            'message'     => 'Chunk uploaded successfully',
        ]);
    }

    /**
     * Finish chunked upload: assemble all parts into final lossless video file
     */
    public function finishChunkedUpload(Request $request)
    {
        @set_time_limit(600); // Allow up to 10 minutes for huge 2GB disk writes if needed

        $request->validate([
            'upload_id'    => 'required|string|max:64',
            'filename'     => 'required|string|max:255',
            'total_chunks' => 'required|integer|min:1',
            'total_size'   => 'nullable|integer',
        ]);

        $uploadId    = preg_replace('/[^a-zA-Z0-9_-]/', '', $request->input('upload_id'));
        $rawFilename = $request->input('filename');
        $totalChunks = (int) $request->input('total_chunks');

        $chunkDir = storage_path('app' . DIRECTORY_SEPARATOR . 'chunks' . DIRECTORY_SEPARATOR . $uploadId);
        if (!is_dir($chunkDir)) {
            return response()->json(['success' => false, 'message' => 'Upload session not found or expired'], 404);
        }

        // Verify that all chunk parts exist
        for ($i = 0; $i < $totalChunks; $i++) {
            $partFile = $chunkDir . DIRECTORY_SEPARATOR . 'part_' . $i;
            if (!file_exists($partFile)) {
                return response()->json([
                    'success' => false,
                    'message' => "Missing chunk part {$i} of {$totalChunks}. Please retry upload.",
                ], 422);
            }
        }

        $uploadDir = public_path('uploads');
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Sanitize final file name and preserve extension
        $cleanName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $rawFilename);
        $finalFilename = time() . '_' . $cleanName;
        $finalPath     = $uploadDir . DIRECTORY_SEPARATOR . $finalFilename;

        // Open final destination stream
        $out = fopen($finalPath, 'wb');
        if (!$out) {
            return response()->json(['success' => false, 'message' => 'Failed to open output file for writing'], 500);
        }

        // Stream and concatenate each chunk into the output file
        for ($i = 0; $i < $totalChunks; $i++) {
            $partFile = $chunkDir . DIRECTORY_SEPARATOR . 'part_' . $i;
            $in = fopen($partFile, 'rb');
            if ($in) {
                while (!feof($in)) {
                    $buffer = fread($in, 4194304); // 4MB stream buffer
                    if ($buffer !== false) {
                        fwrite($out, $buffer);
                    }
                }
                fclose($in);
                unset($in);
            }
            @unlink($partFile);
        }

        fclose($out);
        unset($out);

        // Force garbage collection on Windows so all file streams and move handles are closed
        clearstatcache();
        gc_collect_cycles();

        // Remove temporary chunk directory safely
        File::deleteDirectory($chunkDir);

        // Periodic cleanup of abandoned chunk folders older than 24h
        $this->cleanOldChunks();

        $finalSize = file_exists($finalPath) ? filesize($finalPath) : 0;
        $mimeType  = @mime_content_type($finalPath) ?: 'application/octet-stream';
        $url       = '/uploads/' . $finalFilename;

        $media = MediaItem::create([
            'filename' => $finalFilename,
            'filepath' => $url,
            'filetype' => $mimeType,
        ]);

        return response()->json([
            'success'   => true,
            'url'       => $url,
            'filename'  => $finalFilename,
            'size'      => $finalSize,
            'filetype'  => $mimeType,
            'media'     => $media,
            'message'   => 'Large file uploaded and assembled with 100% original lossless quality.',
        ], 201);
    }

    /**
     * Abort an upload and clean up temporary chunk files
     */
    public function abortChunkedUpload(Request $request)
    {
        $uploadId = preg_replace('/[^a-zA-Z0-9_-]/', '', $request->input('upload_id', ''));
        if ($uploadId) {
            $chunkDir = storage_path('app' . DIRECTORY_SEPARATOR . 'chunks' . DIRECTORY_SEPARATOR . $uploadId);
            gc_collect_cycles();
            File::deleteDirectory($chunkDir);
        }

        return response()->json(['success' => true, 'message' => 'Upload aborted and cleaned up']);
    }

    /**
     * Helper to purge leftover chunks older than 24 hours
     */
    protected function cleanOldChunks()
    {
        $base = storage_path('app' . DIRECTORY_SEPARATOR . 'chunks');
        if (!is_dir($base)) return;

        $dirs = glob($base . '/*', GLOB_ONLYDIR);
        if (!$dirs) return;

        $dayAgo = time() - 86400;

        foreach ($dirs as $dir) {
            if (filemtime($dir) < $dayAgo) {
                File::deleteDirectory($dir);
            }
        }
    }
}
