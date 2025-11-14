<?php

namespace Modules\Banners\Models;

use App\Modules\ModulesModel;

class BannerTranslation extends ModulesModel
{    
    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'banners_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'text_1',
        'text_2',
        'text_3',
        'text_4',
        'link_1',
        'link_2',
        'link_3',
        'link_4',
        'text_link_1',
        'text_link_2',
        'text_link_3',
        'text_link_4',
    ];
}
