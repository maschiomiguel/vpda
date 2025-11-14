<?php

namespace Modules\Videos\Models;

use App\Modules\ModulesModel;
use App\Orchid\Filters\LikeFilter;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Orchid\Filters\Filterable;

class Video extends ModulesModel implements TranslatableContract
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
        'video_id',
        'locale',
    ];
    
    public function image() {
        return $this->attachment('image_video');
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
        return 'videos';
    }

    public static function getArticle()
    {
        return 'a';
    }

    /**
     * Name of columns to which http filter can be applied
     *
     * @var array
     */
    protected $allowedFilters = [
        'name' => LikeFilter::class,
        'code',
    ];
}
