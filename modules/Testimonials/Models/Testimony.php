<?php

namespace Modules\Testimonials\Models;

use App\Modules\ModulesModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Testimony extends ModulesModel implements TranslatableContract
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'testimonials';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'active',
        'order',
        'note',
    ];

    public $translatedAttributes = [
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
        return $this->attachment('image_testimony');
    }

    public function getLogName()
    {
        return $this->name;
    }
    
    public static function getEntityNameSingular()
    {
        return 'depoimento';
    }

    public static function getEntityNamePlural()
    {
        return 'depoimentos';
    }

    public static function getArticle()
    {
        return 'o';
    }
}
