@extends('layouts.site', ['title' => 'Sell Product'])

@section('content')
    @include('partials.page-hero', [
        'title' => 'Sell a Product',
        'subtitle' => 'Create a trusted listing with key details buyers need.',
        'compact' => true,
        'narrow' => true,
    ])

    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:py-12">
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
        @endif

        <form method="post" action="{{ route('listings.sale.store') }}" enctype="multipart/form-data" class="space-y-5 rounded-3xl border border-brand-200 bg-white p-6 shadow-sm sm:p-8">
            @csrf
            <x-form-group label="Product name" name="product_name" required />
            <x-form-group label="Price" name="price" required placeholder="e.g. RWF 120,000" />
            <x-form-group label="Category" name="category" required placeholder="e.g. Electronics" />
            <x-form-group label="Location" name="location" required placeholder="e.g. Rubavu" />
            <div>
                <label class="mb-1 block text-sm font-semibold text-brand-900">Condition</label>
                <select name="condition" class="w-full rounded-2xl border border-brand-200/90 bg-white px-4 py-3.5 text-sm">
                    <option value="">Select condition</option>
                    <option value="new" @selected(old('condition')==='new')>New</option>
                    <option value="used" @selected(old('condition')==='used')>Used</option>
                    <option value="refurbished" @selected(old('condition')==='refurbished')>Refurbished</option>
                </select>
                @error('condition')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <x-form-group label="Description" name="description" type="textarea" :rows="5" required />
            <x-form-group label="Seller name" name="contact_name" required />
            <x-form-group label="Contact info" name="contact_info" required placeholder="Phone or email" />
            <div>
                <label class="mb-1 block text-sm font-semibold text-brand-900">Images</label>
                <input type="file" name="images[]" multiple accept="image/*" class="block w-full rounded-xl border border-brand-200 px-3 py-2 text-sm" />
                @error('images.*')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <button class="rounded-full bg-accent-500 px-6 py-3 text-sm font-bold text-white hover:bg-accent-600">Post product</button>
        </form>
    </div>
@endsection
