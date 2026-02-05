@php
    $whatsapp = $siteSettings['whatsapp'] ?? null;
@endphp

@if($whatsapp)
    <a class="whatsapp-float js-track-cta" data-event="click_whatsapp" href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener">
        WhatsApp
    </a>
@endif
