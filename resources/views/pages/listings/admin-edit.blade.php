@extends('layouts.site', ['title' => 'Edit listing'])

@section('content')
    @include('partials.page-hero', [
        'title' => 'Edit listing',
        'subtitle' => 'Update this post. Changing status to approved sets or keeps a publish date; other statuses hide it from the public list.',
        'compact' => true,
    ])

    <section class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        @include('partials.listings-admin-nav')

        <div class="mb-6">
            <a href="{{ route('listings.admin', ['status' => $adminStatus]) }}" class="text-sm font-semibold text-brand-800 hover:underline">← Back to moderation</a>
        </div>

        <form method="post" action="{{ route('listings.update', $listing) }}" class="space-y-5 rounded-3xl border border-brand-200 bg-white p-6 shadow-sm sm:p-8">
            @csrf
            @method('PUT')
            <input type="hidden" name="from" value="{{ $adminStatus }}" />

            <div>
                <label for="type" class="mb-1 block text-sm font-semibold text-brand-900">Type</label>
                <select id="type" name="type" class="w-full rounded-2xl border border-brand-200 px-4 py-3 text-sm">
                    @foreach (['advert' => 'Advert', 'lost' => 'Lost', 'found' => 'Found', 'sale' => 'For sale', 'rental' => 'Rental'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('type', $listing->type) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="status" class="mb-1 block text-sm font-semibold text-brand-900">Status</label>
                <select id="status" name="status" class="w-full rounded-2xl border border-brand-200 px-4 py-3 text-sm">
                    @foreach (['pending' => 'Pending', 'approved' => 'Approved (public)', 'rejected' => 'Rejected'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $listing->status) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="title" class="mb-1 block text-sm font-semibold text-brand-900">Title</label>
                <input id="title" name="title" value="{{ old('title', $listing->title) }}" required class="w-full rounded-2xl border border-brand-200 px-4 py-3 text-sm @error('title') border-red-400 @enderror" />
                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="description" class="mb-1 block text-sm font-semibold text-brand-900">Description</label>
                <textarea id="description" name="description" rows="6" class="w-full rounded-2xl border border-brand-200 px-4 py-3 text-sm @error('description') border-red-400 @enderror">{{ old('description', $listing->description) }}</textarea>
                @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="price" class="mb-1 block text-sm font-semibold text-brand-900">Price / rate</label>
                <input id="price" name="price" value="{{ old('price', $listing->price) }}" class="w-full rounded-2xl border border-brand-200 px-4 py-3 text-sm" />
                @error('price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="location" class="mb-1 block text-sm font-semibold text-brand-900">Location</label>
                <input id="location" name="location" value="{{ old('location', $listing->location) }}" class="w-full rounded-2xl border border-brand-200 px-4 py-3 text-sm" />
                @error('location')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="contact_name" class="mb-1 block text-sm font-semibold text-brand-900">Contact name</label>
                <input id="contact_name" name="contact_name" value="{{ old('contact_name', $listing->contact_name) }}" class="w-full rounded-2xl border border-brand-200 px-4 py-3 text-sm" />
                @error('contact_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="contact_info" class="mb-1 block text-sm font-semibold text-brand-900">Contact info</label>
                <input id="contact_info" name="contact_info" value="{{ old('contact_info', $listing->contact_info) }}" class="w-full rounded-2xl border border-brand-200 px-4 py-3 text-sm" />
                @error('contact_info')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <p class="text-xs text-zinc-500">Images and extra details (category, dates, etc.) are unchanged here. Re-upload by creating a new listing if needed.</p>

            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit" class="rounded-full bg-brand-900 px-6 py-3 text-sm font-bold text-white hover:bg-black">Save changes</button>
                <a href="{{ route('listings.admin', ['status' => $adminStatus]) }}" class="inline-flex items-center rounded-full border border-brand-200 px-6 py-3 text-sm font-semibold text-zinc-700 hover:bg-brand-50">Cancel</a>
            </div>
        </form>
    </section>
@endsection
