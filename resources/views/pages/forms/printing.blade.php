@extends('layouts.site', ['title' => 'Printing Quote'])

@section('content')
    @include('partials.page-hero', [
        'eyebrow' => 'Print & design',
        'title' => 'Request a printing quote',
        'subtitle' => 'Design + print — describe your project below.',
        'compact' => true,
        'narrow' => true,
    ])

    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:py-12">
        @if (session('success'))
            <div class="mb-8 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
        @endif

        <form action="{{ route('inquiries.store', 'printing') }}" method="post" class="space-y-6 rounded-3xl border border-brand-200/80 bg-white p-6 shadow-[0_8px_40px_-12px_rgba(0,0,0,0.08)] sm:p-8">
            @csrf
            <x-form-group label="Your name" name="name" required />
            <x-form-group label="Email" name="email" type="email" required />
            <x-form-group label="Phone" name="phone" type="tel" />
            <x-form-group label="Project type" name="project_type" placeholder="Flyers, banners, business cards…" />
            <x-form-group label="Quantity" name="quantity" />
            <x-form-group label="Delivery date (if known)" name="delivery_date" />
            <x-form-group label="Project details" name="message" type="textarea" :rows="6" required />
            <button type="submit" class="w-full rounded-full bg-brand-800 py-3.5 text-sm font-semibold text-white hover:bg-brand-900 sm:w-auto sm:px-10">Get quote</button>
        </form>
    </div>
@endsection
