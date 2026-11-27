<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Support\AppCatalog;
use App\Support\Localized;
use Illuminate\Console\Command;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

/**
 * Renders every page to plain files, for static hosting (GitHub Pages):
 * /atout-tarot/confidentialite becomes atout-tarot/confidentialite/index.html.
 */
final class ExportStaticSite extends Command
{
    protected $signature = 'site:export
        {directory : Where to write the site}
        {--url= : Public root URL of the static site, e.g. https://jacobdelcroix.github.io}';

    protected $description = 'Export the site as static files';

    public function handle(Kernel $kernel, AppCatalog $catalog): int
    {
        $directory = rtrim((string) $this->argument('directory'), '/');
        $rootUrl = rtrim((string) ($this->option('url') ?: config('app.url')), '/');

        config()->set('app.url', $rootUrl);
        URL::forceRootUrl($rootUrl);
        URL::forceScheme((string) parse_url($rootUrl, PHP_URL_SCHEME));

        File::ensureDirectoryExists($directory);

        foreach ($this->paths($catalog) as $path => $file) {
            $response = $kernel->handle(Request::create($rootUrl.$path));

            if ($response->getStatusCode() !== 200) {
                $this->error("{$path} answered {$response->getStatusCode()}");

                return self::FAILURE;
            }

            File::ensureDirectoryExists(dirname($directory.'/'.$file));
            File::put($directory.'/'.$file, (string) $response->getContent());
            $this->line("  {$path}");
        }

        foreach (['build', 'images'] as $folder) {
            File::copyDirectory(public_path($folder), $directory.'/'.$folder);
        }

        foreach (['favicon.ico', 'robots.txt'] as $file) {
            File::copy(public_path($file), $directory.'/'.$file);
        }

        // GitHub Pages: serve folders as they are, no Jekyll processing.
        File::put($directory.'/.nojekyll', '');

        $this->info("Site exported to {$directory} for {$rootUrl}");

        return self::SUCCESS;
    }

    /**
     * @return array<string, string> URL path => file path
     */
    private function paths(AppCatalog $catalog): array
    {
        $paths = [
            '/app-ads.txt' => 'app-ads.txt',
            '/apps.json' => 'apps.json',
            '/sitemap.xml' => 'sitemap.xml',
        ];

        // Static hosts ignore query strings: one "other apps" feed per app.
        foreach ($catalog->slugs() as $slug) {
            $paths['/apps.json?except='.$slug] = 'apps/'.$slug.'.json';
        }

        foreach (Localized::LOCALES as $locale) {
            $prefix = Localized::prefix($locale) === '' ? '' : '/'.Localized::prefix($locale);
            $pages = ['', '/'.Localized::segment('legal', $locale)];

            foreach ($catalog->slugs() as $slug) {
                array_push($pages, "/{$slug}", "/{$slug}/".Localized::segment('privacy', $locale), "/{$slug}/support");
            }

            foreach ($pages as $page) {
                $path = $prefix.$page;
                $paths[$path === '' ? '/' : $path] = ltrim($path.'/index.html', '/');
            }
        }

        return $paths;
    }
}
