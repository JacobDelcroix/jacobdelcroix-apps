<?php

declare(strict_types=1);

namespace App\Support;

/**
 * The publisher's apps, in the order of config/apps.php.
 */
final class AppCatalog
{
    /**
     * @return list<StoreApp>
     */
    public function all(): array
    {
        /** @var array<string, array<string, mixed>> $apps */
        $apps = config('apps.apps', []);

        return array_values(array_map(
            static fn (string $slug, array $config): StoreApp => StoreApp::fromConfig($slug, $config),
            array_keys($apps),
            $apps,
        ));
    }

    public function find(string $slug): ?StoreApp
    {
        foreach ($this->all() as $app) {
            if ($app->slug === $slug) {
                return $app;
            }
        }

        return null;
    }

    /**
     * @return list<string>
     */
    public function slugs(): array
    {
        return array_keys((array) config('apps.apps', []));
    }
}
