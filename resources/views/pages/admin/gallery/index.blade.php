@extends('layouts.site', ['title' => 'Gallery admin'])

@section('content')
    @include('partials.page-hero', [
        'title' => 'Gallery',
        'subtitle' => 'Categories and photos shown on the public gallery page (with filters).',
        'compact' => true,
    ])

    <section class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
        @endif

        @include('partials.listings-admin-nav')

        <p class="mb-8 text-sm leading-relaxed text-zinc-600">
            Add a <strong>category</strong> first, then upload photos into it. On the site, visitors can filter by category.
            If no managed photos exist yet, the gallery still shows images from <code class="rounded bg-brand-50 px-1.5 py-0.5 text-xs text-brand-900">public/images/gallery/</code> until you upload here.
        </p>

        <div class="grid gap-10 lg:grid-cols-2">
            <div class="rounded-2xl border border-brand-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-bold text-brand-900">New category</h2>
                <form method="post" action="{{ route('admin.gallery.categories.store') }}" class="mt-4 space-y-4">
                    @csrf
                    <div>
                        <label for="cat-name" class="block text-sm font-semibold text-zinc-700">Name</label>
                        <input
                            id="cat-name"
                            name="name"
                            type="text"
                            required
                            maxlength="120"
                            value="{{ old('name') }}"
                            class="mt-1 w-full rounded-xl border border-brand-200 px-4 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/25"
                            placeholder="e.g. Events, Training, Radio"
                        />
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="rounded-full bg-brand-900 px-6 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-black">Add category</button>
                </form>

                <h3 class="mt-8 text-sm font-bold text-zinc-800">Your categories</h3>
                <ul class="mt-3 divide-y divide-brand-100 rounded-xl border border-brand-100">
                    @forelse ($categories as $cat)
                        <li class="flex items-center justify-between gap-3 px-3 py-2.5 text-sm">
                            <span class="font-medium text-zinc-800">{{ $cat->name }} <span class="font-normal text-zinc-500">({{ $cat->photos_count }})</span></span>
                            <form method="post" action="{{ route('admin.gallery.categories.destroy', $cat) }}" onsubmit="return confirm('Delete this category and all of its photos?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-full border border-red-200 bg-white px-3 py-1 text-xs font-semibold text-red-700 hover:bg-red-50">Delete</button>
                            </form>
                        </li>
                    @empty
                        <li class="px-3 py-4 text-sm text-zinc-500">No categories yet — add one above.</li>
                    @endforelse
                </ul>
            </div>

            <div class="rounded-2xl border border-brand-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-bold text-brand-900">Upload photos</h2>
                @if ($categories->isEmpty())
                    <p class="mt-4 text-sm text-amber-800">Create a category before uploading.</p>
                @else
                    <form method="post" action="{{ route('admin.gallery.photos.store') }}" enctype="multipart/form-data" class="mt-4 space-y-4">
                        @csrf
                        <div>
                            <label for="gallery_category_id" class="block text-sm font-semibold text-zinc-700">Category</label>
                            <select
                                id="gallery_category_id"
                                name="gallery_category_id"
                                required
                                class="mt-1 w-full rounded-xl border border-brand-200 px-4 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/25"
                            >
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" @selected((string) old('gallery_category_id') === (string) $cat->id)>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('gallery_category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="images" class="block text-sm font-semibold text-zinc-700">Images</label>
                            <input
                                id="images"
                                name="images[]"
                                type="file"
                                accept="image/*"
                                multiple
                                required
                                class="mt-1 block w-full text-sm text-zinc-600 file:mr-3 file:rounded-full file:border-0 file:bg-brand-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-black"
                            />
                            <p class="mt-1 text-xs text-zinc-500">You can select more than one photo and upload them together.</p>
                            @error('images')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('images.*')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="alt_text" class="block text-sm font-semibold text-zinc-700">Caption / alt text (optional)</label>
                            <input
                                id="alt_text"
                                name="alt_text"
                                type="text"
                                maxlength="255"
                                value="{{ old('alt_text') }}"
                                class="mt-1 w-full rounded-xl border border-brand-200 px-4 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/25"
                            />
                            @error('alt_text')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="rounded-full bg-brand-900 px-6 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-black">Upload photos</button>
                    </form>
                @endif
            </div>
        </div>

        <div class="mt-12">
            <h2 class="text-lg font-bold text-brand-900">Recent photos</h2>
            <ul class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($photos as $photo)
                    <li class="overflow-hidden rounded-2xl border border-brand-200 bg-white shadow-sm">
                        <div class="aspect-square w-full overflow-hidden bg-brand-50">
                            <img src="{{ site_image($photo->path) }}" alt="{{ $photo->alt_text ?? '' }}" class="h-full w-full object-cover" loading="lazy" />
                        </div>
                        <div class="flex items-start justify-between gap-2 border-t border-brand-100 p-3 text-xs">
                            <span class="font-semibold text-zinc-800">{{ $photo->category->name ?? '—' }}</span>
                            <form method="post" action="{{ route('admin.gallery.photos.destroy', $photo) }}" onsubmit="return confirm('Remove this photo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-full border border-red-200 px-2.5 py-1 font-semibold text-red-700 hover:bg-red-50">Remove</button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="col-span-full rounded-xl border border-dashed border-brand-200 bg-brand-50/50 px-4 py-8 text-center text-sm text-zinc-600">No uploaded photos yet.</li>
                @endforelse
            </ul>
        </div>
    </section>
@endsection
