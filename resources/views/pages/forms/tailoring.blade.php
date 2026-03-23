@extends('layouts.site', ['title' => 'Tailoring Order'])

@section('content')
    @include('partials.page-hero', [
        'eyebrow' => 'Tailoring',
        'title' => 'Place a tailoring order',
        'subtitle' => 'Custom fashion — share details and we will contact you.',
        'compact' => true,
        'narrow' => true,
    ])

    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:py-12">
        @if (session('success'))
            <div class="mb-8 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
        @endif

        <form action="{{ route('inquiries.store', 'tailoring') }}" method="post" class="space-y-6 rounded-3xl border border-brand-200/80 bg-white p-6 shadow-[0_8px_40px_-12px_rgba(0,0,0,0.08)] sm:p-8">
            @csrf
            <x-form-group label="Your name" name="name" required />
            <x-form-group label="Email" name="email" type="email" required />
            <x-form-group label="Phone" name="phone" type="tel" required />
            <x-form-group label="Garment type / description" name="garment_type" placeholder="Uniform, bridal, casual…" />
            <x-form-group label="Needed by (date or note)" name="deadline" />
            <x-form-group label="Measurements note" name="measurements_note" type="textarea" :rows="4" placeholder="Sizes, fabric preferences, reference photos…" />
            <x-form-group label="Order details" name="message" type="textarea" :rows="6" required />
            <button type="submit" class="w-full rounded-full bg-brand-800 py-3.5 text-sm font-semibold text-white hover:bg-brand-900 sm:w-auto sm:px-10">Submit order</button>
        </form>
    </div>
@endsection
