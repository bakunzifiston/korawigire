@extends('layouts.site', ['title' => 'Listing comments'])

@section('content')
    @include('partials.page-hero', [
        'title' => 'Listing comments',
        'subtitle' => 'Every comment, who wrote it, and which listing it belongs to.',
        'compact' => true,
    ])

    <section class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        @include('partials.listings-admin-nav')

        <form method="get" action="{{ route('listings.admin.comments') }}" class="mb-6 flex flex-wrap items-end gap-3">
            <div>
                <label for="listing_id" class="mb-1 block text-xs font-semibold text-zinc-600">Filter by listing</label>
                <select id="listing_id" name="listing_id" class="rounded-xl border border-brand-200 bg-white px-3 py-2 text-sm" onchange="this.form.submit()">
                    <option value="">All listings</option>
                    @foreach ($listingsForFilter as $l)
                        <option value="{{ $l->id }}" @selected((int) $filterListingId === (int) $l->id)>#{{ $l->id }} — {{ $l->title }}</option>
                    @endforeach
                </select>
            </div>
            <noscript>
                <button type="submit" class="rounded-full bg-brand-900 px-4 py-2 text-xs font-bold text-white">Apply</button>
            </noscript>
        </form>

        <div class="space-y-4">
            @forelse ($comments as $comment)
                <article class="rounded-2xl border border-brand-200 bg-white p-5 shadow-sm">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-xs font-semibold uppercase tracking-widest text-zinc-500">
                                On:
                                <a href="{{ route('listings.show', $comment->listing) }}" class="text-brand-800 hover:underline" target="_blank" rel="noopener">{{ $comment->listing->title }}</a>
                                <span class="text-zinc-400">(#{{ $comment->listing_id }})</span>
                            </p>
                            <h2 class="mt-2 text-base font-bold text-zinc-900">{{ $comment->author_name }}</h2>
                            @if ($comment->author_contact)
                                <p class="text-sm text-zinc-600">{{ $comment->author_contact }}</p>
                            @else
                                <p class="text-sm text-zinc-400">No contact left</p>
                            @endif
                            <p class="mt-3 text-sm text-zinc-700 whitespace-pre-wrap">{{ $comment->body }}</p>
                        </div>
                        <div class="text-right text-xs text-zinc-500">
                            <p>{{ $comment->created_at->format('Y-m-d H:i') }}</p>
                            <p class="mt-1">{{ $comment->created_at->diffForHumans() }}</p>
                            @if ($comment->ip_address)
                                <p class="mt-2 font-mono text-zinc-400" title="IP at post time">{{ $comment->ip_address }}</p>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <p class="rounded-xl border border-brand-200 bg-brand-50 px-4 py-6 text-sm text-zinc-600">No comments yet.</p>
            @endforelse
        </div>

        @if ($comments->hasPages())
            <div class="mt-8">
                {{ $comments->links() }}
            </div>
        @endif
    </section>
@endsection
