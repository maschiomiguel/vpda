<?php

namespace Modules\Differentials\Models;

use App\Modules\ModulesModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Differential extends ModulesModel implements TranslatableContract
{
    use Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'active',
        'order',
        'active_section',
    ];

    public $translatedAttributes = [
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
    
    public function image() {
        return $this->attachment('image_differential');
    }

    public function getLogName()
    {
        return $this->name;
    }
    
    public static function getEntityNameSingular()
    {
        return 'diferencial';
    }

    public static function getEntityNamePlural()
    {
        return 'diferenciais';
    }

    public static function getArticle()
    {
        return 'o';
    }

}
