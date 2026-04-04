@php
    $onComments = request()->routeIs('listings.admin.comments');
@endphp
<nav class="mb-6 flex flex-wrap gap-2 border-b border-brand-200 pb-4 text-sm" aria-label="Listings admin">
    <a
        href="{{ route('listings.admin') }}"
        @class([
            'rounded-full border px-4 py-2 font-semibold transition',
            'border-brand-900 bg-brand-900 text-white' => ! $onComments,
            'border-brand-200 bg-white text-zinc-700 hover:bg-brand-50' => $onComments,
        ])
    >Moderate listings</a>
    <a
        href="{{ route('listings.admin.comments') }}"
        @class([
            'rounded-full border px-4 py-2 font-semibold transition',
            'border-brand-900 bg-brand-900 text-white' => $onComments,
            'border-brand-200 bg-white text-zinc-700 hover:bg-brand-50' => ! $onComments,
        ])
    >All comments</a>
</nav>
