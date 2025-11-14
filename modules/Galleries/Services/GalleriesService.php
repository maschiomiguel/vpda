<?php

namespace Modules\Galleries\Services;

use Modules\Galleries\Models\Gallery;
use Modules\Galleries\Models\GalleryCategory;
use Illuminate\Database\Eloquent\Builder;
use Modules\Galleries\Models\PageGallery;
use Illuminate\Support\Facades\DB;

class GalleriesService
{
    private $page;

    public function __construct()
    {
        $this->page = PageGallery::withTranslation()->firstOrCreate();
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getGalleries() {
        /** @var Builder */
        $galleries = Gallery::where('active', 1)
            ->withTranslation()
            ->orderBy('order');
            
        return $galleries;
    }

    public function getGallery(string $slug)
    {
        $gallery = Gallery::where('active', 1)
            ->whereTranslation('slug', $slug)
            ->withTranslation()
            ->with([
                'categories'
            ]);

        return $gallery->firstOrFail();
    }

    public function getFeaturedGalleries()
    {
        $galleries = Gallery::where('active', 1)
            ->withTranslation()
            ->with([
                'categories'
            ])
            ->where('featured', 1);

        return $galleries->get();
    }

    public function getRelatedGalleries($categories, Gallery $gallery)
    {
        $gallery = Gallery::where('active', 1)
            ->withTranslation()
            ->with([
                'categories',
            ])
            ->where('galleries.id', '!=', $gallery->id)
            ->whereRelation('categories', 'id', $categories->modelKeys());

        return $gallery->get();
    }

    public function getCategories()
    {
        $categories = GalleryCategory::withTranslation()
            ->where('active', 1)
            ->whereRelation('galleries', 'active', 1)
            ->orderBy('order');
        
        return $categories;
    }

    public function getCategory($slug){
        
        $category = GalleryCategory::withTranslation()
            ->whereTranslation('slug', $slug)
            ->where('active', 1);
        
        return $category->firstOrFail();
    }

    public function hasGalleries(){
        
        $count = Gallery::where('active', 1)->count();
        
        return $count;
    }

}
