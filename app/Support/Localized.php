<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Facades\Route;

/**
 * French lives at the root, English under /en. Every page is registered
 * once per locale ("fr.*" / "en.*" route names) with translated slugs.
 */
final class Localized
{
    public const array LOCALES = ['fr', 'en'];

    /**
     * Translated URL segments.
     *
     * @var array<string, array<string, string>>
     */
    public const array SEGMENTS = [
        'fr' => ['privacy' => 'confidentialite', 'legal' => 'mentions-legales'],
        'en' => ['privacy' => 'privacy', 'legal' => 'legal-notice'],
    ];

    public static function segment(string $key, string $locale): string
    {
        return self::SEGMENTS[$locale][$key];
    }

    public static function prefix(string $locale): string
    {
        return $locale === 'fr' ? '' : $locale;
    }

    /**
     * @param  array<string, mixed>  $parameters
     */
    public static function route(string $name, array $parameters = [], ?string $locale = null): string
    {
        return route(($locale ?? app()->getLocale()).'.'.$name, $parameters);
    }

    /**
     * The same page in the other locales, for the language switch and hreflang.
     *
     * @return array<string, string>
     */
    public static function alternates(): array
    {
        $current = Route::current();
        $name = $current?->getName();

        if ($current === null || $name === null || ! preg_match('/^(fr|en)\.(.+)$/', $name, $matches)) {
            return [];
        }

        $alternates = [];

        foreach (self::LOCALES as $locale) {
            $alternates[$locale] = route($locale.'.'.$matches[2], $current->parameters());
        }

        return $alternates;
    }
}
