<?php

namespace App\Services\Media;

use App\Models\Media;
use Illuminate\Http\UploadedFile;

class MediaService
{
    public function store(UploadedFile $file, string $directory = 'media'): string
    {
        $path = $file->store($directory, 'public');

        Media::create([
            'path' => $path,
            'title' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'size_bytes' => $file->getSize(),
        ]);

        return $path;
    }
}
