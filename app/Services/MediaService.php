<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class MediaService
{
    /**
     * Store uploaded files and return media paths
     *
     * @param array $files Array of UploadedFile objects
     * @param string $directory Directory to store files (e.g., 'incidents')
     * @param int $maxWidth Maximum width for images (will be resized if larger)
     * @return array Array of stored file paths
     */
    public static function storeUploadedFiles(array $files, string $directory = 'incidents', int $maxWidth = 1920): array
    {
        $storedFiles = [];
        
        foreach ($files as $file) {
            if (!$file->isValid()) {
                continue;
            }
            
            // Generate a unique filename
            $extension = $file->getClientOriginalExtension();
            $filename = Str::uuid() . '.' . $extension;
            $path = $file->storeAs($directory, $filename, 'public');
            
            // If it's an image, resize it to optimize storage
            if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $image = Image::make(storage_path('app/public/' . $path));
                
                // Resize only if image is wider than max width
                if ($image->width() > $maxWidth) {
                    $image->resize($maxWidth, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save();
                }
                
                // Convert to WebP for better compression
                $webpPath = str_replace($extension, 'webp', $path);
                $image->encode('webp', 80)->save(storage_path('app/public/' . $webpPath));
                
                // Delete original if WebP conversion was successful
                if (file_exists(storage_path('app/public/' . $webpPath))) {
                    Storage::disk('public')->delete($path);
                    $path = $webpPath;
                }
            }
            
            $storedFiles[] = [
                'path' => $path,
                'type' => $file->getClientMimeType(),
                'size' => $file->getSize(),
                'original_name' => $file->getClientOriginalName(),
                'extension' => $extension,
            ];
        }
        
        return $storedFiles;
    }
    
    /**
     * Delete files from storage
     *
     * @param array $paths Array of file paths to delete
     * @return bool True if all files were deleted successfully
     */
    public static function deleteFiles(array $paths): bool
    {
        $success = true;
        
        foreach ($paths as $path) {
            if (Storage::disk('public')->exists($path)) {
                $success = $success && Storage::disk('public')->delete($path);
                
                // Also try to delete WebP version if it exists
                $webpPath = preg_replace('/\.(jpg|jpeg|png|gif)$/i', '.webp', $path);
                if ($webpPath !== $path && Storage::disk('public')->exists($webpPath)) {
                    $success = $success && Storage::disk('public')->delete($webpPath);
                }
            }
        }
        
        return $success;
    }
    
    /**
     * Get the public URL for a stored file
     *
     * @param string $path Path to the file in storage
     * @return string Public URL
     */
    public static function getUrl(string $path): string
    {
        return Storage::disk('public')->url($path);
    }
    
    /**
     * Get the storage path for a file
     *
     * @param string $path Path to the file in storage
     * @return string Full storage path
     */
    public static function getPath(string $path): string
    {
        return storage_path('app/public/' . $path);
    }
}
