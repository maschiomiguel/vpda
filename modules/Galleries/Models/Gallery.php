<?php

namespace Modules\Galleries\Models;

use App\Modules\ModulesModel;
use App\Orchid\Filters\LikeFilter;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Orchid\Filters\Filterable;

class Gallery extends ModulesModel implements TranslatableContract
{
    use Translatable, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'featured',
        'active',
        'order',
        'price',
        'width',
        'height',
        'length',
        'weight',
    ];

    public $translatedAttributes = [
        'title',
        'slug',
        'short_title',
        'description',
        'keywords',
        'text',
        'short_text',
        'video',
        'hits',
        'color',
        'gallery_id',
        'locale',
    ];
    
    public function image() {
        return $this->attachment('image_gallery');
    }

    public function getLogName()
    {
        return $this->name;
    }
    
    public static function getEntityNameSingular()
    {
        return 'galeria';
    }

    public static function getEntityNamePlural()
    {
        return 'posts';
    }

    public static function getArticle()
    {
        return 'a';
    }

    protected $sync = [
        'categories' => 'categories',
    ];

    /**
     * Name of columns to which http filter can be applied
     *
     * @var array
     */
    protected $allowedFilters = [
        'name' => LikeFilter::class,
        'code',
    ];

    public function categories()
    {
        return $this->belongsToMany(GalleryCategory::class, 'rel_galleries_categories', 'gallery_id', 'gallery_category_id');
    }
}
