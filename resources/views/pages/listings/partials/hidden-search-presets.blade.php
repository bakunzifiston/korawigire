{{-- Preserve non-search fields when submitting the keyword search. --}}
@foreach (['location', 'price_hint', 'posted', 'condition', 'rental_period'] as $k)
    @if (($filters[$k] ?? '') !== '')
        <input type="hidden" name="{{ $k }}" value="{{ $filters[$k] }}" />
    @endif
@endforeach
