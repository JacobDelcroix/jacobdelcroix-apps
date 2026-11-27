@use('App\Support\Localized')
<x-layouts.site :title="$app->name" :description="$app->summary()" :icon="$app->iconUrl()" :og-image="$app->iconUrl()">
    <section class="mx-auto max-w-6xl px-5 sm:px-8 pt-10">
        <div class="relative overflow-hidden rounded-[2.25rem] px-7 py-12 sm:px-14 sm:py-16 text-white"
             style="background: radial-gradient(110% 100% at 100% 0%, {{ $app->accentSoft }}66 0%, transparent 55%), {{ $app->accent }};">
            <div class="grid gap-10 md:grid-cols-[auto_1fr] md:items-center">
                <img src="{{ $app->iconUrl() }}" alt="{{ $app->name }}" width="160" height="160"
                     class="rise size-32 sm:size-40 rounded-[2.25rem] shadow-2xl shadow-black/30 ring-1 ring-white/15">
                <div>
                    <h1 class="rise font-display text-5xl sm:text-6xl tracking-tight" style="--i: 1">{{ $app->name }}</h1>
                    <p class="rise mt-4 max-w-2xl text-xl text-white/85 leading-snug" style="--i: 2">{{ $app->tagline() }}</p>
                    <p class="rise mt-4 max-w-2xl text-white/70 leading-relaxed" style="--i: 3">{{ $app->summary() }}</p>
                    <div class="rise mt-8 [&_a]:bg-white [&_a]:text-ink [&_span]:border-white/30 [&_span]:text-white/80" style="--i: 4">
                        <x-store-badges :app="$app" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($app->screenshots > 0)
        <section class="mt-16" aria-labelledby="shots-title">
            <h2 id="shots-title" class="sr-only">{{ __('site.screenshots_title') }}</h2>
            <div class="mx-auto max-w-6xl px-5 sm:px-8 flex gap-5 overflow-x-auto snap-x pb-4">
                @foreach ($app->screenshotUrls() as $url)
                    <img src="{{ $url }}" alt="{{ __('site.screenshots_title') }} {{ $loop->iteration }}" loading="lazy"
                         width="507" height="1100"
                         class="snap-start h-[30rem] w-auto rounded-3xl border border-line shadow-sm">
                @endforeach
            </div>
        </section>
    @endif

    <section class="mx-auto max-w-6xl px-5 sm:px-8 mt-16" aria-labelledby="features-title">
        <h2 id="features-title" class="font-display text-3xl tracking-tight">{{ __('site.features_title', ['name' => $app->name]) }}</h2>
        <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($app->features() as [$heading, $text])
                <div class="rounded-3xl border border-line bg-card p-7">
                    <span class="block h-1 w-10 rounded-full" style="background: {{ $app->accentSoft }}"></span>
                    <h3 class="mt-5 font-semibold text-lg">{{ $heading }}</h3>
                    <p class="mt-2 text-ink-soft leading-relaxed">{{ $text }}</p>
                </div>
            @endforeach
        </div>
        @if ($app->note() !== '')
            <p class="mt-8 max-w-3xl text-ink-soft leading-relaxed">{{ $app->note() }}</p>
        @endif
    </section>

    <section class="mx-auto max-w-6xl px-5 sm:px-8 mt-16">
        <div class="flex flex-wrap gap-3">
            <a href="{{ Localized::route('apps.support', ['app' => $app->slug]) }}" class="rounded-full border border-line px-5 py-2.5 hover:bg-paper-deep transition-colors">{{ __('site.support') }}</a>
            <a href="{{ Localized::route('apps.privacy', ['app' => $app->slug]) }}" class="rounded-full border border-line px-5 py-2.5 hover:bg-paper-deep transition-colors">{{ __('site.privacy') }}</a>
            @if ($app->hasDocument('terms'))
                <a href="{{ Localized::route('apps.terms', ['app' => $app->slug]) }}" class="rounded-full border border-line px-5 py-2.5 hover:bg-paper-deep transition-colors">{{ __('site.terms') }}</a>
            @endif
        </div>
    </section>
</x-layouts.site>
