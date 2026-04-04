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
     * Uses root-relative URLs for files under public/images and /storage so localhost works when
     * APP_URL is wrong (e.g. http://localhost without :8000 while using artisan serve).
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

        $imagesBase = trim(config('images.content_path', 'images'), '/');
        $fullPublic = public_path($imagesBase.'/'.$path);

        if (Storage::disk('listing_images')->exists($path) || is_file($fullPublic)) {
            return '/'.$imagesBase.'/'.$path;
        }

        if (Storage::disk('public')->exists($path)) {
            return '/storage/'.$path;
        }

        return site_image('logo.png');
    }
}
