@extends('layouts.site', ['title' => 'About Us'])

@section('content')
    @include('partials.page-hero', [
        'eyebrow' => 'Our company',
        'title' => 'About us',
        'subtitle' => 'Founded in Rubavu — media, fashion, design, and craftsmanship under one roof.',
    ])

    <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">
        <article class="prose prose-zinc max-w-none">
            <h2 class="text-2xl font-bold text-brand-900">Our story</h2>
            <p class="mt-4 text-zinc-600 leading-relaxed">
                Founded in Rubavu District, {{ config('korawigire.company') }} was established to deliver affordable, high-quality services in communication, fashion, printing, and craftsmanship. Through Money Radio, we help local businesses reach their audiences. Through tailoring, design, and carpentry, we turn ideas into tangible value.
            </p>
            <p class="mt-4 text-zinc-600 leading-relaxed">
                We are proud to support local talent, empower youth with practical skills, and contribute to Rubavu’s creative and business ecosystem.
            </p>

            <h2 class="mt-14 text-2xl font-bold text-brand-900">Our vision</h2>
            <p class="mt-4 text-zinc-600 leading-relaxed">
                To become Rubavu’s leading multi-service hub, combining creativity, media, and technology to uplift communities and grow sustainable businesses.
            </p>

            <h2 class="mt-14 text-2xl font-bold text-brand-900">Our mission</h2>
            <p class="mt-4 text-zinc-600 leading-relaxed">
                To deliver professional radio advertising, custom tailoring, graphic design, printing, and carpentry solutions while expanding digital access, creativity, and skills for youth and entrepreneurs.
            </p>
        </article>

        <div class="mt-14 flex flex-wrap gap-4">
            <a href="{{ route('services') }}" class="rounded-full bg-brand-900 px-7 py-3.5 text-sm font-bold text-white shadow-lg shadow-brand-900/20 transition hover:-translate-y-0.5 hover:bg-black">View services</a>
            <a href="{{ route('contact') }}" class="rounded-full border-2 border-brand-200 bg-white px-7 py-3.5 text-sm font-bold text-brand-900 shadow-sm transition hover:-translate-y-0.5 hover:border-brand-300 hover:shadow-md">Get in touch</a>
        </div>
    </div>
@endsection
