<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

/**
 * Faza 1: optimizacija blog bannera prije spremanja u public/uploads/blog-images/.
 * Koristi PHP GD (bez dodatnog Composer paketa). GIF/SVG se ne obrađuju — samo se premjeste kao prije.
 */
class BlogImageService
{
    public const MAX_WIDTH = 1920;

    private const JPEG_QUALITY = 85;

    private const PNG_COMPRESSION = 6;

    private const UPLOAD_SUBDIR = 'blog-images';

    /**
     * Sprema upload u uploads/blog-images i vraća ime datoteke za blogs.image.
     */
    public function storeProcessed(UploadedFile $file): string
    {
        $mime = strtolower((string) $file->getMimeType());
        $ext = strtolower($file->getClientOriginalExtension());

        if ($this->shouldStoreUnmodified($mime, $ext)) {
            return $this->storeUnmodified($file);
        }

        $dir = public_path('uploads/' . self::UPLOAD_SUBDIR);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        try {
            if ($this->isPng($mime, $ext)) {
                $filename = time() . '.png';
                $dest = $dir . DIRECTORY_SEPARATOR . $filename;
                if ($this->writeOptimizedPng($file->getRealPath(), $dest)) {
                    return $filename;
                }

                return $this->storeUnmodified($file);
            }

            $filename = time() . '.jpg';
            $dest = $dir . DIRECTORY_SEPARATOR . $filename;
            if ($this->writeOptimizedJpeg($file->getRealPath(), $dest)) {
                return $filename;
            }

            return $this->storeUnmodified($file);
        } catch (\Throwable $e) {
            Log::error('BlogImageService: neočekivana greška pri obradi slike', [
                'message' => $e->getMessage(),
                'original' => $file->getClientOriginalName(),
            ]);

            return $this->storeUnmodified($file);
        }
    }

    private function shouldStoreUnmodified(string $mime, string $ext): bool
    {
        if ($ext === 'gif' || str_contains($mime, 'gif')) {
            return true;
        }

        return $ext === 'svg' || str_contains($mime, 'svg');
    }

    private function isPng(string $mime, string $ext): bool
    {
        return $ext === 'png' || str_contains($mime, 'png');
    }

    private function storeUnmodified(UploadedFile $file): string
    {
        $imageName = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/' . self::UPLOAD_SUBDIR), $imageName);

        return $imageName;
    }

    private function writeOptimizedJpeg(string $sourcePath, string $destPath): bool
    {
        if (!function_exists('imagecreatefromjpeg') || !function_exists('imagejpeg')) {
            Log::warning('BlogImageService: GD JPEG funkcije nisu dostupne');

            return false;
        }

        $image = @imagecreatefromjpeg($sourcePath);
        if ($image === false) {
            return false;
        }

        try {
            $image = $this->scaleDownWidth($image);
            if ($image === false) {
                return false;
            }

            return imagejpeg($image, $destPath, self::JPEG_QUALITY);
        } finally {
            if ($image !== false && (is_object($image) || is_resource($image))) {
                imagedestroy($image);
            }
        }
    }

    private function writeOptimizedPng(string $sourcePath, string $destPath): bool
    {
        if (!function_exists('imagecreatefrompng') || !function_exists('imagepng')) {
            Log::warning('BlogImageService: GD PNG funkcije nisu dostupne');

            return false;
        }

        $image = @imagecreatefrompng($sourcePath);
        if ($image === false) {
            return false;
        }

        imagesavealpha($image, true);

        try {
            $image = $this->scaleDownWidth($image);
            if ($image === false) {
                return false;
            }

            imagesavealpha($image, true);

            return imagepng($image, $destPath, self::PNG_COMPRESSION);
        } finally {
            if ($image !== false && (is_object($image) || is_resource($image))) {
                imagedestroy($image);
            }
        }
    }

    /**
     * @param \GdImage|resource $image
     * @return \GdImage|resource|false
     */
    private function scaleDownWidth($image)
    {
        $width = imagesx($image);
        $height = imagesy($image);

        if ($width <= self::MAX_WIDTH) {
            return $image;
        }

        $newWidth = self::MAX_WIDTH;
        $newHeight = (int) round($height * (self::MAX_WIDTH / $width));
        $scaled = imagescale($image, $newWidth, $newHeight);
        imagedestroy($image);

        return $scaled !== false ? $scaled : false;
    }
}
