@extends('layouts.site', ['title' => 'Contact & Support'])

@section('content')
    @php $c = config('korawigire'); @endphp
    @include('partials.page-hero', [
        'eyebrow' => 'Reach us',
        'title' => 'Contact & support',
        'subtitle' => 'Visit us in Rubavu, call, email, or use our online forms — we respond as soon as we can.',
    ])

    <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">
        <div class="grid gap-10 lg:grid-cols-2">
            <div class="rounded-3xl border border-brand-200/80 bg-white p-8 shadow-[0_8px_40px_-12px_rgba(0,0,0,0.08)] lg:p-10">
                <h2 class="text-xl font-bold text-brand-900">Get in touch</h2>
                <ul class="mt-6 space-y-4 text-zinc-600">
                    <li><span class="font-semibold text-brand-900">Address</span><br>{{ $c['location'] }}</li>
                    <li><span class="font-semibold text-brand-900">Phone</span><br><a class="text-brand-700 hover:underline" href="tel:{{ $c['phone_tel'] }}">{{ $c['phone'] }}</a></li>
                    <li><span class="font-semibold text-brand-900">Email</span><br><a class="text-brand-700 hover:underline" href="mailto:{{ $c['email'] }}">{{ $c['email'] }}</a></li>
                    <li><span class="font-semibold text-brand-900">Website</span><br><a class="text-brand-700 hover:underline" href="{{ $c['website'] }}" target="_blank" rel="noopener">www.korawigire.rw</a></li>
                </ul>
                <p class="mt-6 text-sm text-zinc-500">Social: 
                    <a href="{{ $c['social']['facebook'] }}" class="font-medium text-brand-700 hover:underline" target="_blank" rel="noopener">Facebook</a> · 
                    <a href="{{ $c['social']['instagram'] }}" class="font-medium text-brand-700 hover:underline" target="_blank" rel="noopener">Instagram</a> · 
                    <a href="{{ $c['social']['whatsapp'] }}" class="font-medium text-brand-700 hover:underline" target="_blank" rel="noopener">WhatsApp</a>
                </p>
                <a href="{{ route('forms.show', 'contact') }}" class="mt-8 inline-flex rounded-full bg-accent-500 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-accent-600/20 transition hover:-translate-y-0.5 hover:bg-accent-600">General inquiry form</a>
            </div>

            <div class="rounded-3xl border border-brand-200/80 bg-gradient-to-br from-brand-50 to-white p-8 shadow-[0_8px_40px_-12px_rgba(0,166,81,0.08)] lg:p-10">
                <h2 class="text-xl font-bold text-brand-900">Online forms</h2>
                <p class="mt-2 text-sm text-zinc-600">Fast, simple, and mobile-friendly.</p>
                <ul class="mt-6 space-y-2 text-sm">
                    <li><a class="font-medium text-brand-800 hover:underline" href="{{ route('forms.show', 'radio-ad') }}">Book radio advertisements</a></li>
                    <li><a class="font-medium text-brand-800 hover:underline" href="{{ route('forms.show', 'tailoring') }}">Place tailoring orders</a></li>
                    <li><a class="font-medium text-brand-800 hover:underline" href="{{ route('forms.show', 'printing') }}">Request printing quotes</a></li>
                    <li><a class="font-medium text-brand-800 hover:underline" href="{{ route('forms.show', 'carpentry') }}">Submit carpentry projects</a></li>
                    <li><a class="font-medium text-brand-800 hover:underline" href="{{ route('forms.show', 'contact') }}">General contact &amp; inquiries</a></li>
                </ul>
            </div>
        </div>

        <section class="mt-14 rounded-3xl border border-brand-200/80 bg-white p-8 shadow-[0_8px_40px_-12px_rgba(0,0,0,0.06)] lg:flex lg:items-center lg:justify-between lg:gap-8 lg:p-10">
            <div>
                <h2 class="text-xl font-bold text-brand-900">Training programs</h2>
                <p class="mt-2 max-w-xl text-sm text-zinc-600">
                    Graphic design, tailoring, photography, carpentry, land survey, languages, traffic rules, ICT — hands-on courses for work and entrepreneurship.
                </p>
            </div>
            <a href="{{ route('training') }}" class="mt-6 inline-flex shrink-0 rounded-full bg-brand-800 px-6 py-3 text-sm font-semibold text-white hover:bg-brand-900 lg:mt-0">
                View all programs
            </a>
        </section>
    </div>
@endsection
