<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

class GalleryImages
{
    /**
     * Relative paths under public/images/ for each gallery file (sorted by name).
     *
     * @return list<string>
     */
    public static function all(): array
    {
        $dir = public_path('images/gallery');

        if (! is_dir($dir)) {
            return [];
        }

        return collect(File::files($dir))
            ->filter(fn (\SplFileInfo $f) => in_array(strtolower($f->getExtension()), ['jpg', 'jpeg', 'png', 'webp', 'gif'], true))
            ->sortBy(fn (\SplFileInfo $f) => $f->getFilename())
            ->values()
            ->map(fn (\SplFileInfo $f) => 'gallery/'.$f->getFilename())
            ->all();
    }
}
