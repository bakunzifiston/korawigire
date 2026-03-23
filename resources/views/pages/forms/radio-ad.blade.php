@extends('layouts.site', ['title' => 'Book Radio Ad'])

@section('content')
    @include('partials.page-hero', [
        'eyebrow' => 'Money Radio',
        'title' => 'Book radio advertisement',
        'subtitle' => 'Tell us about your campaign and we will follow up.',
        'compact' => true,
        'narrow' => true,
    ])

    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:py-12">
        @if (session('success'))
            <div class="mb-8 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
        @endif

        <form action="{{ route('inquiries.store', 'radio_ad') }}" method="post" class="space-y-6 rounded-3xl border border-brand-200/80 bg-white p-6 shadow-[0_8px_40px_-12px_rgba(0,0,0,0.08)] sm:p-8">
            @csrf
            <x-form-group label="Your name" name="name" required />
            <x-form-group label="Email" name="email" type="email" required />
            <x-form-group label="Phone" name="phone" type="tel" placeholder="+250 …" />
            <x-form-group label="Business or organization (optional)" name="business_name" />
            <x-form-group label="Preferred air dates or schedule" name="preferred_schedule" />
            <x-form-group label="Campaign duration" name="campaign_duration" placeholder="e.g. 2 weeks, monthly" />
            <x-form-group label="Message / ad idea" name="message" type="textarea" :rows="6" required placeholder="Describe your product, offer, or script idea…" />
            <button type="submit" class="w-full rounded-full bg-accent-500 py-3.5 text-sm font-semibold text-white shadow hover:bg-accent-600 sm:w-auto sm:px-10">Submit request</button>
        </form>
    </div>
@endsection
