@extends('layouts.site', ['title' => 'Rent an Asset'])

@section('content')
    @include('partials.page-hero', [
        'title' => 'Rent an Asset',
        'subtitle' => 'List houses, equipment, and other assets for rental.',
        'compact' => true,
        'narrow' => true,
    ])

    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:py-12">
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
        @endif

        <form method="post" action="{{ route('listings.rental.store') }}" enctype="multipart/form-data" class="space-y-5 rounded-3xl border border-brand-200 bg-white p-6 shadow-sm sm:p-8">
            @csrf
            <x-form-group label="Asset name" name="asset_name" required />
            <x-form-group label="Price (per day/month)" name="price_period" required placeholder="e.g. RWF 80,000/day" />
            <x-form-group label="Availability" name="availability" required placeholder="Available now / from date" />
            <x-form-group label="Location" name="location" required />
            <x-form-group label="Description" name="description" type="textarea" :rows="5" required />
            <x-form-group label="Contact name" name="contact_name" required />
            <x-form-group label="Contact info" name="contact_info" required placeholder="Phone or email" />
            <div>
                <label class="mb-1 block text-sm font-semibold text-brand-900">Images</label>
                <input type="file" name="images[]" multiple accept="image/*" class="block w-full rounded-xl border border-brand-200 px-3 py-2 text-sm" />
                @error('images.*')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <button class="rounded-full bg-accent-500 px-6 py-3 text-sm font-bold text-white hover:bg-accent-600">Post rental</button>
        </form>
    </div>
@endsection
