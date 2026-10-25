<?php

declare(strict_types=1);

namespace App\Services;

use RuntimeException;

class UploadService
{
    private static string $uploadRoot = __DIR__ . '/../../public/uploads/';

    /**
     * Upload and resize an image, converting it to WebP for optimization if GD is supported.
     *
     * @param array $file The $_FILES element
     * @param string $subFolder Subfolder inside uploads/ (e.g. 'profile', 'projects/covers', 'projects/gallery')
     * @param int $maxWidth Max width for the primary image
     * @param int $maxHeight Max height for the primary image
     * @param bool $createThumbnail Generate a smaller thumbnail
     * @return array Array containing 'image_path' and optional 'thumb_path'
     * @throws RuntimeException
     */
    public static function uploadImage(
        array $file,
        string $subFolder,
        int $maxWidth = 1200,
        int $maxHeight = 1200,
        bool $createThumbnail = false
    ): array {
        self::validateUploadError($file);

        // 1. Validate File Size (Max 5MB)
        $maxSizeBytes = 5 * 1024 * 1024;
        if ($file['size'] > $maxSizeBytes) {
            throw new RuntimeException("Ukuran gambar melebihi batas maksimal 5 MB.");
        }

        // 2. Validate MIME Type & Extension
        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/jpg'  => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp'
        ];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!array_key_exists($mimeType, $allowedTypes)) {
            throw new RuntimeException("Format berkas tidak diizinkan. Hanya menerima JPG, JPEG, PNG, dan WebP.");
        }

        $extension = $allowedTypes[$mimeType];

        // 3. Prepare Target Directories
        $targetDir = self::$uploadRoot . rtrim($subFolder, '/') . '/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // Generate Random Filename
        $filename = bin2hex(random_bytes(16));
        $destFileName = $filename . '.' . $extension;
        $destPath = $targetDir . $destFileName;

        // 4. Process and Save Image
        if (extension_loaded('gd')) {
            // Resize and save using GD to optimize
            self::resizeAndSaveImage($file['tmp_name'], $destPath, $mimeType, $maxWidth, $maxHeight);
        } else {
            // Fallback: move uploaded file directly if GD is missing
            if (!move_uploaded_file($file['tmp_name'], $destPath)) {
                throw new RuntimeException("Gagal menyimpan gambar di server.");
            }
        }

        $result = [
            'image_path' => 'uploads/' . rtrim($subFolder, '/') . '/' . $destFileName
        ];

        // 5. Optionally create a Thumbnail
        if ($createThumbnail) {
            $thumbDir = $targetDir . 'thumbs/';
            if (!is_dir($thumbDir)) {
                mkdir($thumbDir, 0755, true);
            }
            $thumbFileName = 'thumb_' . $destFileName;
            $thumbPath = $thumbDir . $thumbFileName;

            if (extension_loaded('gd')) {
                self::resizeAndSaveImage($destPath, $thumbPath, $mimeType, 300, 300);
            } else {
                copy($destPath, $thumbPath);
            }
            $result['thumb_path'] = 'uploads/' . rtrim($subFolder, '/') . '/thumbs/' . $thumbFileName;
        }

        return $result;
    }

    /**
     * Upload a PDF document (specifically for CV).
     */
    public static function uploadPdf(array $file, string $subFolder = 'documents'): string
    {
        self::validateUploadError($file);

        // Validate File Size (Max 10MB)
        $maxSizeBytes = 10 * 1024 * 1024;
        if ($file['size'] > $maxSizeBytes) {
            throw new RuntimeException("Ukuran berkas melebihi batas maksimal 10 MB.");
        }

        // Validate MIME Type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if ($mimeType !== 'application/pdf') {
            throw new RuntimeException("Format berkas tidak diizinkan. Hanya berkas PDF yang diterima.");
        }

        $targetDir = self::$uploadRoot . rtrim($subFolder, '/') . '/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $filename = bin2hex(random_bytes(16)) . '.pdf';
        $destPath = $targetDir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destPath)) {
            throw new RuntimeException("Gagal menyimpan berkas PDF di server.");
        }

        return 'uploads/' . rtrim($subFolder, '/') . '/' . $filename;
    }

    /**
     * Safely delete a file from the uploads directory.
     */
    public static function delete(string $relativePath): bool
    {
        if (empty($relativePath)) {
            return false;
        }

        // Reconstruct full path
        $fullPath = realpath(self::$uploadRoot . '/../' . ltrim($relativePath, '/'));

        // Prevent path traversal and check file existence
        if ($fullPath && str_starts_with($fullPath, realpath(self::$uploadRoot)) && is_file($fullPath)) {
            return unlink($fullPath);
        }

        return false;
    }

    /**
     * Validate upload errors from PHP $_FILES.
     */
    private static function validateUploadError(array $file): void
    {
        if (!isset($file['error']) || is_array($file['error'])) {
            throw new RuntimeException("Parameter upload tidak valid.");
        }

        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException("Tidak ada berkas yang diunggah.");
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException("Ukuran berkas melebihi batas limit konfigurasi server.");
            default:
                throw new RuntimeException("Terjadi kesalahan yang tidak dikenal saat mengunggah berkas.");
        }
    }

    /**
     * Helper to resize image keeping aspect ratio and save it.
     */
    private static function resizeAndSaveImage(
        string $sourcePath,
        string $destPath,
        string $mimeType,
        int $maxW,
        int $maxH
    ): void {
        // 1. Create source image resource based on mime type
        switch ($mimeType) {
            case 'image/jpeg':
            case 'image/jpg':
                $sourceImage = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $sourceImage = imagecreatefrompng($sourcePath);
                break;
            case 'image/webp':
                $sourceImage = imagecreatefromwebp($sourcePath);
                break;
            default:
                throw new RuntimeException("Unsupported image type for GD processing.");
        }

        if (!$sourceImage) {
            throw new RuntimeException("Gagal memproses resource gambar.");
        }

        // 2. Calculate new dimensions keeping aspect ratio
        list($origW, $origH) = getimagesize($sourcePath);
        
        $ratio = min($maxW / $origW, $maxH / $origH);
        
        if ($ratio < 1) {
            $newW = (int)($origW * $ratio);
            $newH = (int)($origH * $ratio);
        } else {
            $newW = $origW;
            $newH = $origH;
        }

        // 3. Create destination canvas
        $destImage = imagecreatetruecolor($newW, $newH);

        // Handle transparency for PNG and WebP
        if ($mimeType === 'image/png' || $mimeType === 'image/webp') {
            imagealphablending($destImage, false);
            imagesavealpha($destImage, true);
            $transparent = imagecolorallocatealpha($destImage, 255, 255, 255, 127);
            imagefilledrectangle($destImage, 0, 0, $newW, $newH, $transparent);
        }

        // 4. Perform resize copy
        imagecopyresampled($destImage, $sourceImage, 0, 0, 0, 0, $newW, $newH, $origW, $origH);

        // 5. Save the resized image to destination path
        switch ($mimeType) {
            case 'image/jpeg':
            case 'image/jpg':
                imagejpeg($destImage, $destPath, 85); // 85 quality
                break;
            case 'image/png':
                imagepng($destImage, $destPath, 6); // 6 compression level (0-9)
                break;
            case 'image/webp':
                imagewebp($destImage, $destPath, 80); // 80 quality
                break;
        }

        // 6. Free up memory
        imagedestroy($sourceImage);
        imagedestroy($destImage);
    }
}
