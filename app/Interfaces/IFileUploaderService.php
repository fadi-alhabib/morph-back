<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

interface IFileUploaderService
{
    public function uploadSingleFile(UploadedFile $file, string $path): string;
    public function uploadMultipleFiles(array $files, string $path): array;
    public function replaceMedia(UploadedFile $newFile, string $oldPath): string;
}
