@if (filled(config('korawigire.matomo.site_id')))
    @php
        $matomoBase = rtrim((string) config('korawigire.matomo.url'), '/').'/';
    @endphp
    <!-- Matomo -->
    <script>
        var _paq = window._paq = window._paq || [];
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function () {
            var u = {!! json_encode($matomoBase) !!};
            _paq.push(['setTrackerUrl', u + 'matomo.php']);
            _paq.push(['setSiteId', {!! json_encode((string) config('korawigire.matomo.site_id')) !!}]);
            var d = document,
                g = d.createElement('script'),
                s = d.getElementsByTagName('script')[0];
            g.async = true;
            g.src = u + 'matomo.js';
            s.parentNode.insertBefore(g, s);
        })();
    </script>
    <noscript>
        <p>
            <img
                referrerpolicy="no-referrer-when-downgrade"
                src="{{ $matomoBase }}matomo.php?idsite={{ rawurlencode((string) config('korawigire.matomo.site_id')) }}&amp;rec=1"
                style="border:0"
                alt=""
            />
        </p>
    </noscript>
    <!-- End Matomo Code -->
@endif
