@php
    $whatsapp = $siteSettings['whatsapp'] ?? null;
@endphp

@if($whatsapp)
    <a class="fixed right-6 bottom-20 md:bottom-6 bg-emerald-600 text-white px-4 py-3 rounded-full shadow-lg font-semibold z-[100] js-track-cta" data-event="click_whatsapp" href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener">
        WhatsApp
    </a>
@endif
