@extends('layouts.site', ['title' => 'Post an Advert'])

@section('content')
    @include('partials.page-hero', [
        'title' => 'Post an Advert',
        'subtitle' => 'Submit a community or business advert. It appears after admin approval.',
        'compact' => true,
        'narrow' => true,
    ])

    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:py-12">
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
        @endif

        <form method="post" action="{{ route('listings.advert.store') }}" enctype="multipart/form-data" class="space-y-5 rounded-3xl border border-brand-200 bg-white p-6 shadow-sm sm:p-8">
            @csrf
            <x-form-group label="Advert title" name="advert_title" required placeholder="Short headline" />
            <x-form-group label="Description" name="description" type="textarea" :rows="5" required />
            <x-form-group label="Location (optional)" name="location" placeholder="e.g. Rubavu / online" />
            <x-form-group label="Price or rate (optional)" name="price" placeholder="e.g. RWF 50,000 / package" />
            <x-form-group label="Your name" name="contact_name" required />
            <x-form-group label="Contact info" name="contact_info" required placeholder="Phone or email" />
            <div>
                <label class="mb-1 block text-sm font-semibold text-brand-900">Images (optional)</label>
                <input type="file" name="images[]" multiple accept="image/*" class="block w-full rounded-xl border border-brand-200 px-3 py-2 text-sm" />
                @error('images.*')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <button class="rounded-full bg-accent-500 px-6 py-3 text-sm font-bold text-white hover:bg-accent-600">Submit advert</button>
        </form>
    </div>
@endsection
