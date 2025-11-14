<?php

namespace Modules\Advantages\Models;

use App\Modules\ModulesModel;

class AdvantageTranslation extends ModulesModel
{    
    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'advantages_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'title_1',
        'title_2',
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
