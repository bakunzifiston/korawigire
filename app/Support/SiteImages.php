<?php

namespace App\Support;

class SiteImages
{
    /**
     * URL for a file under public/{content_path}/ (e.g. "gallery/photo.jpg" or "listings/photo.jpg").
     */
    public static function url(string $path): string
    {
        $base = trim(config('images.content_path', 'images'), '/');
        $path = ltrim($path, '/');

        // Avoid "images/images/listings/..." if a path was stored with an extra prefix
        if (str_starts_with($path, $base.'/')) {
            $path = substr($path, strlen($base) + 1);
        }

        return asset($base.'/'.$path);
    }

    /**
     * True if the file exists under public/{content_path}/.
     */
    public static function exists(string $path): bool
    {
        $base = trim(config('images.content_path', 'images'), '/');
        $path = ltrim($path, '/');
        if (str_starts_with($path, $base.'/')) {
            $path = substr($path, strlen($base) + 1);
        }

        return is_file(public_path($base.'/'.$path));
    }
}
