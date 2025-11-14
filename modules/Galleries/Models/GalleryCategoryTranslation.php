<?php

namespace Modules\Galleries\Models;

use App\Modules\ModulesModel;

class GalleryCategoryTranslation extends ModulesModel
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'galleries_categories_translations';

    public $hasSlug = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'title',
        'slug',
        'description',
        'keywords',
    ];
}
