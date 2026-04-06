@extends('layouts.site', ['title' => 'Gallery'])

@section('content')
    @include('partials.page-hero', [
        'eyebrow' => 'Photos',
        'title' => 'Gallery',
        'subtitle' => 'A look at our work, training, events, and community — '.$displayCount.' '.($displayCount === 1 ? 'photo' : 'photos').'.',
    ])

    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8 lg:py-14">
        @if ($usesDatabase && $categories->isNotEmpty())
            <div class="mb-8 flex flex-wrap gap-2" aria-label="Filter by category">
                <a
                    href="{{ route('gallery') }}"
                    @class([
                        'rounded-full border px-4 py-2 text-sm font-semibold transition',
                        'border-brand-900 bg-brand-900 text-white' => $activeCategory === null,
                        'border-brand-200 bg-white text-zinc-700 hover:bg-brand-50' => $activeCategory !== null,
                    ])
                >All</a>
                @foreach ($categories as $cat)
                    <a
                        href="{{ route('gallery', ['category' => $cat->slug]) }}"
                        @class([
                            'rounded-full border px-4 py-2 text-sm font-semibold transition',
                            'border-brand-900 bg-brand-900 text-white' => $activeCategory === $cat->slug,
                            'border-brand-200 bg-white text-zinc-700 hover:bg-brand-50' => $activeCategory !== $cat->slug,
                        ])
                    >{{ $cat->name }}</a>
                @endforeach
            </div>
        @endif

        @if ($displayCount === 0)
            <p class="rounded-3xl border border-dashed border-brand-300 bg-brand-50/80 px-6 py-12 text-center leading-relaxed text-zinc-600">
                @if ($usesDatabase)
                    No photos in this category yet.@if (auth()->check() && auth()->user()->is_admin)
                        <a href="{{ route('admin.gallery.index') }}" class="font-semibold text-brand-800 underline"> Open gallery admin</a> to add some.
                    @endif
                @else
                    No images yet. Add JPG or PNG files to <code class="rounded bg-white px-2 py-0.5 text-sm text-brand-800">public/images/gallery/</code> and refresh, or upload via the staff gallery admin once you add managed photos.
                @endif
            </p>
        @else
            <ul class="grid grid-cols-3 gap-2 sm:gap-4">
                @if ($usesDatabase)
                    @foreach ($photos as $photo)
                        <li class="group overflow-hidden rounded-2xl border border-brand-200/80 bg-white shadow-md ring-1 ring-black/[0.04] transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                            <button
                                type="button"
                                class="block w-full cursor-zoom-in text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-accent-500"
                                onclick="document.getElementById('lightbox-img').src='{{ e(site_image($photo->path)) }}'; document.getElementById('lightbox').classList.remove('hidden'); document.body.classList.add('overflow-hidden');"
                            >
                                <img
                                    src="{{ site_image($photo->path) }}"
                                    alt="{{ $photo->alt_text ?? 'Kora Wigire gallery photo' }}"
                                    width="400"
                                    height="400"
                                    loading="lazy"
                                    decoding="async"
                                    class="aspect-square w-full object-cover transition duration-300 group-hover:scale-105"
                                />
                            </button>
                        </li>
                    @endforeach
                @else
                    @foreach ($legacyImages as $path)
                        <li class="group overflow-hidden rounded-2xl border border-brand-200/80 bg-white shadow-md ring-1 ring-black/[0.04] transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                            <button
                                type="button"
                                class="block w-full cursor-zoom-in text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-accent-500"
                                onclick="document.getElementById('lightbox-img').src='{{ e(site_image($path)) }}'; document.getElementById('lightbox').classList.remove('hidden'); document.body.classList.add('overflow-hidden');"
                            >
                                <img
                                    src="{{ site_image($path) }}"
                                    alt="Kora Wigire gallery photo"
                                    width="400"
                                    height="400"
                                    loading="lazy"
                                    decoding="async"
                                    class="aspect-square w-full object-cover transition duration-300 group-hover:scale-105"
                                />
                            </button>
                        </li>
                    @endforeach
                @endif
            </ul>
        @endif
    </div>

    <div
        id="lightbox"
        class="fixed inset-0 z-[100] hidden bg-black/90 p-4"
        role="dialog"
        aria-modal="true"
        aria-label="Enlarged image"
        onclick="if(event.target===this){window.kwCloseLightbox();}"
    >
        <button
            type="button"
            class="absolute right-4 top-4 rounded-full bg-white/10 px-4 py-2 text-sm font-semibold text-white hover:bg-white/20"
            onclick="window.kwCloseLightbox();"
        >
            Close
        </button>
        <div class="flex h-full items-center justify-center" onclick="event.stopPropagation();">
            <img id="lightbox-img" src="" alt="" class="max-h-full max-w-full rounded-lg object-contain shadow-2xl" />
        </div>
    </div>
    @push('scripts')
        <script>
            window.kwCloseLightbox = function () {
                document.getElementById('lightbox').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            };
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') window.kwCloseLightbox();
            });
        </script>
    @endpush
@endsection
