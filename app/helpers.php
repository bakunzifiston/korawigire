<?php

use App\Support\SiteImages;

if (! function_exists('site_image')) {
    /**
     * Public URL for a file under public/images/ (or images.content_path).
     *
     * @param  string  $path  Relative path, e.g. "gallery/photo.jpg" or "logo.png"
     */
    function site_image(string $path): string
    {
        return SiteImages::url($path);
    }
}
