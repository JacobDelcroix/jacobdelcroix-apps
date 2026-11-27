@use('App\Support\Localized')
<x-layouts.site>
    <section class="mx-auto max-w-6xl px-5 sm:px-8 pt-16 sm:pt-24">
        <p class="rise text-sm uppercase tracking-[0.18em] text-ink-soft">{{ __('site.hero_kicker') }}</p>
        <h1 class="rise mt-5 max-w-3xl font-display text-5xl sm:text-7xl leading-[1.02] tracking-tight" style="--i: 1">
            {{ __('site.hero_title') }}
        </h1>
        <p class="rise mt-7 max-w-xl text-lg text-ink-soft leading-relaxed" style="--i: 2">{{ __('site.hero_text') }}</p>
    </section>

    <section class="mx-auto max-w-6xl px-5 sm:px-8 mt-20" aria-labelledby="apps-title">
        <h2 id="apps-title" class="sr-only">{{ __('site.apps_title') }}</h2>
        <div class="grid gap-6 md:grid-cols-2">
            @foreach ($apps as $app)
                <a href="{{ Localized::route('apps.show', ['app' => $app->slug]) }}"
                   class="rise group relative overflow-hidden rounded-[2rem] p-8 sm:p-10 text-white min-h-[22rem] flex flex-col justify-between transition-transform duration-300 hover:-translate-y-1"
                   style="--i: {{ $loop->index + 3 }}; background: radial-gradient(120% 90% at 100% 0%, {{ $app->accentSoft }}55 0%, transparent 55%), {{ $app->accent }};">
                    <div class="flex items-start justify-between gap-6">
                        <img src="{{ $app->iconUrl() }}" alt="" width="88" height="88"
                             class="size-20 sm:size-22 rounded-[1.35rem] shadow-lg shadow-black/25 ring-1 ring-white/15">
                        <span class="flex gap-1.5 text-xs">
                            @foreach ($app->platforms as $platform)
                                <span class="rounded-full bg-white/12 px-2.5 py-1">{{ __('site.platform.'.$platform) }}</span>
                            @endforeach
                        </span>
                    </div>
                    <div class="mt-10">
                        <h3 class="font-display text-4xl tracking-tight">{{ $app->name }}</h3>
                        <p class="mt-3 max-w-md text-white/80 text-lg leading-snug">{{ $app->tagline() }}</p>
                        <span class="mt-6 inline-flex items-center gap-2 text-sm font-medium">
                            {{ __('site.discover') }}
                            <svg aria-hidden="true" viewBox="0 0 20 20" class="size-4 fill-current transition-transform group-hover:translate-x-1"><path d="M11.3 4.3a1 1 0 0 1 1.4 0l5 5a1 1 0 0 1 0 1.4l-5 5a1 1 0 0 1-1.4-1.4l3.3-3.3H3a1 1 0 1 1 0-2h11.6l-3.3-3.3a1 1 0 0 1 0-1.4Z"/></svg>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-5 sm:px-8 mt-24" aria-labelledby="principles-title">
        <h2 id="principles-title" class="font-display text-3xl tracking-tight">{{ __('site.principles_title') }}</h2>
        <div class="mt-8 grid gap-px overflow-hidden rounded-3xl border border-line bg-line sm:grid-cols-3">
            @foreach (__('site.principles') as [$heading, $text])
                <div class="bg-card p-7">
                    <p class="font-display text-4xl text-ink-soft/50">0{{ $loop->iteration }}</p>
                    <h3 class="mt-4 font-semibold text-lg">{{ $heading }}</h3>
                    <p class="mt-2 text-ink-soft leading-relaxed">{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </section>
</x-layouts.site>
