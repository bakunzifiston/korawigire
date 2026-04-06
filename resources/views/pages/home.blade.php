@extends('layouts.site', ['title' => 'Home'])

@section('content')
    @php
        $heroSlides = ! empty($heroSlides ?? []) ? $heroSlides : ['logo.png'];
    @endphp
    <section class="relative overflow-hidden bg-black text-white">
        <div id="hero-slider" class="absolute inset-0">
            @foreach ($heroSlides as $idx => $slide)
                <div
                    class="hero-slide absolute inset-0 transition-opacity duration-1000 {{ $idx === 0 ? 'opacity-100' : 'opacity-0' }}"
                >
                    <img
                        src="{{ site_image($slide) }}"
                        alt=""
                        class="h-full w-full object-cover drop-shadow-[0_8px_24px_rgba(0,0,0,0.22)]"
                        loading="{{ $idx === 0 ? 'eager' : 'lazy' }}"
                        decoding="async"
                    />
                </div>
            @endforeach
        </div>
        <div class="pointer-events-none absolute inset-0 bg-[linear-gradient(180deg,rgba(0,0,0,0.72)_0%,rgba(0,0,0,0.64)_45%,rgba(0,0,0,0.78)_100%)]"></div>
        <div class="pointer-events-none absolute -right-32 top-0 h-[28rem] w-[28rem] rounded-full bg-[#00A651]/18 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-40 -left-32 h-[22rem] w-[22rem] rounded-full bg-[#E31E24]/16 blur-3xl"></div>
        <div class="relative mx-auto max-w-6xl px-4 py-20 sm:px-6 sm:py-28 lg:px-8 lg:py-32">
            <p class="text-xs font-bold uppercase tracking-[0.28em] text-accent-600 sm:text-sm">Rubavu · Rwanda</p>
            <h1 class="mt-5 max-w-4xl text-3xl font-extrabold leading-[1.15] tracking-tight text-balance sm:text-5xl lg:text-6xl">
                {{ config('korawigire.tagline') }}
            </h1>
            <p class="mt-8 max-w-2xl text-base leading-relaxed text-white/88 sm:text-lg">
                Discover your potential with {{ config('korawigire.company') }}. Whether you want to amplify your message through Money Radio, express your identity with custom fashion and tailoring, or create a strong brand presence through professional graphic design and printing, we are here to help you succeed.
            </p>
            <div class="mt-12 flex flex-col gap-3 sm:flex-row sm:flex-wrap">
                <a href="{{ route('listings.index', ['tab' => 'advert']) }}" class="inline-flex items-center justify-center rounded-full bg-accent-500 px-8 py-4 text-sm font-bold text-white shadow-xl shadow-accent-600/25 transition duration-200 hover:-translate-y-0.5 hover:bg-accent-600 hover:shadow-lg">
                    Advertise With Us — Radio
                </a>
                <a href="{{ route('gallery') }}" class="inline-flex items-center justify-center rounded-full border-2 border-brand-300 bg-white px-8 py-4 text-sm font-bold text-brand-900 transition duration-200 hover:-translate-y-0.5 hover:bg-brand-50">
                    View our gallery
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center rounded-full border border-brand-300 bg-white px-8 py-4 text-sm font-semibold text-brand-900 transition duration-200 hover:-translate-y-0.5 hover:bg-brand-50">
                    Contact Us
                </a>
            </div>
            <div class="mt-8 flex items-center gap-2">
                @foreach ($heroSlides as $idx => $slide)
                    <button
                        type="button"
                        class="hero-dot h-2.5 w-2.5 rounded-full border border-brand-300 bg-brand-200 transition {{ $idx === 0 ? 'bg-brand-800 border-brand-800' : '' }}"
                        data-index="{{ $idx }}"
                        aria-label="Go to slide {{ $idx + 1 }}"
                    ></button>
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-b border-brand-200/80 bg-white py-14 sm:py-16" aria-labelledby="vision-mission-heading">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 id="vision-mission-heading" class="text-xs font-bold uppercase tracking-[0.22em] text-brand-600 sm:text-sm">Who we are</h2>
                <p class="mt-3 text-3xl font-extrabold tracking-tight text-brand-900 sm:text-4xl">Vision &amp; mission</p>
                <p class="mx-auto mt-4 max-w-xl text-sm leading-relaxed text-zinc-600">What drives us every day in Rubavu and across our services.</p>
            </div>
            <div class="mt-12 grid gap-5 lg:grid-cols-2 lg:gap-6">
                <article class="rounded-2xl border border-brand-200 bg-white p-7 shadow-sm lg:p-8">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full border border-accent-200 bg-accent-50 text-sm font-bold text-accent-600" aria-hidden="true">V</div>
                    <h3 class="mt-4 text-xl font-bold text-brand-900">Our vision</h3>
                    <p class="mt-4 leading-relaxed text-zinc-600">
                        To become Rubavu’s leading multi-service hub, combining creativity, media, and technology to uplift communities and grow sustainable businesses.
                    </p>
                </article>
                <article class="rounded-2xl border border-brand-200 bg-white p-7 shadow-sm lg:p-8">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full border border-brand-200 bg-brand-50 text-sm font-bold text-brand-800" aria-hidden="true">M</div>
                    <h3 class="mt-4 text-xl font-bold text-brand-900">Our mission</h3>
                    <p class="mt-4 leading-relaxed text-zinc-600">
                        To deliver professional radio advertising, custom tailoring, graphic design, printing, and carpentry solutions while expanding digital access, creativity, and skills for youth and entrepreneurs.
                    </p>
                </article>
            </div>
            <p class="mt-12 text-center">
                <a href="{{ route('about') }}" class="inline-flex items-center gap-1 text-sm font-bold text-brand-800 underline-offset-4 transition hover:text-brand-900 hover:underline">Read our full story <span aria-hidden="true">→</span></a>
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
        <div class="rounded-[1.75rem] border border-brand-200/70 bg-white/90 p-8 shadow-[0_8px_40px_-12px_rgba(0,0,0,0.1)] backdrop-blur-sm lg:p-12">
            <h2 class="text-2xl font-extrabold tracking-tight text-brand-900 sm:text-3xl">Service highlights</h2>
            <p class="mt-4 max-w-3xl leading-relaxed text-zinc-600">
                We provide integrated media, fashion, printing, and carpentry services designed for individuals, SMEs, institutions, and growing brands.
            </p>
            <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['title' => 'Money Radio', 'icon' => '📻', 'desc' => 'Local reach, creative production, flexible ad packages.', 'href' => route('forms.show', 'radio-ad')],
                    ['title' => 'Tailoring & Fashion', 'icon' => '🧵', 'desc' => 'Custom garments, uniforms, bridal wear, and training.', 'href' => route('services').'#tailoring'],
                    ['title' => 'Design & Printing', 'icon' => '🎨', 'desc' => 'Branding, print materials, and combo packages with radio.', 'href' => route('services').'#printing'],
                    ['title' => 'Carpentry', 'icon' => '🪑', 'desc' => 'Furniture, interiors, and institutional woodwork.', 'href' => route('services').'#carpentry'],
                ] as $card)
                    <article class="group flex flex-col rounded-2xl border border-brand-200/60 bg-gradient-to-b from-white to-brand-50/40 p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-brand-300 hover:shadow-lg">
                        <span class="mb-3 inline-flex h-11 w-11 items-center justify-center rounded-xl bg-brand-100 text-xl shadow-sm" aria-hidden="true">{{ $card['icon'] }}</span>
                        <h3 class="font-bold text-brand-900">{{ $card['title'] }}</h3>
                        <p class="mt-3 flex-1 text-sm leading-relaxed text-zinc-600">{{ $card['desc'] }}</p>
                        <a href="{{ $card['href'] }}" class="mt-5 inline-flex items-center gap-1 text-sm font-bold text-brand-800 transition group-hover:gap-2 group-hover:text-accent-600">Learn more <span aria-hidden="true">→</span></a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    @if (! empty($galleryPreview))
        <section class="border-t border-brand-200/80 bg-gradient-to-b from-brand-50/50 to-white py-14 sm:py-16" aria-labelledby="gallery-preview-heading">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                    <h2 id="gallery-preview-heading" class="text-3xl font-extrabold tracking-tight text-brand-900 sm:text-4xl">
                        Gallery
                    </h2>
                    <a href="{{ route('gallery') }}" class="inline-flex shrink-0 items-center justify-center rounded-full bg-brand-900 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-brand-900/20 transition duration-200 hover:-translate-y-0.5 hover:bg-brand-800">
                        View all {{ $galleryCount }} →
                    </a>
                </div>
                <ul class="mt-10 grid grid-cols-3 gap-2 sm:gap-4">
                    @foreach ($galleryPreview as $item)
                        <li class="group overflow-hidden rounded-2xl border border-brand-200/80 bg-white shadow-md ring-1 ring-black/[0.04] transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                            <a href="{{ route('gallery') }}" class="block overflow-hidden">
                                <img
                                    src="{{ site_image($item['path']) }}"
                                    alt="{{ $item['alt'] ?? '' }}"
                                    width="320"
                                    height="320"
                                    loading="lazy"
                                    decoding="async"
                                    class="aspect-square w-full object-cover transition duration-500 group-hover:scale-105"
                                />
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif

    <section class="border-y border-brand-200/80 bg-white py-14">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-center text-xs font-bold uppercase tracking-[0.2em] text-brand-600 sm:text-sm">Quick links</h2>
            <nav class="mt-8 flex flex-wrap justify-center gap-2.5 sm:gap-3" aria-label="Quick links">
                <a class="rounded-full border border-brand-200 bg-brand-50/80 px-5 py-2.5 text-sm font-semibold text-brand-900 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-brand-300 hover:bg-white hover:shadow-md" href="{{ route('forms.show', 'radio-ad') }}">Radio Advertising</a>
                <a class="rounded-full border border-brand-200 bg-brand-50/80 px-5 py-2.5 text-sm font-semibold text-brand-900 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-brand-300 hover:bg-white hover:shadow-md" href="{{ route('gallery') }}">Gallery</a>
                <a class="rounded-full border border-brand-200 bg-brand-50/80 px-5 py-2.5 text-sm font-semibold text-brand-900 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-brand-300 hover:bg-white hover:shadow-md" href="{{ route('services') }}#tailoring">Tailoring &amp; Fashion</a>
                <a class="rounded-full border border-brand-200 bg-brand-50/80 px-5 py-2.5 text-sm font-semibold text-brand-900 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-brand-300 hover:bg-white hover:shadow-md" href="{{ route('services') }}#printing">Graphic Design &amp; Printing</a>
                <a class="rounded-full border border-brand-200 bg-brand-50/80 px-5 py-2.5 text-sm font-semibold text-brand-900 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-brand-300 hover:bg-white hover:shadow-md" href="{{ route('contact') }}">Contact Us</a>
            </nav>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (function () {
            const slider = document.getElementById('hero-slider');
            if (!slider) return;

            const slides = Array.from(slider.querySelectorAll('.hero-slide'));
            const dots = Array.from(document.querySelectorAll('.hero-dot'));
            if (slides.length < 2) return;

            let current = 0;
            const show = (idx) => {
                slides[current].classList.remove('opacity-100');
                slides[current].classList.add('opacity-0');
                dots[current]?.classList.remove('bg-white');
                dots[current]?.classList.add('bg-white/40');

                current = idx;

                slides[current].classList.remove('opacity-0');
                slides[current].classList.add('opacity-100');
                dots[current]?.classList.remove('bg-white/40');
                dots[current]?.classList.add('bg-white');
            };

            let timer = setInterval(() => show((current + 1) % slides.length), 4500);

            dots.forEach((dot, i) => {
                dot.addEventListener('click', () => {
                    show(i);
                    clearInterval(timer);
                    timer = setInterval(() => show((current + 1) % slides.length), 4500);
                });
            });
        })();
    </script>
@endpush
