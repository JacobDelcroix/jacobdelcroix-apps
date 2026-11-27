<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\AppCatalog;
use App\Support\Localized;
use App\Support\StoreApp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class FeedController extends Controller
{
    public function __construct(private readonly AppCatalog $catalog) {}

    /**
     * IAB app-ads.txt, read by AdMob at the root of the developer website.
     */
    public function appAds(): Response
    {
        /** @var list<string> $lines */
        $lines = config('apps.app_ads', []);

        return response(implode("\n", $lines)."\n", 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    /**
     * The "Our other apps" list the apps download. `?except=slug` leaves the
     * asking app out. Only apps live on a store are listed.
     */
    public function apps(Request $request): JsonResponse
    {
        $except = $request->string('except')->toString();

        $apps = array_values(array_filter(
            $this->catalog->all(),
            static fn (StoreApp $app): bool => $app->slug !== $except && $app->isAvailable(),
        ));

        return response()->json(array_map(static fn (StoreApp $app): array => [
            'slug' => $app->slug,
            'name' => $app->name,
            'description' => ['fr' => $app->tagline('fr'), 'en' => $app->tagline('en')],
            'icon' => $app->iconUrl(),
            'ios' => $app->stores['ios'],
            'android' => $app->stores['android'],
            'url' => Localized::route('apps.show', ['app' => $app->slug], 'fr'),
        ], $apps), 200, ['Cache-Control' => 'public, max-age=3600']);
    }

    public function sitemap(): Response
    {
        $urls = [];

        foreach (Localized::LOCALES as $locale) {
            $urls[] = Localized::route('home', [], $locale);
            $urls[] = Localized::route('legal', [], $locale);

            foreach ($this->catalog->all() as $app) {
                foreach (['apps.show', 'apps.privacy', 'apps.support'] as $name) {
                    $urls[] = Localized::route($name, ['app' => $app->slug], $locale);
                }

                if ($app->hasDocument('terms')) {
                    $urls[] = Localized::route('apps.terms', ['app' => $app->slug], $locale);
                }
            }
        }

        return response()->view('sitemap', ['urls' => $urls], 200, ['Content-Type' => 'application/xml']);
    }
}
