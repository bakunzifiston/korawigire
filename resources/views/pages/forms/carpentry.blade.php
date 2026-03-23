@extends('layouts.site', ['title' => 'Carpentry Project'])

@section('content')
    @include('partials.page-hero', [
        'eyebrow' => 'Carpentry',
        'title' => 'Carpentry project inquiry',
        'subtitle' => 'Furniture and interiors — share your scope.',
        'compact' => true,
        'narrow' => true,
    ])

    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:py-12">
        @if (session('success'))
            <div class="mb-8 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
        @endif

        <form action="{{ route('inquiries.store', 'carpentry') }}" method="post" class="space-y-6 rounded-3xl border border-brand-200/80 bg-white p-6 shadow-[0_8px_40px_-12px_rgba(0,0,0,0.08)] sm:p-8">
            @csrf
            <x-form-group label="Your name" name="name" required />
            <x-form-group label="Email" name="email" type="email" required />
            <x-form-group label="Phone" name="phone" type="tel" />
            <x-form-group label="Site / location" name="site_location" />
            <x-form-group label="Budget range (optional)" name="budget_range" />
            <x-form-group label="Project scope" name="project_scope" type="textarea" :rows="4" placeholder="Rooms, furniture types, materials…" />
            <x-form-group label="Full message" name="message" type="textarea" :rows="6" required />
            <button type="submit" class="w-full rounded-full border-2 border-brand-800 py-3.5 text-sm font-semibold text-brand-900 hover:bg-brand-50 sm:w-auto sm:px-10">Submit project</button>
        </form>
    </div>
@endsection
