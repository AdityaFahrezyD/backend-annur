<?php

namespace App\Services\Api\Admin;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class UploadService
{
    /** @return array{url: string, path: string|false} */
    public function upload(UploadedFile $file): array
    {
        $filename = time().'_'.Str::random(8).'.'.$file->extension();
        $path = $file->storeAs('uploads', $filename, 'public');

        return [
            'url' => asset('storage/'.$path),
            'path' => $path,
        ];
    }
}
