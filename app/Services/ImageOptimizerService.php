<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageOptimizerService
{
    /**
     * Kompres dan simpan gambar ke Cloud Storage / disk aktif.
     * Mengubah format gambar ke WebP (atau JPEG) dengan resolusi ideal web.
     *
     * @param UploadedFile $file Berkas unggahan
     * @param string $directory Direktori tujuan (misal: 'uploads/packages')
     * @param string|null $filename Nama berkas kustom tanpa ekstensi (opsional)
     * @param int $maxDimension Batas lebar/tinggi maksimum piksel (default 1920)
     * @param int $quality Kualitas kompresi 0-100 (default 82)
     * @return array Hasil penyimpanan: ['path' => ..., 'url' => ..., 'original_size' => ..., 'optimized_size' => ...]
     */
    public static function optimizeAndStore(
        UploadedFile $file,
        string $directory,
        ?string $filename = null,
        int $maxDimension = 1920,
        int $quality = 82
    ): array {
        $diskName = config('filesystems.default');
        $disk = Storage::disk($diskName);
        $originalSize = $file->getSize();
        $mime = $file->getMimeType();
        $originalName = $file->getClientOriginalName();

        // 1. Berkas non-raster seperti SVG / ICO: simpan langsung tanpa kompresi
        if (in_array($mime, ['image/svg+xml', 'image/x-icon', 'image/vnd.microsoft.icon'], true)) {
            $ext = $file->getClientOriginalExtension() ?: 'ico';
            $safeName = ($filename ?: Str::random(20)) . '.' . $ext;
            $path = $file->storeAs($directory, $safeName, $diskName);
            $url = self::getPublicUrl($path);

            Log::info("Penyimpanan berkas ikon [{$originalName}]: {$path} (Ukuran: " . round($originalSize / 1024, 1) . " KB)");

            return [
                'path' => $path,
                'url' => $url,
                'original_size' => $originalSize,
                'optimized_size' => $originalSize,
            ];
        }

        // 2. Coba optimasi gambar menggunakan GD
        try {
            $binary = file_get_contents($file->getRealPath());
            $src = @imagecreatefromstring($binary);

            if (!$src) {
                throw new \RuntimeException("Format gambar tidak didukung oleh pustaka PHP GD.");
            }

            // Putar orientasi jika ada metadata EXIF kamera/HP
            if (function_exists('exif_read_data')) {
                $exif = @exif_read_data($file->getRealPath());
                if (!empty($exif['Orientation'])) {
                    switch ($exif['Orientation']) {
                        case 3:
                            $src = imagerotate($src, 180, 0);
                            break;
                        case 6:
                            $src = imagerotate($src, -90, 0);
                            break;
                        case 8:
                            $src = imagerotate($src, 90, 0);
                            break;
                    }
                }
            }

            $w = imagesx($src);
            $h = imagesy($src);

            // Hitung skala resolusi proporsional
            if ($w > $maxDimension || $h > $maxDimension) {
                if ($w > $h) {
                    $newW = $maxDimension;
                    $newH = (int) round($h * ($maxDimension / $w));
                } else {
                    $newH = $maxDimension;
                    $newW = (int) round($w * ($maxDimension / $h));
                }
            } else {
                $newW = $w;
                $newH = $h;
            }

            $dst = imagecreatetruecolor($newW, $newH);

            // Pertahankan transparansi PNG / WebP
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
            $transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);
            imagefilledrectangle($dst, 0, 0, $newW, $newH, $transparent);

            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $w, $h);

            // Output ke WebP jika didukung, atau fallback ke JPEG
            ob_start();
            if (function_exists('imagewebp')) {
                imagewebp($dst, null, $quality);
                $ext = 'webp';
            } else {
                imagejpeg($dst, null, $quality);
                $ext = 'jpg';
            }
            $optimizedData = ob_get_clean();

            imagedestroy($src);
            imagedestroy($dst);

            $optimizedSize = strlen($optimizedData);

            // Jika hasil kompresi entah bagaimana lebih besar dari berkas asli, gunakan asli
            if ($optimizedSize >= $originalSize) {
                $finalData = $binary;
                $ext = $file->getClientOriginalExtension() ?: 'jpg';
                $finalSize = $originalSize;
            } else {
                $finalData = $optimizedData;
                $finalSize = $optimizedSize;
            }

            $safeName = ($filename ?: Str::random(24)) . '.' . $ext;
            $targetPath = trim($directory, '/') . '/' . $safeName;

            // Simpan ke storage (Cloudflare R2 atau local disk)
            $stored = $disk->put($targetPath, $finalData);
            if (!$stored) {
                throw new \RuntimeException("Gagal menulis berkas ke penyimpanan Cloud Storage ({$diskName}).");
            }

            $url = self::getPublicUrl($targetPath);
            $hematPersen = $originalSize > 0 ? round((1 - ($finalSize / $originalSize)) * 100, 1) : 0;

            Log::info("Optimasi Gambar Berhasil [{$originalName}]: {$targetPath} | Ukuran: " . round($originalSize / 1024, 1) . "KB -> " . round($finalSize / 1024, 1) . "KB (Hemat {$hematPersen}%) | URL: {$url}");

            return [
                'path' => $targetPath,
                'url' => $url,
                'original_size' => $originalSize,
                'optimized_size' => $finalSize,
            ];
        } catch (\Throwable $e) {
            Log::warning("Gagal melakukan kompresi GD ({$e->getMessage()}), menggunakan fallback unggah langsung.");

            // Fallback: simpan berkas asli jika proses GD gagal
            $ext = $file->getClientOriginalExtension() ?: 'jpg';
            $safeName = ($filename ?: Str::random(24)) . '.' . $ext;
            $path = $file->storeAs($directory, $safeName, $diskName);
            $url = self::getPublicUrl($path);

            Log::info("Fallback unggah berhasil [{$originalName}]: {$path} | URL: {$url}");

            return [
                'path' => $path,
                'url' => $url,
                'original_size' => $originalSize,
                'optimized_size' => $originalSize,
            ];
        }
    }

    /**
     * Dapatkan URL publik untuk berkas media.
     * Otomatis mengarahkan ke rute proxy internal jika domain r2.dev terblokir ISP.
     */
    public static function getPublicUrl(string $path): string
    {
        $customDomain = config('filesystems.disks.s3.url');

        // Jika domain S3 masih r2.dev (sering terblokir ISP lokal) atau /media, layani via proxy internal
        if (empty($customDomain) || Str::contains($customDomain, '.r2.dev') || $customDomain === '/media') {
            return url('/media/' . ltrim($path, '/'));
        }

        return rtrim($customDomain, '/') . '/' . ltrim($path, '/');
    }

    /**
     * Hapus berkas lama dari storage jika ada.
     *
     * @param string|null $urlOrPath URL lengkap atau path relatif
     * @param string $prefixFolder Folder awalan aman (misal: 'uploads/packages/')
     * @return bool
     */
    public static function deleteOldImage(?string $urlOrPath, string $prefixFolder): bool
    {
        if (empty($urlOrPath)) {
            return false;
        }

        try {
            $parsed = parse_url($urlOrPath, PHP_URL_PATH);
            $relPath = ltrim($parsed, '/');

            // Tangani URL proxy yang diawali media/
            if (Str::startsWith($relPath, 'media/')) {
                $relPath = substr($relPath, 6);
            }

            if (Str::startsWith($relPath, trim($prefixFolder, '/') . '/')) {
                $disk = Storage::disk(config('filesystems.default'));
                if ($disk->exists($relPath)) {
                    $deleted = $disk->delete($relPath);
                    Log::info("Berkas lama berhasil dihapus dari storage: {$relPath}");
                    return $deleted;
                }
            }
        } catch (\Throwable $e) {
            Log::warning("Peringatan saat menghapus berkas lama [{$urlOrPath}]: " . $e->getMessage());
        }

        return false;
    }
}
