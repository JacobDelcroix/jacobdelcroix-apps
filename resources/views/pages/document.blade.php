@use('App\Support\Localized')
@php($heading = __('site.'.$page.'_title', ['name' => $app->name]))
<x-layouts.site :title="$heading" :icon="$app->iconUrl()">
    <article class="mx-auto max-w-3xl px-5 sm:px-8 pt-14">
        <a href="{{ Localized::route('apps.show', ['app' => $app->slug]) }}" class="inline-flex items-center gap-3 text-sm text-ink-soft hover:text-ink">
            <img src="{{ $app->iconUrl() }}" alt="" width="32" height="32" class="size-8 rounded-lg">
            {{ __('site.back_to_app', ['name' => $app->name]) }}
        </a>
        <h1 class="mt-8 font-display text-4xl sm:text-5xl tracking-tight">{{ $heading }}</h1>
        <div class="prose-doc mt-6">
            {!! $html !!}
        </div>
    </article>
</x-layouts.site>
