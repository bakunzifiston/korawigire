<?php

namespace App\Http\Controllers;

use App\Support\GalleryImages;

class PageController extends Controller
{
    public function home()
    {
        $gallery = GalleryImages::all();
        $preferredHeroSlides = [
            'gallery/IMG-20250602-WA0031.jpg',
            'gallery/IMG-20250602-WA0033.jpg',
            'gallery/IMG-20250602-WA0035.jpg',
            'gallery/IMG-20250602-WA0037.jpg',
            'gallery/IMG-20250602-WA0039.jpg',
        ];

        $heroSlides = array_values(array_filter(
            $preferredHeroSlides,
            fn (string $img) => in_array($img, $gallery, true)
        ));

        if (empty($heroSlides)) {
            $heroSlides = array_slice($gallery, 0, 5);
        }

        return view('pages.home', [
            'heroSlides' => $heroSlides,
            'galleryPreview' => array_slice($gallery, 0, 6),
            'galleryCount' => count($gallery),
        ]);
    }

    public function gallery()
    {
        return view('pages.gallery', [
            'images' => GalleryImages::all(),
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
