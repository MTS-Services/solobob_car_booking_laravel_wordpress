<?php

namespace App\Services\FileUpload;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Exception;

class FileUploadService
{
    /**
     * Upload a file to storage
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string $disk
     * @param bool $preserveOriginalName
     * @return string Path to uploaded file
     */
    public function upload(
        UploadedFile $file,
        string $directory = 'uploads',
        string $disk = 'public',
        bool $preserveOriginalName = false
    ): string {
        $filename = $preserveOriginalName 
            ? $this->sanitizeFilename($file->getClientOriginalName())
            : $this->generateFilename($file);
        
        $path = $directory . '/' . $filename;

        Storage::disk($disk)->putFileAs($directory, $file, $filename);

        return $path;
    }

    /**
     * Upload an image with optional resizing using GD library
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param int|null $width
     * @param int|null $height
     * @param string $disk
     * @param bool $maintainAspectRatio
     * @return string Path to uploaded file
     */
    public function uploadImage(
        UploadedFile $file,
        string $directory = 'images',
        ?int $width = null,
        ?int $height = null,
        string $disk = 'public',
        bool $maintainAspectRatio = true
    ): string {
        $filename = $this->generateFilename($file);
        $path = $directory . '/' . $filename;

        if ($width || $height) {
            $resizedImage = $this->resizeImage($file, $width, $height, $maintainAspectRatio);
            Storage::disk($disk)->put($path, $resizedImage);
        } else {
            Storage::disk($disk)->putFileAs($directory, $file, $filename);
        }

        return $path;
    }

    /**
     * Resize image using GD library
     *
     * @param UploadedFile $file
     * @param int|null $width
     * @param int|null $height
     * @param bool $maintainAspectRatio
     * @return string Binary image data
     * @throws Exception
     */
    protected function resizeImage(
        UploadedFile $file,
        ?int $width,
        ?int $height,
        bool $maintainAspectRatio = true
    ): string {
        $mimeType = $file->getMimeType();
        
        // Create image resource from uploaded file
        $sourceImage = match($mimeType) {
            'image/jpeg', 'image/jpg' => imagecreatefromjpeg($file->getRealPath()),
            'image/png' => imagecreatefrompng($file->getRealPath()),
            'image/gif' => imagecreatefromgif($file->getRealPath()),
            'image/webp' => imagecreatefromwebp($file->getRealPath()),
            default => throw new Exception("Unsupported image type: {$mimeType}")
        };

        if (!$sourceImage) {
            throw new Exception("Failed to create image resource");
        }

        // Get original dimensions
        $originalWidth = imagesx($sourceImage);
        $originalHeight = imagesy($sourceImage);

        // Calculate new dimensions
        [$newWidth, $newHeight] = $this->calculateDimensions(
            $originalWidth,
            $originalHeight,
            $width,
            $height,
            $maintainAspectRatio
        );

        // Create new image with transparent background for PNG
        $destinationImage = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG and GIF
        if (in_array($mimeType, ['image/png', 'image/gif'])) {
            imagealphablending($destinationImage, false);
            imagesavealpha($destinationImage, true);
            $transparent = imagecolorallocatealpha($destinationImage, 255, 255, 255, 127);
            imagefilledrectangle($destinationImage, 0, 0, $newWidth, $newHeight, $transparent);
        }

        // Resample the image
        imagecopyresampled(
            $destinationImage,
            $sourceImage,
            0, 0, 0, 0,
            $newWidth,
            $newHeight,
            $originalWidth,
            $originalHeight
        );

        // Start output buffering
        ob_start();

        // Output image based on original format
        switch ($mimeType) {
            case 'image/jpeg':
            case 'image/jpg':
                imagejpeg($destinationImage, null, 90);
                break;
            case 'image/png':
                imagepng($destinationImage, null, 9);
                break;
            case 'image/gif':
                imagegif($destinationImage);
                break;
            case 'image/webp':
                imagewebp($destinationImage, null, 90);
                break;
        }

        $imageData = ob_get_clean();

        // Free up memory
        imagedestroy($sourceImage);
        imagedestroy($destinationImage);

        return $imageData;
    }

    /**
     * Calculate new dimensions maintaining aspect ratio
     *
     * @param int $originalWidth
     * @param int $originalHeight
     * @param int|null $targetWidth
     * @param int|null $targetHeight
     * @param bool $maintainAspectRatio
     * @return array [width, height]
     */
    protected function calculateDimensions(
        int $originalWidth,
        int $originalHeight,
        ?int $targetWidth,
        ?int $targetHeight,
        bool $maintainAspectRatio
    ): array {
        if (!$maintainAspectRatio && $targetWidth && $targetHeight) {
            return [$targetWidth, $targetHeight];
        }

        $ratio = $originalWidth / $originalHeight;

        if ($targetWidth && $targetHeight) {
            // Fit within both dimensions (cover/contain)
            $newWidth = $targetWidth;
            $newHeight = $targetHeight;
        } elseif ($targetWidth) {
            // Only width specified
            $newWidth = $targetWidth;
            $newHeight = (int) round($targetWidth / $ratio);
        } elseif ($targetHeight) {
            // Only height specified
            $newHeight = $targetHeight;
            $newWidth = (int) round($targetHeight * $ratio);
        } else {
            // No dimensions specified
            $newWidth = $originalWidth;
            $newHeight = $originalHeight;
        }

        return [$newWidth, $newHeight];
    }

    /**
     * Upload multiple files
     *
     * @param array $files Array of UploadedFile instances
     * @param string $directory
     * @param string $disk
     * @param bool $preserveOriginalName
     * @return array Array of file paths
     */
    public function uploadMultiple(
        array $files,
        string $directory = 'uploads',
        string $disk = 'public',
        bool $preserveOriginalName = false
    ): array {
        $uploadedPaths = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $uploadedPaths[] = $this->upload($file, $directory, $disk, $preserveOriginalName);
            }
        }

        return $uploadedPaths;
    }

    /**
     * Update an existing file (delete old, upload new)
     *
     * @param UploadedFile $file
     * @param string|null $oldPath
     * @param string $directory
     * @param string $disk
     * @param bool $preserveOriginalName
     * @return string Path to uploaded file
     */
    public function updateFile(
        UploadedFile $file,
        ?string $oldPath,
        string $directory = 'uploads',
        string $disk = 'public',
        bool $preserveOriginalName = false
    ): string {
        if ($oldPath) {
            $this->delete($oldPath, $disk);
        }

        return $this->upload($file, $directory, $disk, $preserveOriginalName);
    }

    /**
     * Update an existing image (delete old, upload new with resizing)
     *
     * @param UploadedFile $file
     * @param string|null $oldPath
     * @param string $directory
     * @param int|null $width
     * @param int|null $height
     * @param string $disk
     * @param bool $maintainAspectRatio
     * @return string Path to uploaded file
     */
    public function updateImage(
        UploadedFile $file,
        ?string $oldPath,
        string $directory = 'images',
        ?int $width = null,
        ?int $height = null,
        string $disk = 'public',
        bool $maintainAspectRatio = true
    ): string {
        if ($oldPath) {
            $this->delete($oldPath, $disk);
        }

        return $this->uploadImage($file, $directory, $width, $height, $disk, $maintainAspectRatio);
    }

    /**
     * Delete a file from storage
     *
     * @param string $path
     * @param string $disk
     * @return bool
     */
    public function delete(string $path, string $disk = 'public'): bool
    {
        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }

    /**
     * Delete multiple files from storage
     *
     * @param array $paths
     * @param string $disk
     * @return bool
     */
    public function deleteMultiple(array $paths, string $disk = 'public'): bool
    {
        $existingPaths = array_filter($paths, function ($path) use ($disk) {
            return Storage::disk($disk)->exists($path);
        });

        if (empty($existingPaths)) {
            return false;
        }

        return Storage::disk($disk)->delete($existingPaths);
    }

    /**
     * Check if a file exists
     *
     * @param string $path
     * @param string $disk
     * @return bool
     */
    public function exists(string $path, string $disk = 'public'): bool
    {
        return Storage::disk($disk)->exists($path);
    }

    /**
     * Get file size in bytes
     *
     * @param string $path
     * @param string $disk
     * @return int|false
     */
    public function getSize(string $path, string $disk = 'public')
    {
        if ($this->exists($path, $disk)) {
            return Storage::disk($disk)->size($path);
        }

        return false;
    }

    /**
     * Get file MIME type
     *
     * @param string $path
     * @param string $disk
     * @return string|false
     */
    public function getMimeType(string $path, string $disk = 'public')
    {
        if ($this->exists($path, $disk)) {
            return Storage::disk($disk)->mimeType($path);
        }

        return false;
    }

    /**
     * Move a file to a new location
     *
     * @param string $fromPath
     * @param string $toPath
     * @param string $disk
     * @return bool
     */
    public function move(string $fromPath, string $toPath, string $disk = 'public'): bool
    {
        if ($this->exists($fromPath, $disk)) {
            return Storage::disk($disk)->move($fromPath, $toPath);
        }

        return false;
    }

    /**
     * Copy a file to a new location
     *
     * @param string $fromPath
     * @param string $toPath
     * @param string $disk
     * @return bool
     */
    public function copy(string $fromPath, string $toPath, string $disk = 'public'): bool
    {
        if ($this->exists($fromPath, $disk)) {
            return Storage::disk($disk)->copy($fromPath, $toPath);
        }

        return false;
    }

    /**
     * Generate a unique filename
     *
     * @param UploadedFile $file
     * @return string
     */
    protected function generateFilename(UploadedFile $file): string
    {
        return time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    }

    /**
     * Sanitize filename to remove special characters
     *
     * @param string $filename
     * @return string
     */
    protected function sanitizeFilename(string $filename): string
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $name = pathinfo($filename, PATHINFO_FILENAME);
        
        // Remove special characters and replace spaces with underscores
        $name = preg_replace('/[^a-zA-Z0-9_-]/', '_', $name);
        $name = preg_replace('/_+/', '_', $name); // Replace multiple underscores with single
        
        return $name . '_' . uniqid() . '.' . $extension;
    }

    /**
     * Get the full URL for a file path
     *
     * @param string|null $path
     * @param string $disk
     * @return string|null
     */
    public function url(?string $path, string $disk = 'public'): ?string
    {
        if (!$path) {
            return null;
        }

        return Storage::disk($disk)->url($path);
    }

    /**
     * Download a file
     *
     * @param string $path
     * @param string|null $name
     * @param string $disk
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|false
     */
    public function download(string $path, ?string $name = null, string $disk = 'public')
    {
        if ($this->exists($path, $disk)) {
            return Storage::disk($disk)->download($path, $name);
        }

        return false;
    }

    /**
     * Get file contents
     *
     * @param string $path
     * @param string $disk
     * @return string|false
     */
    public function getContents(string $path, string $disk = 'public')
    {
        if ($this->exists($path, $disk)) {
            return Storage::disk($disk)->get($path);
        }

        return false;
    }
}