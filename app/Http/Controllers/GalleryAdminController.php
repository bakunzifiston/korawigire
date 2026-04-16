<?php

namespace App\Http\Controllers;

use App\Models\GalleryCategory;
use App\Models\GalleryPhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class GalleryAdminController extends Controller
{
    public function index()
    {
        $categories = GalleryCategory::query()
            ->withCount('photos')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $photos = GalleryPhoto::query()
            ->with('category')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->limit(200)
            ->get();

        return view('pages.admin.gallery.index', [
            'categories' => $categories,
            'photos' => $photos,
        ]);
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
        ]);

        $base = Str::slug($validated['name']);
        $slug = $base;
        $n = 1;
        while (GalleryCategory::query()->where('slug', $slug)->exists()) {
            $slug = $base.'-'.(++$n);
        }

        GalleryCategory::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'sort_order' => (int) (GalleryCategory::query()->max('sort_order') ?? 0) + 1,
        ]);

        return back()->with('success', 'Category added.');
    }

    public function destroyCategory(GalleryCategory $category): RedirectResponse
    {
        $category->delete();

        return back()->with('success', 'Category and its photos were removed.');
    }

    public function storePhoto(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'gallery_category_id' => ['required', 'integer', Rule::exists('gallery_categories', 'id')],
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['required', 'image', 'max:8192'],
            'alt_text' => ['nullable', 'string', 'max:255'],
        ]);

        $sortOrder = (int) (GalleryPhoto::query()->max('sort_order') ?? 0);

        foreach ((array) $request->file('images', []) as $image) {
            if (! $image) {
                continue;
            }

            $path = $image->store('gallery/uploads', 'gallery_images');

            GalleryPhoto::create([
                'gallery_category_id' => $validated['gallery_category_id'],
                'path' => $path,
                'alt_text' => $validated['alt_text'] ?? null,
                'sort_order' => ++$sortOrder,
            ]);
        }

        $count = count((array) $request->file('images', []));

        return back()->with('success', $count === 1 ? 'Photo uploaded.' : $count.' photos uploaded.');
    }

    public function destroyPhoto(GalleryPhoto $photo): RedirectResponse
    {
        $photo->delete();

        return back()->with('success', 'Photo removed.');
    }
}
