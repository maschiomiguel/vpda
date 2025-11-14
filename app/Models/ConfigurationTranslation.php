<?php

namespace App\Models;

use App\Modules\ModulesModel;

class ConfigurationTranslation extends ModulesModel
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'configurations_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'description',
        'keywords',
        'custom_js_head',
        'custom_js_body',
    ];
}
