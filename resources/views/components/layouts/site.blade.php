@use('App\Support\Localized')
@php
    $alternates = Localized::alternates();
    $locale = app()->getLocale();
    $otherLocale = $locale === 'fr' ? 'en' : 'fr';
    $pageTitle = isset($title) ? $title.' · '.__('site.title') : __('site.title');
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $description ?? __('site.description') }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $description ?? __('site.description') }}">
    <meta property="og:type" content="website">
    @isset($ogImage)
        <meta property="og:image" content="{{ $ogImage }}">
    @endisset
    @foreach ($alternates as $code => $url)
        <link rel="alternate" hreflang="{{ $code }}" href="{{ $url }}">
    @endforeach
    @isset($alternates['fr'])
        <link rel="alternate" hreflang="x-default" href="{{ $alternates['fr'] }}">
    @endisset
    <meta name="theme-color" content="#f6f1e7" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#14131b" media="(prefers-color-scheme: dark)">
    <link rel="icon" href="{{ $icon ?? asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:400,500,600|instrument-sans:400,500,600" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen">
<a href="#content" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-50 bg-ink text-paper px-4 py-2 rounded-full">{{ __('site.skip') }}</a>

<header class="mx-auto max-w-6xl px-5 sm:px-8 pt-6 flex items-center justify-between gap-4">
    <a href="{{ Localized::route('home') }}" class="group flex items-center gap-3">
        <span class="grid size-9 place-items-center rounded-full bg-ink text-paper font-display text-lg leading-none">J</span>
        <span class="font-display text-lg tracking-tight">Jacob Delcroix <span class="text-ink-soft">· apps</span></span>
    </a>
    <nav class="flex items-center gap-1 text-sm">
        @isset($alternates[$otherLocale])
            <a href="{{ $alternates[$otherLocale] }}" hreflang="{{ $otherLocale }}" lang="{{ $otherLocale }}"
               aria-label="{{ __('site.switch_language_label') }}"
               class="rounded-full border border-line px-3.5 py-1.5 hover:bg-paper-deep transition-colors">{{ __('site.switch_language') }}</a>
        @endisset
    </nav>
</header>

<main id="content">
    {{ $slot }}
</main>

<footer class="mt-24 border-t border-line">
    <div class="mx-auto max-w-6xl px-5 sm:px-8 py-12 grid gap-10 sm:grid-cols-3 text-sm">
        <div>
            <p class="font-display text-lg">Jacob Delcroix</p>
            <p class="mt-2 text-ink-soft">{{ __('site.footer_made_by', ['name' => config('apps.publisher.name')]) }}</p>
        </div>
        <div>
            <p class="font-semibold">{{ __('site.nav_apps') }}</p>
            <ul class="mt-3 space-y-2">
                @foreach (app(\App\Support\AppCatalog::class)->all() as $footerApp)
                    <li><a class="text-ink-soft hover:text-ink" href="{{ Localized::route('apps.show', ['app' => $footerApp->slug]) }}">{{ $footerApp->name }}</a></li>
                @endforeach
            </ul>
        </div>
        <div>
            <p class="font-semibold">{{ __('site.contact') }}</p>
            <ul class="mt-3 space-y-2">
                <li><a class="text-ink-soft hover:text-ink" href="mailto:{{ config('apps.publisher.email') }}">{{ config('apps.publisher.email') }}</a></li>
                <li><a class="text-ink-soft hover:text-ink" href="{{ Localized::route('legal') }}">{{ __('site.legal') }}</a></li>
            </ul>
        </div>
    </div>
    <p class="mx-auto max-w-6xl px-5 sm:px-8 pb-10 text-xs text-ink-soft">© {{ date('Y') }} {{ config('apps.publisher.name') }}</p>
</footer>
</body>
</html>
