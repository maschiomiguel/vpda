<?php

namespace Modules\Videos\Models;

use App\Modules\ModulesModel;

class VideoTranslation extends ModulesModel
{    
    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'videos_translations';
   
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
        'video_id',
        'locale',
    ];
}
