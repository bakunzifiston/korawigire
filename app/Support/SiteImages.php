<?php

namespace App\Support;

class SiteImages
{
    /**
     * URL for a file under public/{content_path}/ (e.g. "gallery/photo.jpg").
     */
    public static function url(string $path): string
    {
        $base = trim(config('images.content_path', 'images'), '/');
        $path = ltrim($path, '/');

        return asset($base.'/'.$path);
    }
}
