<?php

namespace App\Http\Controllers;

use App\Services\SiteService;
use Modules\PageHome\Services\PageHomeService;

class HomeController extends Controller
{
    public function index(SiteService $alternates, PageHomeService $page)
    {
        $alternates->setAlternates('home')
            ->setMenuActive('home');

        return view('front.pages.home', [
            'header_home' => true,
            'page' => $page->getPage()
        ]);
    }
}
