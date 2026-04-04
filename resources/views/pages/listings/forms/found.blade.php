@extends('layouts.site', ['title' => 'Report Found Item'])

@section('content')
    @include('partials.page-hero', [
        'title' => 'Report a Found Item',
        'subtitle' => 'Help reunite lost property with its owner. Your post is reviewed before it goes public.',
        'compact' => true,
        'narrow' => true,
    ])

    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:py-12">
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
        @endif

        <form method="post" action="{{ route('listings.found.store') }}" enctype="multipart/form-data" class="space-y-5 rounded-3xl border border-brand-200 bg-white p-6 shadow-sm sm:p-8">
            @csrf
            <x-form-group label="What was found?" name="item_name" required />
            <x-form-group label="Description" name="description" type="textarea" :rows="5" required />
            <x-form-group label="Where it was found" name="found_location" required />
            <x-form-group label="Date found" name="date_found" type="date" required />
            <x-form-group label="Your name" name="contact_name" required />
            <x-form-group label="Contact info" name="contact_info" required placeholder="Phone or email" />
            <div>
                <label class="mb-1 block text-sm font-semibold text-brand-900">Photo (optional)</label>
                <input type="file" name="image" accept="image/*" class="block w-full rounded-xl border border-brand-200 px-3 py-2 text-sm" />
                @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <button class="rounded-full bg-accent-500 px-6 py-3 text-sm font-bold text-white hover:bg-accent-600">Submit found item</button>
        </form>
    </div>
@endsection
