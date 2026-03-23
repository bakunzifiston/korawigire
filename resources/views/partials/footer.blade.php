@php $c = config('korawigire'); @endphp
<footer class="relative mt-20 overflow-hidden border-t border-white/10 bg-brand-900 text-brand-50">
    <div class="pointer-events-none absolute inset-0 bg-[linear-gradient(180deg,rgba(0,166,81,0.12)_0%,transparent_35%,transparent_65%,rgba(227,30,36,0.08)_100%)]"></div>
    <div class="relative mx-auto max-w-6xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-12 md:grid-cols-2 lg:grid-cols-4 lg:gap-10">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-start lg:col-span-2">
                <img
                    src="{{ site_image(config('korawigire.logo')) }}"
                    width="72"
                    height="72"
                    alt=""
                    class="h-16 w-16 shrink-0 rounded-full object-cover shadow-lg ring-2 ring-[#E31E24] ring-offset-2 ring-offset-brand-900"
                    decoding="async"
                />
                <div>
                    <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-accent-500">{{ $c['short_name'] }}</p>
                    <p class="mt-3 max-w-md text-sm leading-relaxed text-white/85">{{ $c['company'] }}</p>
                    <p class="mt-4 text-sm italic leading-relaxed text-white/65">{{ $c['tagline'] }}</p>
                </div>
            </div>
            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest text-white/90">Contact</h3>
                <ul class="mt-4 space-y-3 text-sm text-white/75">
                    <li class="leading-snug">{{ $c['location'] }}</li>
                    <li><a class="rounded-md font-medium text-white transition hover:text-[#00A651]" href="tel:{{ $c['phone_tel'] }}">{{ $c['phone'] }}</a></li>
                    <li><a class="rounded-md font-medium text-white transition hover:text-[#00A651]" href="mailto:{{ $c['email'] }}">{{ $c['email'] }}</a></li>
                    <li><a class="font-medium text-[#7dd4a8] underline-offset-2 transition hover:underline" href="{{ $c['website'] }}" target="_blank" rel="noopener">www.korawigire.rw</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest text-white/90">Follow us</h3>
                <ul class="mt-4 flex flex-wrap gap-2">
                    <li><a class="inline-flex rounded-full border border-white/20 bg-white/5 px-3 py-1.5 text-xs font-semibold text-white/90 transition hover:border-accent-500/50 hover:bg-white/10" href="{{ $c['social']['facebook'] }}" target="_blank" rel="noopener">Facebook</a></li>
                    <li><a class="inline-flex rounded-full border border-white/20 bg-white/5 px-3 py-1.5 text-xs font-semibold text-white/90 transition hover:border-accent-500/50 hover:bg-white/10" href="{{ $c['social']['instagram'] }}" target="_blank" rel="noopener">Instagram</a></li>
                    <li><a class="inline-flex rounded-full border border-white/20 bg-white/5 px-3 py-1.5 text-xs font-semibold text-white/90 transition hover:border-accent-500/50 hover:bg-white/10" href="{{ $c['social']['whatsapp'] }}" target="_blank" rel="noopener">WhatsApp</a></li>
                </ul>
                <p class="mt-8 text-xs text-white/45">&copy; {{ date('Y') }} {{ $c['short_name'] }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>
