@extends('layouts.site', ['title' => 'Products & Services'])

@section('content')
    @include('partials.page-hero', [
        'eyebrow' => 'What we offer',
        'title' => 'Products & services',
        'subtitle' => 'Money Radio, tailoring, design & printing, and carpentry — built for Rubavu and beyond.',
    ])

    <div class="mx-auto max-w-6xl space-y-16 px-4 py-14 sm:px-6 lg:px-8 lg:space-y-20 lg:py-16">

        <section id="radio" class="scroll-mt-24 rounded-3xl border border-brand-200/80 bg-white p-8 shadow-[0_8px_40px_-12px_rgba(0,0,0,0.08)] transition hover:shadow-[0_16px_48px_-12px_rgba(0,0,0,0.1)] lg:p-10">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                <div class="max-w-2xl">
                    <p class="text-sm font-semibold uppercase tracking-widest text-accent-600">Money Radio</p>
                    <h2 class="mt-2 text-2xl font-bold text-brand-900">Radio advertising</h2>
                    <p class="mt-3 text-lg text-zinc-600">Get your message heard where it matters.</p>
                    <h3 class="mt-8 text-sm font-semibold text-brand-800">What we offer</h3>
                    <ul class="mt-3 list-inside list-disc space-y-2 text-zinc-600">
                        <li>Local radio adverts and announcements</li>
                        <li>Promotional jingles and branded messages</li>
                        <li>Community and business campaigns</li>
                    </ul>
                    <h3 class="mt-8 text-sm font-semibold text-brand-800">Why choose us</h3>
                    <ul class="mt-3 list-inside list-disc space-y-2 text-zinc-600">
                        <li>Affordable and flexible packages</li>
                        <li>Local reach with real impact</li>
                        <li>Creative scripting and production support</li>
                    </ul>
                    <blockquote class="mt-8 rounded-xl border-l-4 border-accent-500 bg-brand-50/80 px-4 py-3 text-brand-900 italic">
                        “Hands-On Skills, Voices That Matter – We Make It Happen!”
                    </blockquote>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('forms.show', 'radio-ad') }}" class="inline-flex w-full justify-center rounded-full bg-accent-500 px-8 py-3.5 text-sm font-semibold text-white shadow hover:bg-accent-600 lg:w-auto">Book radio ad time</a>
                </div>
            </div>
        </section>

        <section id="tailoring" class="scroll-mt-24 rounded-3xl border border-brand-200/80 bg-white p-8 shadow-[0_8px_40px_-12px_rgba(0,0,0,0.08)] transition hover:shadow-[0_16px_48px_-12px_rgba(0,0,0,0.1)] lg:p-10">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                <div class="max-w-2xl">
                    <p class="text-sm font-semibold uppercase tracking-widest text-accent-600">Fashion</p>
                    <h2 class="mt-2 text-2xl font-bold text-brand-900">Tailoring &amp; fashion design</h2>
                    <p class="mt-3 text-lg text-zinc-600">Custom fashion that fits your style and purpose.</p>
                    <h3 class="mt-8 text-sm font-semibold text-brand-800">Services include</h3>
                    <ul class="mt-3 list-inside list-disc space-y-2 text-zinc-600">
                        <li>Custom clothing for all ages</li>
                        <li>Modern and traditional designs</li>
                        <li>Bridal wear and ceremonial outfits</li>
                        <li>School, corporate, and institutional uniforms</li>
                        <li>Fashion and tailoring training</li>
                    </ul>
                </div>
                <div class="flex shrink-0 flex-col gap-3 sm:flex-row lg:flex-col">
                    <a href="{{ route('forms.show', 'tailoring') }}" class="inline-flex justify-center rounded-full border-2 border-brand-700 px-8 py-3.5 text-sm font-semibold text-brand-900 hover:bg-brand-50">Place a custom order</a>
                </div>
            </div>
        </section>

        <section id="printing" class="scroll-mt-24 rounded-3xl border border-brand-200/80 bg-white p-8 shadow-[0_8px_40px_-12px_rgba(0,0,0,0.08)] transition hover:shadow-[0_16px_48px_-12px_rgba(0,0,0,0.1)] lg:p-10">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                <div class="max-w-2xl">
                    <p class="text-sm font-semibold uppercase tracking-widest text-accent-600">Visual identity</p>
                    <h2 class="mt-2 text-2xl font-bold text-brand-900">Graphic design &amp; printing</h2>
                    <p class="mt-3 text-lg text-zinc-600">Build a strong visual identity for your brand.</p>
                    <h3 class="mt-8 text-sm font-semibold text-brand-800">Design &amp; print solutions</h3>
                    <ul class="mt-3 list-inside list-disc space-y-2 text-zinc-600">
                        <li>Logos and branding materials</li>
                        <li>Flyers, posters, and brochures</li>
                        <li>Business cards and banners</li>
                        <li>T-shirts and promotional items</li>
                    </ul>
                    <p class="mt-6 rounded-xl bg-accent-500/15 px-4 py-3 text-sm font-medium text-brand-900">
                        <strong>Special offers:</strong> Combo packages — Design + Print + Radio Ad
                    </p>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('forms.show', 'printing') }}" class="inline-flex w-full justify-center rounded-full bg-brand-800 px-8 py-3.5 text-sm font-semibold text-white hover:bg-brand-900 lg:w-auto">Get a print quote</a>
                </div>
            </div>
        </section>

        <section id="carpentry" class="scroll-mt-24 rounded-3xl border border-brand-200/80 bg-white p-8 shadow-[0_8px_40px_-12px_rgba(0,0,0,0.08)] transition hover:shadow-[0_16px_48px_-12px_rgba(0,0,0,0.1)] lg:p-10">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                <div class="max-w-2xl">
                    <p class="text-sm font-semibold uppercase tracking-widest text-accent-600">Woodwork</p>
                    <h2 class="mt-2 text-2xl font-bold text-brand-900">Carpentry work</h2>
                    <p class="mt-3 text-lg text-zinc-600">Functional and stylish woodwork solutions.</p>
                    <h3 class="mt-8 text-sm font-semibold text-brand-800">Our expertise</h3>
                    <ul class="mt-3 list-inside list-disc space-y-2 text-zinc-600">
                        <li>Custom furniture</li>
                        <li>Office and shop interiors</li>
                        <li>School and government projects</li>
                        <li>Residential and commercial fittings</li>
                    </ul>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('forms.show', 'carpentry') }}" class="inline-flex w-full justify-center rounded-full border-2 border-brand-700 px-8 py-3.5 text-sm font-semibold text-brand-900 hover:bg-brand-50 lg:w-auto">Discuss your carpentry project</a>
                </div>
            </div>
        </section>
    </div>
@endsection
