<?php

declare(strict_types=1);

use App\Http\Controllers\FeedController;
use App\Http\Controllers\PageController;
use App\Support\AppCatalog;
use App\Support\Localized;
use Illuminate\Support\Facades\Route;

Route::get('app-ads.txt', [FeedController::class, 'appAds'])->name('app-ads');
Route::get('apps.json', [FeedController::class, 'apps'])->name('apps-feed');
Route::get('sitemap.xml', [FeedController::class, 'sitemap'])->name('sitemap');

$slugs = app(AppCatalog::class)->slugs();

foreach (Localized::LOCALES as $locale) {
    Route::prefix(Localized::prefix($locale))
        ->name($locale.'.')
        ->middleware('locale:'.$locale)
        ->group(function () use ($locale, $slugs): void {
            Route::get('/', [PageController::class, 'home'])->name('home');
            Route::get(Localized::segment('legal', $locale), [PageController::class, 'legal'])->name('legal');
            Route::get('{app}', [PageController::class, 'app'])->whereIn('app', $slugs)->name('apps.show');
            Route::get('{app}/'.Localized::segment('privacy', $locale), [PageController::class, 'privacy'])->whereIn('app', $slugs)->name('apps.privacy');
            Route::get('{app}/'.Localized::segment('terms', $locale), [PageController::class, 'terms'])->whereIn('app', $slugs)->name('apps.terms');
            Route::get('{app}/support', [PageController::class, 'support'])->whereIn('app', $slugs)->name('apps.support');
        });
}
