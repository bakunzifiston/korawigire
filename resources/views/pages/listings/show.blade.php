@php
    $images = is_array($listing->images) && $listing->images !== [] ? $listing->images : ['logo.png'];
@endphp
@extends('layouts.site', ['title' => $listing->title])

@section('content')
    <section class="border-b border-brand-200 bg-brand-50/40">
        <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
            <a href="{{ route('listings.index') }}" class="text-sm font-semibold text-brand-800 hover:underline">← Back to listings</a>
            <div class="mt-4 flex flex-wrap items-center gap-2">
                <span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $badgeClass }}">{{ $badge }}</span>
                @if ($listing->comments_count > 0)
                    <span class="text-xs font-medium text-zinc-500">{{ $listing->comments_count }} {{ $listing->comments_count === 1 ? 'comment' : 'comments' }}</span>
                @endif
            </div>
            <h1 class="mt-3 text-2xl font-extrabold tracking-tight text-zinc-900 sm:text-3xl">{{ $listing->title }}</h1>
            <p class="mt-2 text-lg font-semibold text-brand-900">{{ $listing->price ?? 'Contact for details' }}</p>
            <p class="mt-1 text-sm text-zinc-600">📍 {{ $listing->location ?? 'Not specified' }}</p>
            <p class="mt-1 text-xs text-zinc-500">Posted {{ $listing->published_at?->diffForHumans() ?? $listing->created_at->diffForHumans() }}</p>
        </div>
    </section>

    <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-[1fr_280px]">
            <div class="space-y-8">
                <div class="overflow-hidden rounded-2xl border border-brand-200 bg-white shadow-sm">
                    <div @class(['grid gap-1', 'sm:grid-cols-2' => count($images) > 1])>
                        @foreach ($images as $path)
                            <img src="{{ listing_image_url($path) }}" alt="" class="aspect-[4/3] w-full object-cover" loading="{{ $loop->first ? 'eager' : 'lazy' }}" />
                        @endforeach
                    </div>
                </div>

                <div class="rounded-2xl border border-brand-200 bg-white p-6 shadow-sm">
                    <h2 class="text-sm font-bold uppercase tracking-widest text-brand-700">Description</h2>
                    <div class="mt-3 text-sm leading-relaxed text-zinc-700 whitespace-pre-wrap">{{ $listing->description ?? '' }}</div>
                </div>

                <div class="rounded-2xl border border-brand-200 bg-white p-6 shadow-sm">
                    <h2 class="text-sm font-bold uppercase tracking-widest text-brand-700">Contact the poster</h2>
                    <p class="mt-2 text-sm text-zinc-700"><span class="font-semibold">{{ $listing->contact_name }}</span></p>
                    <p class="mt-1 text-sm text-zinc-600">{{ $listing->contact_info }}</p>
                </div>

                <div class="rounded-2xl border border-brand-200 bg-white p-6 shadow-sm">
                    <h2 class="text-sm font-bold uppercase tracking-widest text-brand-700">Comments</h2>

                    @if (session('success'))
                        <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
                    @endif

                    <div class="mt-4 space-y-4">
                        @forelse ($listing->comments as $comment)
                            <div class="rounded-xl border border-brand-100 bg-brand-50/50 px-4 py-3">
                                <p class="text-xs font-semibold text-zinc-800">{{ $comment->author_name }}</p>
                                @if ($comment->author_contact)
                                    <p class="text-xs text-zinc-500">{{ $comment->author_contact }}</p>
                                @endif
                                <p class="mt-2 text-sm text-zinc-700 whitespace-pre-wrap">{{ $comment->body }}</p>
                                <p class="mt-2 text-xs text-zinc-400">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-zinc-500">No comments yet. Be the first to respond.</p>
                        @endforelse
                    </div>

                    <form method="post" action="{{ route('listings.comments.store', $listing) }}" class="mt-6 space-y-4 border-t border-brand-100 pt-6">
                        @csrf
                        <p class="text-sm font-semibold text-zinc-800">Add a comment</p>
                        <div>
                            <label for="author_name" class="mb-1 block text-xs font-semibold text-zinc-700">Your name</label>
                            <input id="author_name" name="author_name" value="{{ old('author_name') }}" required class="w-full rounded-xl border border-brand-200 px-3 py-2 text-sm @error('author_name') border-red-400 @enderror" />
                            @error('author_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="author_contact" class="mb-1 block text-xs font-semibold text-zinc-700">Phone or email (optional)</label>
                            <input id="author_contact" name="author_contact" value="{{ old('author_contact') }}" class="w-full rounded-xl border border-brand-200 px-3 py-2 text-sm" />
                            @error('author_contact')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="body" class="mb-1 block text-xs font-semibold text-zinc-700">Comment</label>
                            <textarea id="body" name="body" rows="4" required class="w-full rounded-xl border border-brand-200 px-3 py-2 text-sm @error('body') border-red-400 @enderror">{{ old('body') }}</textarea>
                            @error('body')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <button type="submit" class="rounded-full bg-brand-900 px-5 py-2.5 text-sm font-bold text-white hover:bg-black">Post comment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
