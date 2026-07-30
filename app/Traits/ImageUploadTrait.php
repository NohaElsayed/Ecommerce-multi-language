<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ImageUploadTrait
{


    /**
     * رفع صورة واحدة
     */
    public function uploadImage(UploadedFile $file, string $folder = 'images'): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($folder, $filename, 'public');
    }

    /**
     * رفع عدة صور
     */
    public function uploadMultipleImages(array $files, string $folder = 'images'): array
    {
        $paths = [];
        foreach ($files as $file) {
            $paths[] = $this->uploadImage($file, $folder);
        }
        return $paths;
    }

    /**
     * حذف صورة
     */
    public function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * تحديث صورة (حذف القديمة ورفع الجديدة)
     */
    public function updateImage(?UploadedFile $newFile, ?string $oldPath, string $folder = 'images'): ?string
    {
        if ($newFile) {
            $this->deleteImage($oldPath);
            return $this->uploadImage($newFile, $folder);
        }
        return $oldPath;
    }
}
