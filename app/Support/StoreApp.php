<?php

declare(strict_types=1);

namespace App\Support;

/**
 * One app of the catalogue (config/apps.php), with its texts resolved for
 * the current locale.
 */
final readonly class StoreApp
{
    /**
     * @param  list<string>  $platforms
     * @param  array{ios: ?string, android: ?string}  $stores
     * @param  array<string, string>  $tagline
     * @param  array<string, string>  $summary
     * @param  array<string, list<array{0: string, 1: string}>>  $features
     * @param  array<string, string>  $note
     */
    public function __construct(
        public string $slug,
        public string $name,
        public string $accent,
        public string $accentSoft,
        public array $platforms,
        public array $stores,
        public bool $hasAds,
        public int $screenshots,
        private array $tagline,
        private array $summary,
        private array $features,
        private array $note,
    ) {}

    /**
     * @param  array<string, mixed>  $config
     */
    public static function fromConfig(string $slug, array $config): self
    {
        /** @var array{ios?: ?string, android?: ?string} $stores */
        $stores = $config['stores'] ?? [];

        return new self(
            slug: $slug,
            name: (string) $config['name'],
            accent: (string) $config['accent'],
            accentSoft: (string) $config['accent_soft'],
            platforms: array_values((array) $config['platforms']),
            stores: [
                'ios' => self::url($stores['ios'] ?? null),
                'android' => self::url($stores['android'] ?? null),
            ],
            hasAds: (bool) ($config['has_ads'] ?? false),
            screenshots: (int) ($config['screenshots'] ?? 0),
            tagline: (array) $config['tagline'],
            summary: (array) $config['summary'],
            features: (array) $config['features'],
            note: (array) ($config['note'] ?? []),
        );
    }

    public function tagline(?string $locale = null): string
    {
        return $this->localized($this->tagline, $locale);
    }

    public function summary(?string $locale = null): string
    {
        return $this->localized($this->summary, $locale);
    }

    public function note(?string $locale = null): string
    {
        return $this->localized($this->note, $locale);
    }

    /**
     * @return list<array{0: string, 1: string}>
     */
    public function features(?string $locale = null): array
    {
        $locale ??= app()->getLocale();

        return $this->features[$locale] ?? $this->features['en'] ?? [];
    }

    /**
     * Markdown source of a page (privacy, terms, support) in resources/content/{slug}/.
     */
    public function documentPath(string $page, string $locale): string
    {
        return resource_path('content/'.$this->slug.'/'.$page.'.'.$locale.'.md');
    }

    /**
     * Optional pages, like the terms of use, only exist for some apps.
     */
    public function hasDocument(string $page): bool
    {
        return is_file($this->documentPath($page, 'fr')) && is_file($this->documentPath($page, 'en'));
    }

    public function iconUrl(): string
    {
        return asset('images/apps/'.$this->slug.'/icon.png');
    }

    /**
     * @return list<string>
     */
    public function screenshotUrls(?string $locale = null): array
    {
        $locale ??= app()->getLocale();
        $urls = [];

        for ($i = 1; $i <= $this->screenshots; $i++) {
            $urls[] = asset('images/apps/'.$this->slug.'/'.$locale.'-'.$i.'.jpg');
        }

        return $urls;
    }

    public function isAvailable(): bool
    {
        return array_filter($this->stores) !== [];
    }

    /**
     * @param  array<string, string>  $texts
     */
    private function localized(array $texts, ?string $locale): string
    {
        $locale ??= app()->getLocale();

        return $texts[$locale] ?? $texts['en'] ?? '';
    }

    private static function url(mixed $value): ?string
    {
        return is_string($value) && str_starts_with($value, 'https://') ? $value : null;
    }
}
