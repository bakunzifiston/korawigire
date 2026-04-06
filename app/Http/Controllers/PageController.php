<?php

namespace App\Http\Controllers;

use App\Models\GalleryCategory;
use App\Models\GalleryPhoto;
use App\Support\GalleryImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PageController extends Controller
{
    public function home()
    {
        $galleryDbPaths = Schema::hasTable('gallery_photos')
            ? GalleryPhoto::query()->pluck('path')->all()
            : [];

        $galleryPathsForHero = array_values(array_unique(array_merge(
            GalleryImages::all(),
            $galleryDbPaths,
        )));

        $preferredHeroSlides = array_values(array_filter(
            config('korawigire.hero_slide_images', []),
            fn ($path) => is_string($path) && $path !== ''
        ));

        $heroSlides = array_values(array_filter(
            $preferredHeroSlides,
            fn (string $img) => in_array($img, $galleryPathsForHero, true)
        ));

        if (empty($heroSlides)) {
            $heroSlides = ['logo.png'];
        }

        if (Schema::hasTable('gallery_photos') && GalleryPhoto::query()->exists()) {
            $previewPhotos = GalleryPhoto::query()
                ->orderBy('sort_order')
                ->orderByDesc('id')
                ->limit(6)
                ->get();
            $galleryPreview = $previewPhotos->map(fn (GalleryPhoto $p) => [
                'path' => $p->path,
                'alt' => $p->alt_text,
            ])->all();
            $galleryCount = GalleryPhoto::query()->count();
        } else {
            $filesystem = GalleryImages::all();
            $galleryPreview = array_map(
                fn (string $p) => ['path' => $p, 'alt' => null],
                array_slice($filesystem, 0, 6)
            );
            $galleryCount = count($filesystem);
        }

        return view('pages.home', [
            'heroSlides' => $heroSlides,
            'galleryPreview' => $galleryPreview,
            'galleryCount' => $galleryCount,
        ]);
    }

    public function gallery(Request $request)
    {
        $usesDatabase = Schema::hasTable('gallery_photos') && GalleryPhoto::query()->exists();

        $categories = Schema::hasTable('gallery_categories')
            ? GalleryCategory::query()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get()
            : collect();

        $activeSlug = $request->query('category');
        if (! is_string($activeSlug) || $activeSlug === '' || ! Schema::hasTable('gallery_categories') || ! GalleryCategory::query()->where('slug', $activeSlug)->exists()) {
            $activeSlug = null;
        }

        if ($usesDatabase) {
            $query = GalleryPhoto::query()->with('category')->orderBy('sort_order')->orderByDesc('id');
            if ($activeSlug) {
                $query->whereHas('category', fn ($q) => $q->where('slug', $activeSlug));
            }
            $photos = $query->get();
            $legacyImages = [];
        } else {
            $photos = collect();
            $legacyImages = GalleryImages::all();
            $activeSlug = null;
        }

        $displayCount = $usesDatabase ? $photos->count() : count($legacyImages);

        return view('pages.gallery', [
            'usesDatabase' => $usesDatabase,
            'categories' => $categories,
            'activeCategory' => $activeSlug,
            'photos' => $photos,
            'legacyImages' => $legacyImages,
            'displayCount' => $displayCount,
        ]);
    }

    public function about()
    {
        return view('pages.about');
    }

    public function services()
    {
        return view('pages.services');
    }

    public function learning()
    {
        return view('pages.learning');
    }

    public function training()
    {
        return view('pages.training');
    }

    public function testimonials()
    {
        return view('pages.testimonials');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function form(string $slug)
    {
        $forms = [
            'radio-ad' => 'radio_ad',
            'tailoring' => 'tailoring',
            'printing' => 'printing',
            'carpentry' => 'carpentry',
            'contact' => 'contact',
        ];

        if (! isset($forms[$slug])) {
            abort(404);
        }

        return view('pages.forms.'.$slug, [
            'formType' => $forms[$slug],
        ]);
    }
}
