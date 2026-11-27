<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

it('exports every page as static files with the public root URL', function (): void {
    $directory = storage_path('framework/testing/static-export');
    File::deleteDirectory($directory);

    $this->artisan('site:export', ['directory' => $directory, '--url' => 'https://example.github.io'])
        ->assertSuccessful();

    foreach ([
        'index.html', 'en/index.html', 'mentions-legales/index.html', 'en/legal-notice/index.html',
        'atout-tarot/index.html', 'atout-tarot/confidentialite/index.html', 'atout-tarot/support/index.html',
        'en/atout-tarot/privacy/index.html', 'en/hooparo/support/index.html',
        'app-ads.txt', 'apps.json', 'apps/atout-tarot.json', 'sitemap.xml', '.nojekyll',
        'images/apps/atout-tarot/icon.png',
    ] as $file) {
        expect($directory.'/'.$file)->toBeFile();
    }

    expect(File::get($directory.'/atout-tarot/confidentialite/index.html'))
        ->toContain('https://example.github.io/en/atout-tarot/privacy')
        ->toContain('https://example.github.io/build/assets/');

    File::deleteDirectory($directory);
});
