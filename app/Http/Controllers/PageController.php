<?php

namespace App\Http\Controllers;

use App\Support\GalleryImages;

class PageController extends Controller
{
    public function home()
    {
        $gallery = GalleryImages::all();

        return view('pages.home', [
            'galleryPreview' => array_slice($gallery, 0, 8),
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
