{{--
    @include('partials.page-hero', [
        'title' => 'Page title',
        'subtitle' => 'Optional line',
        'eyebrow' => 'Optional uppercase line',
        'compact' => true,  // smaller hero (forms)
        'narrow' => true,   // align width with narrow content below
    ])
--}}
@php
    $compact = $compact ?? false;
    $narrow = $narrow ?? false;
    $py = $compact ? 'py-12 sm:py-14' : 'py-16 sm:py-20 lg:py-24';
    $inner = $narrow ? 'max-w-3xl px-4 sm:px-6' : 'max-w-6xl px-4 sm:px-6 lg:px-8';
    $h1Class = $compact
        ? 'text-2xl font-bold tracking-tight text-balance sm:text-3xl'
        : 'text-3xl font-bold tracking-tight text-balance sm:text-4xl lg:text-5xl';
@endphp
<div class="relative overflow-hidden bg-gradient-to-br from-brand-900 via-[#071208] to-brand-800 text-white {{ $py }}">
    <div class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-[#00A651]/25 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-28 -left-24 h-80 w-80 rounded-full bg-[#E31E24]/20 blur-3xl"></div>
    <div class="pointer-events-none absolute inset-0 bg-[linear-gradient(180deg,transparent_0%,rgba(0,0,0,0.2)_100%)]"></div>
    <div class="relative mx-auto {{ $inner }}">
        @if (! empty($eyebrow ?? null))
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-accent-400 sm:text-sm">{{ $eyebrow }}</p>
        @endif
        <h1 class="{{ ! empty($eyebrow ?? null) ? 'mt-3' : 'mt-0' }} max-w-4xl {{ $h1Class }}">{{ $title }}</h1>
        @if (! empty($subtitle ?? null))
            <p class="mt-4 max-w-2xl text-sm leading-relaxed text-white/88 sm:text-base">{{ $subtitle }}</p>
        @endif
    </div>
</div>
