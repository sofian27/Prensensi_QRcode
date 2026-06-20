@php
    $metaTitle = $title ?? 'Presensi QR Acanlogic';
    $metaDescription = $description ?? 'Sistem absensi presensi guru berbasis QR Code untuk SMK Islam Cipasung.';
    $metaRobots = $robots ?? 'noindex, nofollow, noarchive';
    $metaImage = $image ?? asset('assets/images/logo.jpeg');
    $metaUrl = $url ?? request()->url();
    $metaType = $type ?? 'website';
    $siteName = 'Presensi QR Acanlogic';
    $themeColor = $theme ?? '#0f766e';

    $structuredDataPayload = [
        '@context' => 'https://schema.org',
        '@type' => 'WebApplication',
        'name' => $siteName,
        'applicationCategory' => 'BusinessApplication',
        'operatingSystem' => 'All',
        'description' => $metaDescription,
        'inLanguage' => 'id',
        'url' => url('/'),
    ];
@endphp

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $metaTitle }}</title>
<meta name="description" content="{{ $metaDescription }}">
<meta name="robots" content="{{ $metaRobots }}">
<link rel="canonical" href="{{ $metaUrl }}">
<meta name="theme-color" content="{{ $themeColor }}">
<meta name="application-name" content="{{ $siteName }}">
<meta name="apple-mobile-web-app-title" content="{{ $siteName }}">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">

<!-- Open Graph -->
<meta property="og:title" content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:type" content="{{ $metaType }}">
<meta property="og:url" content="{{ $metaUrl }}">
<meta property="og:image" content="{{ $metaImage }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $metaTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
<meta name="twitter:image" content="{{ $metaImage }}">

<!-- Icons -->
<link rel="icon" href="{{ asset('assets/images/logo.jpeg') }}" type="image/jpeg">
<link rel="apple-touch-icon" href="{{ asset('assets/images/logo.jpeg') }}">

<!-- PWA Manifest -->
<link rel="manifest" href="{{ asset('manifest.webmanifest') }}">

<!-- Structured Data -->
<script type="application/ld+json">
{!! json_encode($structuredDataPayload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
