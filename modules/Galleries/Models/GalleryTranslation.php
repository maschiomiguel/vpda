<?php

namespace Modules\Galleries\Models;

use App\Modules\ModulesModel;

class GalleryTranslation extends ModulesModel
{    
    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'galleries_translations';
   
   public $hasSlug = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
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
}
