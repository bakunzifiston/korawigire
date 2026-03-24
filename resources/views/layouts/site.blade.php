<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $metaDescription ?? config('korawigire.company') . ' — Money Radio, tailoring, graphic design, printing, and carpentry in Rubavu, Rwanda.' }}">
    <title>{{ $title ?? config('korawigire.short_name') }} | {{ config('korawigire.company') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=montserrat:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-zinc-900 antialiased font-sans">
    @include('partials.nav')
    <main>
        @yield('content')
    </main>
    @include('partials.footer')
    @stack('scripts')
</body>
</html>
