@extends('layouts.site', ['title' => 'Staff login'])

@section('content')
    @include('partials.page-hero', [
        'title' => 'Staff login',
        'subtitle' => 'Sign in to review and approve listings before they appear on the site.',
        'compact' => true,
        'narrow' => true,
    ])

    <div class="mx-auto max-w-md px-4 py-10 sm:px-6 lg:py-12">
        <form method="post" action="{{ route('login') }}" class="space-y-5 rounded-3xl border border-brand-200 bg-white p-6 shadow-sm sm:p-8">
            @csrf
            <div>
                <label for="email" class="mb-1 block text-sm font-semibold text-brand-900">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="username"
                    class="w-full rounded-2xl border border-brand-200/90 bg-white px-4 py-3.5 text-sm text-zinc-800 shadow-sm focus:border-[#00A651] focus:outline-none focus:ring-4 focus:ring-[#00A651]/15 @error('email') border-red-400 @enderror"
                />
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="password" class="mb-1 block text-sm font-semibold text-brand-900">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    class="w-full rounded-2xl border border-brand-200/90 bg-white px-4 py-3.5 text-sm text-zinc-800 shadow-sm focus:border-[#00A651] focus:outline-none focus:ring-4 focus:ring-[#00A651]/15"
                />
            </div>
            <label class="flex items-center gap-2 text-sm text-zinc-700">
                <input type="checkbox" name="remember" value="1" class="rounded border-brand-200 text-[#00A651] focus:ring-[#00A651]" />
                Remember me
            </label>
            <button type="submit" class="w-full rounded-full bg-brand-900 px-6 py-3 text-sm font-bold text-white hover:bg-black">
                Sign in
            </button>
        </form>
        <p class="mt-6 text-center text-xs text-zinc-500">
            <a href="{{ route('listings.index') }}" class="font-semibold text-brand-800 hover:underline">Back to listings</a>
        </p>
    </div>
@endsection
