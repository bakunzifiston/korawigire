@props([
    'path',
    'alt' => '',
])
<img
    src="{{ site_image($path) }}"
    alt="{{ $alt }}"
    {{ $attributes }}
/>
