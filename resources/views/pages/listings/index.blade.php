@extends('layouts.site', ['title' => 'Listings'])

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8 lg:py-12">
        <div class="rounded-3xl border border-brand-200/80 bg-white p-5 shadow-sm sm:p-6 lg:p-8">
            <form method="get" action="{{ route('listings.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <input type="hidden" name="tab" value="{{ $activeTab }}" />
                @include('pages.listings.partials.hidden-search-presets')
                <label for="listing-search" class="sr-only">What are you looking for?</label>
                <input
                    id="listing-search"
                    name="q"
                    type="search"
                    value="{{ $filters['q'] }}"
                    placeholder="What are you looking for?"
                    class="w-full rounded-2xl border border-brand-200/90 bg-white px-5 py-3.5 text-sm text-zinc-800 shadow-sm focus:border-[#00A651] focus:outline-none focus:ring-4 focus:ring-[#00A651]/15"
                />
                <button type="submit" class="inline-flex shrink-0 items-center justify-center rounded-2xl bg-brand-900 px-5 py-3.5 text-sm font-bold text-white hover:bg-black">
                    Search
                </button>
            </form>

            <div class="mt-5 grid grid-cols-2 gap-2.5 sm:grid-cols-3 lg:grid-cols-5">
                <a href="{{ route('listings.advert.create') }}" class="rounded-xl border border-brand-200 bg-brand-50 px-3 py-2.5 text-center text-xs font-semibold text-brand-900 hover:bg-brand-100">Post advert</a>
                <a href="{{ route('listings.found.create') }}" class="rounded-xl border border-brand-200 bg-emerald-50 px-3 py-2.5 text-center text-xs font-semibold text-emerald-800 hover:bg-emerald-100">Post found item</a>
                <a href="{{ route('listings.lost.create') }}" class="rounded-xl border border-brand-200 bg-white px-3 py-2.5 text-center text-xs font-semibold text-brand-900 hover:bg-brand-50">Report lost item</a>
                <a href="{{ route('listings.sale.create') }}" class="rounded-xl border border-brand-200 bg-blue-50 px-3 py-2.5 text-center text-xs font-semibold text-blue-700 hover:bg-blue-100">Sell a product</a>
                <a href="{{ route('listings.rental.create') }}" class="rounded-xl border border-brand-200 bg-amber-50 px-3 py-2.5 text-center text-xs font-semibold text-amber-700 hover:bg-amber-100">Rent an asset</a>
            </div>
        </div>

        <div class="mt-8">
            <div class="-mx-4 overflow-x-auto px-4 sm:mx-0 sm:px-0">
                <nav class="inline-flex min-w-full gap-2 pb-2" aria-label="Listing categories">
                    @foreach ($tabs as $key => $label)
                        <a href="{{ route('listings.index', array_merge($filterQuery, ['tab' => $key])) }}" @class([
                            'whitespace-nowrap rounded-full border px-4 py-2 text-sm font-semibold transition',
                            'border-brand-900 bg-brand-900 text-white' => $activeTab === $key,
                            'border-brand-200 bg-white text-zinc-700 hover:bg-brand-50' => $activeTab !== $key,
                        ])>{{ $label }}</a>
                    @endforeach
                </nav>
            </div>
        </div>

        <div class="mt-7 grid gap-6 md:grid-cols-[260px_1fr] lg:grid-cols-[280px_1fr]">
            <aside class="hidden h-fit rounded-2xl border border-brand-200 bg-white p-5 shadow-sm md:block md:sticky md:top-24">
                <h2 class="text-sm font-bold uppercase tracking-widest text-brand-700">Filters</h2>
                <form method="get" action="{{ route('listings.index') }}" class="mt-4 space-y-4 text-sm">
                    @if ($filters['q'] !== '')
                        <input type="hidden" name="q" value="{{ $filters['q'] }}" />
                    @endif
                    <div>
                        <label class="mb-1 block font-semibold text-zinc-700" for="filter-category">Category</label>
                        <select id="filter-category" name="tab" class="w-full rounded-xl border border-brand-200 bg-white px-3 py-2" onchange="this.form.submit()">
                            <option value="all" @selected($activeTab === 'all')>All</option>
                            <option value="advert" @selected($activeTab === 'advert')>Advert</option>
                            <option value="lost-found" @selected($activeTab === 'lost-found')>Lost &amp; Found</option>
                            <option value="sale" @selected($activeTab === 'sale')>For Sale</option>
                            <option value="rental" @selected($activeTab === 'rental')>Rentals</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block font-semibold text-zinc-700" for="filter-location">Location</label>
                        <input id="filter-location" name="location" value="{{ $filters['location'] }}" class="w-full rounded-xl border border-brand-200 px-3 py-2" placeholder="e.g. Rubavu" />
                    </div>
                    <div>
                        <label class="mb-1 block font-semibold text-zinc-700" for="filter-price">Price text</label>
                        <input id="filter-price" name="price_hint" value="{{ $filters['price_hint'] }}" class="w-full rounded-xl border border-brand-200 px-3 py-2" placeholder="e.g. RWF, 50000" />
                    </div>
                    <div>
                        <label class="mb-1 block font-semibold text-zinc-700" for="filter-posted">Date posted</label>
                        <select id="filter-posted" name="posted" class="w-full rounded-xl border border-brand-200 bg-white px-3 py-2">
                            <option value="" @selected($filters['posted'] === '')>Any time</option>
                            <option value="today" @selected($filters['posted'] === 'today')>Today</option>
                            <option value="week" @selected($filters['posted'] === 'week')>This week</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block font-semibold text-zinc-700" for="filter-condition">Condition (products)</label>
                        <select id="filter-condition" name="condition" class="w-full rounded-xl border border-brand-200 bg-white px-3 py-2">
                            <option value="" @selected($filters['condition'] === '')>Any</option>
                            <option value="new" @selected($filters['condition'] === 'new')>New</option>
                            <option value="used" @selected($filters['condition'] === 'used')>Used</option>
                            <option value="refurbished" @selected($filters['condition'] === 'refurbished')>Refurbished</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block font-semibold text-zinc-700" for="filter-rental">Rental period (in price text)</label>
                        <select id="filter-rental" name="rental_period" class="w-full rounded-xl border border-brand-200 bg-white px-3 py-2">
                            <option value="" @selected($filters['rental_period'] === '')>Any</option>
                            <option value="day" @selected($filters['rental_period'] === 'day')>Per day</option>
                            <option value="week" @selected($filters['rental_period'] === 'week')>Per week</option>
                            <option value="month" @selected($filters['rental_period'] === 'month')>Per month</option>
                        </select>
                    </div>
                    <div class="flex flex-wrap gap-2 pt-1">
                        <button type="submit" class="rounded-full bg-brand-900 px-4 py-2 text-xs font-bold text-white hover:bg-black">Apply filters</button>
                        <a href="{{ route('listings.index', ['tab' => $activeTab]) }}" class="inline-flex items-center rounded-full border border-brand-200 px-4 py-2 text-xs font-semibold text-zinc-700 hover:bg-brand-50">Clear</a>
                    </div>
                </form>
            </aside>

            <div>
                <details class="rounded-2xl border border-brand-200 bg-white p-4 shadow-sm md:hidden">
                    <summary class="cursor-pointer list-none text-sm font-semibold text-brand-900 [&::-webkit-details-marker]:hidden">Filters ▾</summary>
                    <form method="get" action="{{ route('listings.index') }}" class="mt-4 grid gap-3 text-sm sm:grid-cols-2">
                        @if ($filters['q'] !== '')
                            <input type="hidden" name="q" value="{{ $filters['q'] }}" />
                        @endif
                        <select name="tab" class="rounded-xl border border-brand-200 bg-white px-3 py-2 sm:col-span-2" onchange="this.form.submit()">
                            <option value="all" @selected($activeTab === 'all')>Category: All</option>
                            <option value="advert" @selected($activeTab === 'advert')>Category: Advert</option>
                            <option value="lost-found" @selected($activeTab === 'lost-found')>Category: Lost &amp; Found</option>
                            <option value="sale" @selected($activeTab === 'sale')>Category: For Sale</option>
                            <option value="rental" @selected($activeTab === 'rental')>Category: Rentals</option>
                        </select>
                        <input name="location" value="{{ $filters['location'] }}" class="rounded-xl border border-brand-200 px-3 py-2" placeholder="Location" />
                        <input name="price_hint" value="{{ $filters['price_hint'] }}" class="rounded-xl border border-brand-200 px-3 py-2" placeholder="Price text" />
                        <select name="posted" class="rounded-xl border border-brand-200 bg-white px-3 py-2">
                            <option value="" @selected($filters['posted'] === '')>Date posted</option>
                            <option value="today" @selected($filters['posted'] === 'today')>Today</option>
                            <option value="week" @selected($filters['posted'] === 'week')>This week</option>
                        </select>
                        <select name="condition" class="rounded-xl border border-brand-200 bg-white px-3 py-2">
                            <option value="" @selected($filters['condition'] === '')>Condition</option>
                            <option value="new" @selected($filters['condition'] === 'new')>New</option>
                            <option value="used" @selected($filters['condition'] === 'used')>Used</option>
                            <option value="refurbished" @selected($filters['condition'] === 'refurbished')>Refurbished</option>
                        </select>
                        <select name="rental_period" class="rounded-xl border border-brand-200 bg-white px-3 py-2 sm:col-span-2">
                            <option value="" @selected($filters['rental_period'] === '')>Rental period</option>
                            <option value="day" @selected($filters['rental_period'] === 'day')>Per day</option>
                            <option value="week" @selected($filters['rental_period'] === 'week')>Per week</option>
                            <option value="month" @selected($filters['rental_period'] === 'month')>Per month</option>
                        </select>
                        <div class="flex flex-wrap gap-2 sm:col-span-2">
                            <button type="submit" class="rounded-full bg-brand-900 px-4 py-2 text-xs font-bold text-white hover:bg-black">Apply</button>
                            <a href="{{ route('listings.index', ['tab' => $activeTab]) }}" class="inline-flex items-center rounded-full border border-brand-200 px-4 py-2 text-xs font-semibold text-zinc-700">Clear</a>
                        </div>
                    </form>
                </details>

                <div class="mt-5 grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                    @forelse ($listings as $item)
                        <a href="{{ route('listings.show', $item['id']) }}" class="block overflow-hidden rounded-2xl border border-brand-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <article>
                                <img src="{{ site_image($item['image']) }}" alt="{{ $item['title'] }}" class="h-40 w-full object-cover" loading="lazy" />
                                <div class="p-4">
                                    <div class="mb-2 flex items-center justify-between gap-2">
                                        <span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $item['badgeClass'] }}">{{ $item['badge'] }}</span>
                                        <span class="text-xs text-zinc-500">{{ $item['posted'] }}</span>
                                    </div>
                                    <h3 class="text-sm font-bold leading-snug text-zinc-900">{{ $item['title'] }}</h3>
                                    <p class="mt-2 text-sm font-semibold text-brand-900">{{ $item['price'] ?? 'Contact for details' }}</p>
                                    <p class="mt-1 text-xs text-zinc-600">📍 {{ $item['location'] }}</p>
                                    <p class="mt-3 text-xs font-bold text-brand-800">View &amp; comment →</p>
                                </div>
                            </article>
                        </a>
                    @empty
                        <p class="rounded-xl border border-brand-200 bg-brand-50 px-4 py-6 text-sm text-zinc-600 sm:col-span-2 xl:col-span-3">No listings match your filters. Try clearing filters or choosing another category.</p>
                    @endforelse
                </div>

                @if ($listings->hasPages())
                    <div class="mt-8">
                        {{ $listings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>

    <div class="fixed bottom-5 right-5 z-40 flex flex-col items-end gap-2">
        <details class="group rounded-2xl border border-brand-200 bg-white shadow-xl shadow-zinc-900/10">
            <summary class="list-none cursor-pointer rounded-2xl bg-accent-500 px-5 py-3 text-sm font-bold text-white shadow-lg transition hover:bg-accent-600 [&::-webkit-details-marker]:hidden">
                + Post
            </summary>
            <div class="flex min-w-[12rem] flex-col gap-0.5 border-t border-brand-100 p-2 text-sm">
                <a href="{{ route('listings.advert.create') }}" class="rounded-xl px-3 py-2 font-semibold text-zinc-800 hover:bg-brand-50">Advert</a>
                <a href="{{ route('listings.found.create') }}" class="rounded-xl px-3 py-2 font-semibold text-zinc-800 hover:bg-brand-50">Found item</a>
                <a href="{{ route('listings.lost.create') }}" class="rounded-xl px-3 py-2 font-semibold text-zinc-800 hover:bg-brand-50">Lost item</a>
                <a href="{{ route('listings.sale.create') }}" class="rounded-xl px-3 py-2 font-semibold text-zinc-800 hover:bg-brand-50">Sell product</a>
                <a href="{{ route('listings.rental.create') }}" class="rounded-xl px-3 py-2 font-semibold text-zinc-800 hover:bg-brand-50">Rent asset</a>
            </div>
        </details>
    </div>
@endsection
