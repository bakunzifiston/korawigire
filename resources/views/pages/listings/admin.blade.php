@extends('layouts.site', ['title' => 'Listings Moderation'])

@section('content')
    @include('partials.page-hero', [
        'title' => 'Listings Moderation',
        'subtitle' => 'Approve or reject user submissions before they become public.',
        'compact' => true,
    ])

    <section class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
        @endif

        @include('partials.listings-admin-nav')

        <div class="mb-6 flex flex-wrap gap-2">
            @foreach (['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $key => $label)
                <a href="{{ route('listings.admin', ['status' => $key]) }}" @class([
                    'rounded-full border px-4 py-2 text-sm font-semibold',
                    'border-brand-900 bg-brand-900 text-white' => $status === $key,
                    'border-brand-200 bg-white text-zinc-700' => $status !== $key,
                ])>{{ $label }}</a>
            @endforeach
        </div>

        <div class="grid gap-4">
            @forelse ($items as $item)
                <article class="rounded-2xl border border-brand-200 bg-white p-5 shadow-sm">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0">
                            <p class="text-xs font-semibold uppercase tracking-widest text-zinc-500">{{ $item->type }} · {{ $item->status }}</p>
                            <h2 class="mt-1 text-lg font-bold text-zinc-900">{{ $item->title }}</h2>
                            <p class="mt-2 text-sm text-zinc-600">{{ $item->description }}</p>
                            <div class="mt-3 flex flex-wrap gap-3 text-xs text-zinc-500">
                                <span>Location: {{ $item->location ?? 'N/A' }}</span>
                                <span>Price: {{ $item->price ?? 'N/A' }}</span>
                                <span>Contact: {{ $item->contact_name }} / {{ $item->contact_info }}</span>
                                <span>Submitted: {{ $item->created_at?->diffForHumans() }}</span>
                                @if ($item->status === 'approved')
                                    <a href="{{ route('listings.show', $item) }}" class="font-semibold text-brand-800 hover:underline" target="_blank" rel="noopener">Public page</a>
                                @endif
                                <a href="{{ route('listings.admin.comments', ['listing_id' => $item->id]) }}" class="font-semibold text-brand-800 hover:underline">{{ $item->comments_count }} {{ $item->comments_count === 1 ? 'comment' : 'comments' }}</a>
                            </div>
                        </div>
                        @if ($item->primaryImage())
                            <img src="{{ listing_image_url($item->primaryImage()) }}" alt="" class="h-24 w-24 rounded-xl object-cover" />
                        @endif
                    </div>

                    @if ($status === 'pending')
                        <div class="mt-4 flex flex-wrap gap-2">
                            <form method="post" action="{{ route('listings.approve', ['listing' => $item->id]) }}">
                                @csrf
                                <button class="rounded-full bg-emerald-600 px-4 py-2 text-xs font-bold text-white hover:bg-emerald-700">Approve & Publish</button>
                            </form>
                            <form method="post" action="{{ route('listings.reject', ['listing' => $item->id]) }}">
                                @csrf
                                <button class="rounded-full bg-red-600 px-4 py-2 text-xs font-bold text-white hover:bg-red-700">Reject</button>
                            </form>
                            <a href="{{ route('listings.edit', ['listing' => $item, 'from' => $status]) }}" class="inline-flex items-center rounded-full border border-brand-200 bg-white px-4 py-2 text-xs font-bold text-zinc-800 hover:bg-brand-50">Edit</a>
                        </div>
                    @endif

                    @if ($status === 'approved')
                        <div class="mt-4 flex flex-wrap gap-2">
                            <a href="{{ route('listings.edit', ['listing' => $item, 'from' => $status]) }}" class="inline-flex items-center rounded-full border border-brand-200 bg-white px-4 py-2 text-xs font-bold text-zinc-800 hover:bg-brand-50">Edit</a>
                            <form method="post" action="{{ route('listings.destroy', $item) }}" onsubmit="return confirm('Delete this listing and all its comments? This cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="from" value="{{ $status }}" />
                                <button type="submit" class="rounded-full bg-red-600 px-4 py-2 text-xs font-bold text-white hover:bg-red-700">Delete</button>
                            </form>
                        </div>
                    @endif
                </article>
            @empty
                <p class="rounded-xl border border-brand-200 bg-brand-50 px-4 py-6 text-sm text-zinc-600">No {{ $status }} listings.</p>
            @endforelse
        </div>
    </section>
@endsection
