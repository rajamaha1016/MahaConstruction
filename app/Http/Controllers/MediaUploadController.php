<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MediaItem;

class MediaUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'max:51200',  // 50MB
                'mimes:jpg,jpeg,png,gif,webp,svg,mp4,mov,webm,pdf',
            ],
        ]);

        $file     = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();

        // Save directly to public/uploads/ so it's served at /uploads/filename
        $uploadDir = public_path('uploads');
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $file->move($uploadDir, $filename);

        $url = '/uploads/' . $filename;

        $media = MediaItem::create([
            'filename' => $filename,
            'filepath' => $url,
            'filetype' => $file->getClientMimeType(),
        ]);

        return response()->json([
            'url'      => $url,
            'filename' => $filename,
            'media'    => $media,
        ], 201);
    }
}
