<?php

declare(strict_types=1);

use App\Support\AppCatalog;

dataset('pages', function (): array {
    $pages = ['/', '/en', '/mentions-legales', '/en/legal-notice'];

    foreach (['atout-tarot', 'hooparo'] as $slug) {
        array_push(
            $pages,
            "/{$slug}", "/{$slug}/confidentialite", "/{$slug}/support",
            "/en/{$slug}", "/en/{$slug}/privacy", "/en/{$slug}/support",
        );
    }

    return $pages;
});

it('serves every page', function (string $path): void {
    $this->get($path)->assertOk()->assertSee('Jacob Delcroix');
})->with('pages');

it('renders each page in its own language with a link to the other one', function (): void {
    $this->get('/atout-tarot/confidentialite')
        ->assertSee('<html lang="fr">', false)
        ->assertSee('Politique de confidentialité')
        ->assertSee('href="'.url('/en/atout-tarot/privacy').'"', false);

    $this->get('/en/atout-tarot/privacy')
        ->assertSee('<html lang="en">', false)
        ->assertSee('Privacy Policy')
        ->assertSee('href="'.url('/atout-tarot/confidentialite').'"', false);
});

it('leaves no placeholder in the legal documents', function (string $path): void {
    $this->get($path)
        ->assertDontSee('{email}')
        ->assertDontSee('{publisher}')
        ->assertDontSee('[NOM')
        ->assertDontSee('[PUBLISHER')
        ->assertSee(config('apps.publisher.email'));
})->with([
    '/atout-tarot/confidentialite', '/en/atout-tarot/privacy',
    '/hooparo/confidentialite', '/en/hooparo/privacy',
    '/atout-tarot/support', '/en/hooparo/support',
]);

it('mentions ads only in the privacy policy of apps that show them', function (): void {
    $this->get('/atout-tarot/confidentialite')->assertSee('AdMob');
    $this->get('/hooparo/confidentialite')->assertDontSee('AdMob');
});

it('returns 404 for an unknown app', function (): void {
    $this->get('/unknown-app')->assertNotFound();
    $this->get('/en/unknown-app/privacy')->assertNotFound();
});

it('serves app-ads.txt as plain text at the root', function (): void {
    $this->get('/app-ads.txt')
        ->assertOk()
        ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
        ->assertSee('google.com, pub-4373645067445165, DIRECT, f08c47fec0942fa0', false);
});

it('lists only live apps in the other-apps feed, minus the asking app', function (): void {
    config()->set('apps.apps.hooparo.stores.ios', 'https://apps.apple.com/app/id1');
    config()->set('apps.apps.atout-tarot.stores.ios', 'https://apps.apple.com/app/id2');

    $this->getJson('/apps.json?except=atout-tarot')
        ->assertOk()
        ->assertJsonCount(1)
        ->assertJsonPath('0.name', 'Hooparo')
        ->assertJsonPath('0.ios', 'https://apps.apple.com/app/id1')
        ->assertJsonPath('0.android', null)
        ->assertJsonStructure([['name', 'description' => ['fr', 'en'], 'icon', 'ios', 'android']]);

    config()->set('apps.apps.hooparo.stores.ios', null);
    config()->set('apps.apps.atout-tarot.stores.ios', null);

    $this->getJson('/apps.json')->assertOk()->assertExactJson([]);
});

it('shows store badges once an app is live and "coming soon" before', function (): void {
    $this->get('/hooparo')->assertSee('Bientôt sur les stores');

    config()->set('apps.apps.hooparo.stores.ios', 'https://apps.apple.com/app/id1');

    $this->get('/hooparo')
        ->assertDontSee('Bientôt sur les stores')
        ->assertSee('https://apps.apple.com/app/id1', false);
});

it('lists every page in the sitemap', function (): void {
    $this->get('/sitemap.xml')
        ->assertOk()
        ->assertSee(url('/en/hooparo/privacy'), false)
        ->assertSee(url('/atout-tarot/confidentialite'), false);
});

it('keeps the French and English strings in sync', function (): void {
    $fr = require lang_path('fr/site.php');
    $en = require lang_path('en/site.php');

    expect(array_keys($fr))->toEqualCanonicalizing(array_keys($en));
});

it('has every content file in both languages', function (): void {
    foreach (app(AppCatalog::class)->slugs() as $slug) {
        foreach (['privacy', 'support'] as $page) {
            foreach (['fr', 'en'] as $locale) {
                expect(resource_path("content/{$slug}/{$page}.{$locale}.md"))->toBeFile();
            }
        }

        expect(public_path("images/apps/{$slug}/icon.png"))->toBeFile();
    }
});
