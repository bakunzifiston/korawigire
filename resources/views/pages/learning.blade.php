@extends('layouts.site', ['title' => 'Learning Resources'])

@section('content')
    @include('partials.page-hero', [
        'eyebrow' => 'Resources',
        'title' => 'Learning resources',
        'subtitle' => 'Practical knowledge to grow skills and businesses — from our team to your journey.',
    ])

    <div class="mx-auto max-w-6xl space-y-16 px-4 py-14 sm:px-6 lg:px-8 lg:py-16">
        <section>
            <h2 class="text-2xl font-extrabold tracking-tight text-brand-900 sm:text-3xl">Blog topics we cover</h2>
            <p class="mt-3 text-zinc-600">Content themes you can expect as we publish articles and guides.</p>
            <ul class="mt-8 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    'Fashion and tailoring tips',
                    'Advertising and branding strategies',
                    'Graphic design basics',
                    'Carpentry fundamentals',
                    'Youth empowerment and entrepreneurship',
                ] as $topic)
                    <li class="rounded-2xl border border-brand-200/80 bg-white px-4 py-4 text-sm font-semibold text-brand-900 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">{{ $topic }}</li>
                @endforeach
            </ul>
        </section>

        <section>
            <h2 class="text-2xl font-extrabold tracking-tight text-brand-900 sm:text-3xl">How-to guides</h2>
            <div class="mt-8 grid gap-6 md:grid-cols-3">
                @foreach ([
                    ['Tailoring basics for beginners', 'Measurements, cutting, and first stitches — a practical starting path.'],
                    ['Small business design tips', 'Make flyers and social posts that look professional on any budget.'],
                    ['Introduction to radio advertising', 'Script structure, timing, and how to work with local stations.'],
                ] as [$t, $d])
                    <article class="rounded-3xl border border-brand-200/80 bg-gradient-to-b from-white to-brand-50/50 p-6 shadow-[0_4px_24px_-4px_rgba(0,0,0,0.06)] transition hover:-translate-y-1 hover:shadow-lg">
                        <h3 class="font-bold text-brand-900">{{ $t }}</h3>
                        <p class="mt-3 text-sm leading-relaxed text-zinc-600">{{ $d }}</p>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="rounded-3xl border border-brand-200/80 bg-white p-8 shadow-[0_8px_40px_-12px_rgba(0,0,0,0.08)] sm:p-10">
            <h2 class="text-2xl font-extrabold tracking-tight text-brand-900 sm:text-3xl">Resource library</h2>
            <p class="mt-2 text-zinc-600">Free downloads and templates — ask us for the latest versions when you visit or <a href="{{ route('forms.show', 'contact') }}" class="font-semibold text-brand-700 underline-offset-2 hover:underline">send a request</a>.</p>
            <ul class="mt-6 grid gap-3 sm:grid-cols-2">
                @foreach ([
                    'Design templates',
                    'Radio ad scripts',
                    'Tailoring guides',
                    'Sample audio ads',
                ] as $item)
                    <li class="flex items-center gap-2 text-sm text-zinc-700">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-accent-500/20 text-accent-700">↓</span>
                        {{ $item }}
                    </li>
                @endforeach
            </ul>
        </section>
    </div>
@endsection
