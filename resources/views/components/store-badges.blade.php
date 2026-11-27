@props(['app'])
{{-- Store links for an app, or a "coming soon" pill while it is not live. --}}
<div {{ $attributes->class('flex flex-wrap items-center gap-3') }}>
    @if ($app->isAvailable())
        @if ($app->stores['ios'])
            <a href="{{ $app->stores['ios'] }}" rel="noopener"
               class="inline-flex items-center gap-2.5 rounded-xl bg-ink text-paper px-4 py-2.5 hover:opacity-90 transition-opacity">
                <svg aria-hidden="true" viewBox="0 0 24 24" class="size-5 fill-current"><path d="M16.37 12.6c-.02-2.3 1.88-3.4 1.97-3.46-1.07-1.57-2.74-1.78-3.33-1.8-1.42-.15-2.77.83-3.49.83-.72 0-1.83-.81-3.01-.79-1.55.02-2.98.9-3.78 2.29-1.61 2.8-.41 6.94 1.16 9.21.77 1.11 1.68 2.36 2.88 2.31 1.16-.05 1.59-.75 2.99-.75 1.4 0 1.79.75 3.01.72 1.24-.02 2.03-1.13 2.79-2.25.88-1.29 1.24-2.53 1.26-2.6-.03-.01-2.42-.93-2.45-3.71ZM14.07 5.85c.64-.77 1.07-1.85.95-2.92-.92.04-2.03.61-2.69 1.38-.59.68-1.11 1.78-.97 2.83 1.02.08 2.07-.52 2.71-1.29Z"/></svg>
                <span class="text-sm font-medium">{{ __('site.download_ios') }}</span>
            </a>
        @endif
        @if ($app->stores['android'])
            <a href="{{ $app->stores['android'] }}" rel="noopener"
               class="inline-flex items-center gap-2.5 rounded-xl bg-ink text-paper px-4 py-2.5 hover:opacity-90 transition-opacity">
                <svg aria-hidden="true" viewBox="0 0 24 24" class="size-5 fill-current"><path d="M3.6 2.2c-.2.2-.3.6-.3 1v17.6c0 .4.1.8.3 1l.1.1 9.9-9.9v-.2L3.7 2.1l-.1.1Zm13.3 13.2-3.3-3.3v-.2l3.3-3.3.1.1 3.9 2.2c1.1.6 1.1 1.7 0 2.3l-3.9 2.2h-.1Zm-.1.1L13.4 12l-10 10c.4.4 1 .4 1.7.1l11.7-6.6Zm0-7L5.1 1.9c-.7-.4-1.3-.3-1.7.1l10 10 3.4-3.5Z"/></svg>
                <span class="text-sm font-medium">{{ __('site.download_android') }}</span>
            </a>
        @endif
    @else
        <span class="inline-flex items-center gap-2 rounded-full border border-line px-3.5 py-1.5 text-sm text-ink-soft">
            <span class="size-1.5 rounded-full bg-current"></span>
            {{ __('site.coming_soon') }}
        </span>
    @endif
</div>
