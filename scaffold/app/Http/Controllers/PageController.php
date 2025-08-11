<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Page;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(Request $request): View|ViewContract
    {
        $page = Page::query()->where('slug', 'home')->first();
        if (!$page) {
            abort(404, 'Homepage not found. Run seeders to create it.');
        }
        return $this->renderPage($page);
    }

    public function show(Request $request, string $slug): View|ViewContract
    {
        $page = Page::query()->where('slug', $slug)->firstOrFail();
        return $this->renderPage($page);
    }

    protected function renderPage(Page $page): View|ViewContract
    {
        $headerMenu = Menu::query()->where('location', 'header')->where('is_active', true)->with('items.children')->first();
        $footerMenu = Menu::query()->where('location', 'footer')->where('is_active', true)->with('items.children')->first();

        $sections = $page->sections()->get();
        return view('pages.show', compact('page', 'sections', 'headerMenu', 'footerMenu'));
    }
}