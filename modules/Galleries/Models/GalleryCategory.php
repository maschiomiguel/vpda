<?php

namespace Modules\Galleries\Models;

use App\Modules\ModulesModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Orchid\Filters\Filterable;

class GalleryCategory extends ModulesModel implements TranslatableContract
{
    use Translatable, Filterable;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'galleries_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'active',
        'order',
    ];

    public $translatedAttributes = [
        'title',
        'slug',
        'description',
        'keywords',
    ];

    public function getLogName()
    {
        return $this->name;
    }
    
    public static function getEntityNameSingular()
    {
        return 'categoria de galeria';
    }

    public static function getEntityNamePlural()
    {
        return 'categorias de posts';
    }

    public static function getArticle()
    {
        return 'a';
    }
    
    public function galleries()
    {
        return $this->belongsToMany(Gallery::class, 'rel_galleries_categories', 'gallery_category_id', 'gallery_id');
    }
}
