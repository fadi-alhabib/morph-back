<?php

namespace App\Services;

use App\Interfaces\IFileUploaderService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

class S3FileUploaderService implements IFileUploaderService
{
    private string $disk = 's3';
    private string $rootPath;

    public function __construct()
    {
        $this->rootPath = config('filesystems.disks.s3.root', '');
    }

    /**
     * Upload a single file to S3
     *
     * @param UploadedFile $file
     * @param string $path
     * @return string
     * @throws Exception
     */
    public function uploadSingleFile(UploadedFile $file, string $path): string
    {
        try {
            // Validate file
            if (!$file->isValid()) {
                throw new Exception('Invalid file upload');
            }

            // Generate unique filename
            $filename = $this->generateUniqueFilename($file);
            
            // Build full path with AWS_ROOT prefix
            $fullPath = $this->buildFullPath($path, $filename);
            
            // Store file in S3
            $storedPath = Storage::disk($this->disk)->putFileAs(
                $path,
                $file,
                $filename,
                'public'
            );

            if (!$storedPath) {
                throw new Exception('Failed to upload file to S3');
            }

            return $storedPath;
        } catch (Exception $e) {
            throw new Exception("File upload failed: " . $e->getMessage());
        }
    }

    /**
     * Upload multiple files to S3
     *
     * @param array $files
     * @param string $path
     * @return array
     * @throws Exception
     */
    public function uploadMultipleFiles(array $files, string $path): array
    {
        $uploadedFiles = [];
        $errors = [];

        foreach ($files as $index => $file) {
            try {
                if ($file instanceof UploadedFile) {
                    $uploadedPath = $this->uploadSingleFile($file, $path);
                    $uploadedFiles[] = $uploadedPath;
                } else {
                    $errors[] = "File at index {$index} is not a valid UploadedFile";
                }
            } catch (Exception $e) {
                $errors[] = "File at index {$index}: " . $e->getMessage();
            }
        }

        if (!empty($errors) && empty($uploadedFiles)) {
            throw new Exception("All file uploads failed: " . implode(', ', $errors));
        }

        if (!empty($errors)) {
            // Log warnings for partial failures
            \Log::warning("Some file uploads failed", ['errors' => $errors]);
        }

        return $uploadedFiles;
    }

    /**
     * Replace media file in S3
     *
     * @param UploadedFile $newFile
     * @param string $oldPath
     * @return string
     * @throws Exception
     */
    public function replaceMedia(UploadedFile $newFile, string $oldPath): string
    {
        try {
            // Validate new file
            if (!$newFile->isValid()) {
                throw new Exception('Invalid file upload');
            }

            // Extract directory from old path
            $pathInfo = pathinfo($oldPath);
            $directory = $pathInfo['dirname'] ?? '';
            
            // Upload new file
            $newFilePath = $this->uploadSingleFile($newFile, $directory);
            
            // Delete old file if it exists
            if (Storage::disk($this->disk)->exists($oldPath)) {
                Storage::disk($this->disk)->delete($oldPath);
            }

            return $newFilePath;
        } catch (Exception $e) {
            throw new Exception("Media replacement failed: " . $e->getMessage());
        }
    }

    /**
     * Generate a unique filename for the uploaded file
     *
     * @param UploadedFile $file
     * @return string
     */
    private function generateUniqueFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        
        // Sanitize filename
        $filename = Str::slug($filename);
        
        // Generate unique identifier
        $uniqueId = Str::uuid();
        
        return "{$filename}_{$uniqueId}.{$extension}";
    }

    /**
     * Build full path with AWS_ROOT prefix
     *
     * @param string $path
     * @param string $filename
     * @return string
     */
    private function buildFullPath(string $path, string $filename): string
    {
        $path = trim($path, '/');
        $filename = trim($filename, '/');
        
        if (empty($this->rootPath)) {
            return $path ? "{$path}/{$filename}" : $filename;
        }
        
        $rootPath = trim($this->rootPath, '/');
        return $path ? "{$rootPath}/{$path}/{$filename}" : "{$rootPath}/{$filename}";
    }

    /**
     * Get the public URL for a file
     *
     * @param string $path
     * @return string
     */
    public function getFileUrl(string $path): string
    {
        return Storage::disk($this->disk)->url($path);
    }

    /**
     * Delete a file from S3
     *
     * @param string $path
     * @return bool
     */
    public function deleteFile(string $path): bool
    {
        try {
            return Storage::disk($this->disk)->delete($path);
        } catch (Exception $e) {
            \Log::error("Failed to delete file from S3", [
                'path' => $path,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Check if file exists in S3
     *
     * @param string $path
     * @return bool
     */
    public function fileExists(string $path): bool
    {
        return Storage::disk($this->disk)->exists($path);
    }
}
