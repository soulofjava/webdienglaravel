<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaProxyController extends Controller
{
    /**
     * Sajikan file media yang tersimpan di Cloudflare R2 / Cloud Storage
     * melalui jalur proxy internal aplikasi untuk melewati pembatasan DNS / blokir ISP.
     */
    public function show(Request $request, string $path)
    {
        $path = ltrim($path, '/');

        // Validasi keamanan: cegah traversal directory
        if (str_contains($path, '..') || !Str::startsWith($path, ['uploads/'])) {
            abort(403, 'Akses berkas tidak diizinkan.');
        }

        $disk = Storage::disk(config('filesystems.default'));

        if (!$disk->exists($path)) {
            abort(404, 'Berkas media tidak ditemukan di penyimpanan cloud.');
        }

        $mime = $disk->mimeType($path) ?: 'application/octet-stream';
        $size = $disk->size($path);
        $lastModified = $disk->lastModified($path);
        $etag = '"' . md5($path . $lastModified) . '"';

        // HTTP Caching agresif (304 Not Modified & CDN Cache)
        if ($request->header('If-None-Match') === $etag) {
            return response('', 304, [
                'Cache-Control' => 'public, max-age=31536000, immutable',
                'ETag' => $etag,
            ]);
        }

        $stream = $disk->readStream($path);
        if ($stream === false) {
            return response($disk->get($path), 200, [
                'Content-Type' => $mime,
                'Content-Length' => $size,
                'Cache-Control' => 'public, max-age=31536000, immutable',
                'ETag' => $etag,
            ]);
        }

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
        }, 200, [
            'Content-Type' => $mime,
            'Content-Length' => $size,
            'Cache-Control' => 'public, max-age=31536000, immutable',
            'ETag' => $etag,
        ]);
    }
}
