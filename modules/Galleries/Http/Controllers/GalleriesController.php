<?php

namespace Modules\Galleries\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\SiteService;
use Modules\Galleries\Services\GalleriesService;

class GalleriesController extends Controller
{
    public function index(SiteService $site, GalleriesService $galleriesService, $category = null)
    {
        $site
            ->setAlternates('galleries')
            ->setMenuActive('galleries')
            ->pushBreadCrumb(__('modules-galleries::strings.Galerias'), route_lang('galleries'))
            ->setBreadTitle(__('modules-galleries::strings.Galerias'))
            ->setTitle(__('modules-galleries::strings.Galerias'))
            ->setDescriptionIfNotEmpty($galleriesService->getPage()->description)
            ->setKeywordsIfNotEmpty($galleriesService->getPage()->keywords);

        if ($category) {
            $category = $galleriesService->getCategory($category);

            $site
                ->setAlternates('galleries',
                    fn($language) => ['category' => $category->translateOrDefault($language->locale)->slug]
                )
                ->pushBreadCrumb($category->title, route_lang('galleries', ['category' => $category->slug]))
                ->setBreadTitle($category->title)
                ->setTitle($category->title)
                ->setDescriptionIfNotEmpty($category->description)
                ->setKeywordsIfNotEmpty($category->keywords);
        }

        $galleries = $galleriesService->getGalleries(
            quantity: 12,
            category: $category,
        );

        // necessário para a paginação manter os parâmetros GET
        $galleries->appends(request()->input());

        $categories = $galleriesService->getCategories();

        return view('modules-galleries::galleries', [
            'galleries' => $galleries,
            'categories' => $categories,
            'current_category' => $category,
        ]);
    }

    public function details(SiteService $site, GalleriesService $galleriesService, string $slug)
    {
        $site
            ->pushBreadCrumb(__('modules-galleries::strings.Galerias'), route_lang('galleries'))
            ->setMenuActive('galleries')
            ->setDescriptionIfNotEmpty($galleriesService->getPage()->description)
            ->setKeywordsIfNotEmpty($galleriesService->getPage()->keywords);

        $gallery = $galleriesService->getGallery($slug);

        $site
            ->setAlternates('galleries.details', $gallery)
            ->setTitle($gallery->title)
            ->pushBreadCrumb($gallery->short_title ?: $gallery->title)
            ->setBreadTitle($gallery->short_title ?: $gallery->title)
            ->setDescriptionIfNotEmpty($gallery->description)
            ->setKeywordsIfNotEmpty($gallery->keywords)
            ->setMetasSocials($gallery, $gallery->image, 'article');

        return view('modules-galleries::galleries-details', [
            'gallery' => $gallery,
        ]);
    }
}
