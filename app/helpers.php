<?php

use App\Support\SiteImages;
use Illuminate\Support\Facades\Storage;

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

if (! function_exists('listing_image_url')) {
    /**
     * Public URL for a listing upload (paths like "listings/….jpg").
     * Prefers storage (disk public) after storage:link; falls back to legacy public/images/.
     */
    function listing_image_url(?string $path): string
    {
        if ($path === null || $path === '') {
            return site_image('logo.png');
        }

        $path = ltrim(str_replace('\\', '/', $path), '/');

        if ($path === 'logo.png' || ! str_starts_with($path, 'listings/')) {
            return site_image($path);
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }

        if (is_file(public_path('images/'.$path))) {
            return site_image($path);
        }

        return site_image('logo.png');
    }
}
