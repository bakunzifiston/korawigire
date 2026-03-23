@props([
    'label',
    'name',
    'type' => 'text',
    'required' => false,
    'rows' => 4,
    'placeholder' => '',
])
<div {{ $attributes->merge(['class' => 'space-y-1.5']) }}>
    <label for="{{ $name }}" class="block text-sm font-semibold text-brand-900">
        {{ $label }}
        @if ($required)<span class="text-red-600">*</span>@endif
    </label>
    @if ($type === 'textarea')
        <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            rows="{{ $rows }}"
            placeholder="{{ $placeholder }}"
            @if ($required) required @endif
            class="w-full rounded-2xl border border-brand-200/90 bg-white px-4 py-3.5 text-sm text-zinc-800 shadow-sm transition placeholder:text-zinc-400 focus:border-[#00A651] focus:outline-none focus:ring-4 focus:ring-[#00A651]/15 @error($name) border-red-400 @enderror"
        >{{ old($name) }}</textarea>
    @else
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            type="{{ $type }}"
            value="{{ old($name) }}"
            placeholder="{{ $placeholder }}"
            @if ($required) required @endif
            class="w-full rounded-2xl border border-brand-200/90 bg-white px-4 py-3.5 text-sm text-zinc-800 shadow-sm transition placeholder:text-zinc-400 focus:border-[#00A651] focus:outline-none focus:ring-4 focus:ring-[#00A651]/15 @error($name) border-red-400 @enderror"
        />
    @endif
    @error($name)
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
