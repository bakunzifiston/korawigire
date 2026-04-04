<?php

use App\Support\SiteImages;
use Illuminate\Support\Facades\Storage;

if (! function_exists('listing_resolved_base_url')) {
    /**
     * Base URL for listing assets: uses the current HTTP request when available (correct host, port,
     * and subdirectory on cPanel), otherwise config('app.url'). If APP_URL is https:// but the request
     * is http:// (common behind proxies / cPanel), the scheme is upgraded to avoid mixed-content.
     */
    function listing_resolved_base_url(): string
    {
        $configured = rtrim((string) config('app.url'), '/');

        if (app()->bound('request')) {
            $host = request()->header('Host');
            if (is_string($host) && $host !== '') {
                $root = rtrim(request()->root(), '/');
                if ($root !== '' && str_starts_with($configured, 'https://') && str_starts_with($root, 'http://')) {
                    $root = preg_replace('#^http://#i', 'https://', $root, 1) ?? $root;
                }

                return $root;
            }
        }

        return $configured;
    }
}

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
     * Uses listing_resolved_base_url() so cPanel gets the right host, subdirectory, and https scheme.
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
        $base = listing_resolved_base_url();

        if (Storage::disk('listing_images')->exists($path) || is_file($fullPublic)) {
            return $base.'/'.$imagesBase.'/'.$path;
        }

        if (Storage::disk('public')->exists($path)) {
            return $base.'/storage/'.$path;
        }

        return site_image('logo.png');
    }
}
