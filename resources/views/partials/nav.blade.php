@php
    $c = config('korawigire');
    $links = [
        ['route' => 'home', 'label' => 'Home'],
        ['route' => 'about', 'label' => 'About'],
        ['route' => 'services', 'label' => 'Services'],
        ['route' => 'listings.index', 'label' => 'Listings'],
        ['route' => 'gallery', 'label' => 'Gallery'],
        ['route' => 'learning', 'label' => 'Learning'],
        ['route' => 'training', 'label' => 'Training'],
        ['route' => 'testimonials', 'label' => 'Testimonials'],
        ['route' => 'contact', 'label' => 'Contact'],
    ];
@endphp
<header class="sticky top-0 z-50 border-b border-brand-200 bg-white shadow-[0_1px_0_0_rgba(0,0,0,0.04),0_8px_24px_-8px_rgba(0,0,0,0.08)]">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3.5 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="group flex items-center gap-3 leading-tight transition-opacity hover:opacity-90">
            <img
                src="{{ site_image(config('korawigire.logo')) }}"
                width="52"
                height="52"
                alt="{{ $c['short_name'] }} logo"
                class="h-12 w-12 shrink-0 rounded-full object-cover shadow-md ring-2 ring-[#E31E24] ring-offset-2 ring-offset-white transition-transform duration-300 group-hover:scale-105"
            />
        </a>

        <nav class="hidden items-center gap-0.5 md:flex" aria-label="Primary">
            @foreach ($links as $link)
                <a
                    href="{{ route($link['route']) }}"
                    @class([
                        'rounded-full px-3.5 py-2 text-sm font-semibold transition-all duration-200',
                        'bg-brand-900 text-white shadow-md shadow-brand-900/15' => request()->routeIs($link['route']),
                        'text-zinc-600 hover:bg-brand-100/80 hover:text-brand-900' => ! request()->routeIs($link['route']),
                    ])
                >{{ $link['label'] }}</a>
            @endforeach
        </nav>

        <div class="flex flex-wrap items-center justify-end gap-2">
            @guest
                <a
                    href="{{ route('login') }}"
                    class="hidden rounded-full border border-brand-200 bg-white px-4 py-2 text-sm font-bold text-brand-900 shadow-sm transition-all duration-200 hover:border-brand-300 hover:shadow-md sm:inline-block"
                >Staff login</a>
            @endguest
            @auth
                @if (auth()->user()->is_admin)
                    <a
                        href="{{ route('listings.admin') }}"
                        class="hidden rounded-full bg-brand-900 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-black sm:inline-block"
                    >Moderate</a>
                    <a
                        href="{{ route('listings.admin.comments') }}"
                        class="hidden rounded-full border border-brand-200 bg-white px-4 py-2 text-sm font-semibold text-zinc-800 shadow-sm transition hover:bg-brand-50 sm:inline-block"
                    >Comments</a>
                    <form method="post" action="{{ route('logout') }}" class="hidden sm:inline-block">
                        @csrf
                        <button
                            type="submit"
                            class="rounded-full border border-brand-200 bg-white px-4 py-2 text-sm font-semibold text-zinc-700 shadow-sm transition hover:bg-brand-50"
                        >Log out</button>
                    </form>
                @endif
            @endauth
            <a
                href="{{ $c['ims_login_url'] }}"
                target="_blank"
                rel="noopener noreferrer"
                class="hidden rounded-full border border-brand-200 bg-white px-4 py-2 text-sm font-bold text-brand-900 shadow-sm transition-all duration-200 hover:border-brand-300 hover:shadow-md sm:inline-block"
            >IMS</a>

            <details class="relative md:hidden">
                <summary class="list-none cursor-pointer rounded-full border border-brand-200 bg-white px-4 py-2 text-sm font-semibold text-brand-900 shadow-sm transition hover:bg-brand-50 [&::-webkit-details-marker]:hidden">
                    Menu
                </summary>
                <div class="absolute right-0 z-50 mt-2 w-56 overflow-hidden rounded-2xl border border-brand-200/80 bg-white/95 py-2 shadow-xl shadow-black/10 backdrop-blur-md">
                    @foreach ($links as $link)
                        <a href="{{ route($link['route']) }}" class="block px-4 py-2.5 text-sm font-medium text-zinc-700 transition hover:bg-brand-50">{{ $link['label'] }}</a>
                    @endforeach
                    @guest
                        <a href="{{ route('login') }}" class="block border-t border-brand-100 px-4 py-2.5 text-sm font-bold text-brand-900 hover:bg-brand-50">Staff login</a>
                    @endguest
                    @auth
                        @if (auth()->user()->is_admin)
                            <a href="{{ route('listings.admin') }}" class="block border-t border-brand-100 px-4 py-2.5 text-sm font-bold text-brand-900 hover:bg-brand-50">Moderate listings</a>
                            <a href="{{ route('listings.admin.comments') }}" class="block px-4 py-2.5 text-sm font-semibold text-zinc-800 hover:bg-brand-50">All comments</a>
                            <form method="post" action="{{ route('logout') }}" class="border-t border-brand-100 px-4 py-2.5">
                                @csrf
                                <button type="submit" class="text-sm font-semibold text-zinc-700">Log out</button>
                            </form>
                        @endif
                    @endauth
                    <a href="{{ $c['ims_login_url'] }}" target="_blank" rel="noopener noreferrer" class="block border-t border-brand-100 px-4 py-2.5 text-sm font-bold text-brand-900 hover:bg-brand-50">KORA IMS</a>
                    <a href="tel:{{ $c['phone_tel'] }}" class="block border-t border-brand-100 px-4 py-2.5 text-sm font-semibold text-brand-800 hover:bg-brand-50">Call {{ $c['phone'] }}</a>
                </div>
            </details>
        </div>
    </div>
</header>
