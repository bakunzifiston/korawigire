@extends('layouts.site', ['title' => 'Testimonials'])

@section('content')
    @include('partials.page-hero', [
        'eyebrow' => 'Testimonials',
        'title' => 'What our clients say',
        'subtitle' => 'Real feedback from businesses, trainees, and partners across Rubavu.',
    ])

    <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">
        <div class="grid gap-8 lg:grid-cols-3">
            <figure class="rounded-3xl border border-brand-200/80 bg-white p-8 shadow-[0_8px_40px_-12px_rgba(0,0,0,0.08)] transition hover:-translate-y-1 hover:shadow-lg">
                <figcaption class="text-sm font-semibold uppercase tracking-wide text-accent-600">Business owners</figcaption>
                <blockquote class="mt-4 text-zinc-700 leading-relaxed">
                    “Kora Wigire helped us reach more customers through Money Radio. Our sales increased within weeks.”
                </blockquote>
            </figure>
            <figure class="rounded-3xl border border-brand-200/80 bg-white p-8 shadow-[0_8px_40px_-12px_rgba(0,0,0,0.08)] transition hover:-translate-y-1 hover:shadow-lg">
                <figcaption class="text-sm font-semibold uppercase tracking-wide text-accent-600">Fashion trainees</figcaption>
                <blockquote class="mt-4 text-zinc-700 leading-relaxed">
                    “I learned tailoring skills that helped me start my own fashion business.”
                </blockquote>
            </figure>
            <figure class="rounded-3xl border border-brand-200/80 bg-white p-8 shadow-[0_8px_40px_-12px_rgba(0,0,0,0.08)] transition hover:-translate-y-1 hover:shadow-lg">
                <figcaption class="text-sm font-semibold uppercase tracking-wide text-accent-600">Printing clients</figcaption>
                <blockquote class="mt-4 text-zinc-700 leading-relaxed">
                    “Our brand visibility improved thanks to their professional designs and quality prints.”
                </blockquote>
            </figure>
        </div>

        <section class="mt-16 rounded-3xl border border-dashed border-brand-300/80 bg-gradient-to-br from-brand-50/80 to-white p-8 lg:p-10">
            <h2 class="text-xl font-bold text-brand-900">Case studies</h2>
            <p class="mt-2 text-zinc-600">Challenge → Solution → Impact: we document stories that show how radio, design, tailoring, or carpentry moved the needle for local brands. <a href="{{ route('contact') }}" class="font-semibold text-brand-800 underline-offset-2 hover:underline">Ask us</a> for examples relevant to your sector.</p>
        </section>
    </div>
@endsection
