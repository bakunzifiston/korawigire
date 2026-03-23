@extends('layouts.site', ['title' => 'General Inquiry'])

@section('content')
    @include('partials.page-hero', [
        'eyebrow' => 'Contact',
        'title' => 'General contact & inquiries',
        'subtitle' => 'Training, partnerships, or any question — we are here to help.',
        'compact' => true,
        'narrow' => true,
    ])

    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:py-12">
        @if (session('success'))
            <div class="mb-8 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
        @endif

        <form action="{{ route('inquiries.store', 'contact') }}" method="post" class="space-y-6 rounded-3xl border border-brand-200/80 bg-white p-6 shadow-[0_8px_40px_-12px_rgba(0,0,0,0.08)] sm:p-8">
            @csrf
            <x-form-group label="Your name" name="name" required />
            <x-form-group label="Email" name="email" type="email" required />
            <x-form-group label="Phone" name="phone" type="tel" />
            <x-form-group label="Subject" name="subject" />
            <x-form-group label="Topic" name="inquiry_topic" placeholder="Training, radio, design, other…" />
            <x-form-group label="Message" name="message" type="textarea" :rows="8" required />
            <button type="submit" class="w-full rounded-full bg-accent-500 py-3.5 text-sm font-semibold text-white hover:bg-accent-600 sm:w-auto sm:px-10">Send message</button>
        </form>
    </div>
@endsection
