@php
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'LodgingBusiness',
        'name' => $siteSettings['site_name'] ?? 'Guesthouse',
        'url' => url('/'),
        'telephone' => $siteSettings['phone'] ?? null,
        'email' => $siteSettings['email'] ?? null,
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $siteSettings['address'] ?? null,
        ],
    ];
    if (!empty($siteSettings['logo'])) {
        $schema['logo'] = asset('storage/' . $siteSettings['logo']);
    }
@endphp

<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
