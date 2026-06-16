@props(['name' => 'spark', 'class' => 'icon'])

@php
    $icons = [
        'dashboard' => 'M4 13h7V4H4v9Zm0 7h7v-5H4v5Zm9 0h7v-9h-7v9Zm0-11h7V4h-7v5Z',
        'users' => 'M16 11c1.66 0 3-1.34 3-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3ZM8 11c1.66 0 3-1.34 3-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3Zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4Zm8 0c-.31 0-.65.02-1.03.05 1.33.96 2.03 2.2 2.03 3.95v2h7v-2c0-2.66-5.33-4-8-4Z',
        'scan' => 'M4 4h6v2H6v4H4V4Zm10 0h6v6h-2V6h-4V4ZM4 14h2v4h4v2H4v-6Zm18 0v6h-6v-2h4v-4h2ZM8 8h8v8H8V8Zm2 2v4h4v-4h-4Z',
        'report' => 'M6 2h9l5 5v15H6V2Zm8 1.5V8h4.5L14 3.5ZM9 12h8v2H9v-2Zm0 4h8v2H9v-2Z',
        'bell' => 'M12 22a2.5 2.5 0 0 0 2.45-2h-4.9A2.5 2.5 0 0 0 12 22Zm7-6v-5a7 7 0 1 0-14 0v5l-2 2v1h20v-1l-2-2Z',
        'check' => 'M9 16.2 4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2Z',
        'clock' => 'M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm1 11h5v-2h-4V6h-2v7Z',
        'send' => 'M2 21 23 12 2 3v7l15 2-15 2v7Z',
        'card' => 'M3 5h18a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Zm0 4h18V7H3v2Zm3 5h7v2H6v-2Z',
        'edit' => 'M4 17.25V21h3.75L18.8 9.95l-3.75-3.75L4 17.25ZM21 7.05a1 1 0 0 0 0-1.4L18.35 3a1 1 0 0 0-1.4 0l-1.85 1.85 3.75 3.75L21 7.05Z',
        'trash' => 'M6 19c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V7H6v12ZM8 4l1-1h6l1 1h4v2H4V4h4Z',
        'spark' => 'M12 2 9.8 8.2 4 10.5l5.8 2.3L12 20l2.2-7.2 5.8-2.3-5.8-2.3L12 2Z',
        'shield' => 'M12 2 4 5v6c0 5 3.4 9.7 8 11 4.6-1.3 8-6 8-11V5l-8-3Z',
    ];
@endphp

<svg {{ $attributes->merge(['class' => $class, 'viewBox' => '0 0 24 24', 'aria-hidden' => 'true']) }}>
    <path d="{{ $icons[$name] ?? $icons['spark'] }}"></path>
</svg>
