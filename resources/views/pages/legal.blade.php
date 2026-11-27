@use('App\Support\Localized')
<x-layouts.site :title="__('site.legal_title')">
    <article class="mx-auto max-w-3xl px-5 sm:px-8 pt-14">
        <h1 class="font-display text-4xl sm:text-5xl tracking-tight">{{ __('site.legal_title') }}</h1>
        <div class="prose-doc mt-6">
            <h2>{{ __('site.legal_publisher') }}</h2>
            <p>{{ __('site.legal_publisher_text', ['name' => config('apps.publisher.name')]) }}</p>
            <h2>{{ __('site.legal_contact') }}</h2>
            <p><a href="mailto:{{ config('apps.publisher.email') }}">{{ config('apps.publisher.email') }}</a></p>
            <h2>{{ __('site.legal_hosting') }}</h2>
            <p>{{ __('site.legal_hosting_text') }}</p>
            <h2>{{ __('site.legal_data') }}</h2>
            <p>{{ __('site.legal_data_text') }}</p>
            <ul>
                @foreach ($apps as $app)
                    <li><a href="{{ Localized::route('apps.privacy', ['app' => $app->slug]) }}">{{ $app->name }}</a></li>
                @endforeach
            </ul>
            <h2>{{ __('site.legal_ip') }}</h2>
            <p>{{ __('site.legal_ip_text') }}</p>
        </div>
    </article>
</x-layouts.site>
