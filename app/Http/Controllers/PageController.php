<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\AppCatalog;
use App\Support\StoreApp;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

final class PageController extends Controller
{
    public function __construct(private readonly AppCatalog $catalog) {}

    public function home(): View
    {
        return view('pages.home', ['apps' => $this->catalog->all()]);
    }

    public function app(string $app): View
    {
        return view('pages.app', ['app' => $this->findOrFail($app)]);
    }

    public function privacy(string $app): View
    {
        return $this->document($this->findOrFail($app), 'privacy');
    }

    public function terms(string $app): View
    {
        return $this->document($this->findOrFail($app), 'terms');
    }

    public function support(string $app): View
    {
        return $this->document($this->findOrFail($app), 'support');
    }

    public function legal(): View
    {
        return view('pages.legal', ['apps' => $this->catalog->all()]);
    }

    /**
     * A Markdown page from resources/content/{slug}/{page}.{locale}.md.
     */
    private function document(StoreApp $app, string $page): View
    {
        abort_unless($app->hasDocument($page), 404);
        $path = $app->documentPath($page, app()->getLocale());

        $markdown = strtr(File::get($path), [
            '{email}' => (string) config('apps.publisher.email'),
            '{publisher}' => (string) config('apps.publisher.name'),
        ]);

        return view('pages.document', [
            'app' => $app,
            'page' => $page,
            'html' => Str::markdown($markdown, ['html_input' => 'strip', 'allow_unsafe_links' => false]),
        ]);
    }

    private function findOrFail(string $slug): StoreApp
    {
        return $this->catalog->find($slug) ?? abort(404);
    }
}
