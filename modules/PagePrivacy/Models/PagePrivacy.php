<?php

namespace Modules\PagePrivacy\Models;

use App\Modules\ModulesModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class PagePrivacy extends ModulesModel implements TranslatableContract
{
    use Translatable;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'pages_privacies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public $translatedAttributes = [
        'description',
        'keywords',
        'text',
        'text_1',
        'text_2',
        'text_3',
        'text_4',
        'video',
        'video_1',
        'video_2',
        'video_3',
        'video_4',
    ];
    
    public function images() {
        return $this->attachment('image_page_privacy');
    }

    public function getLogName()
    {
        return '';
    }
    
    public static function getEntityNameSingular()
    {
        return 'política de privacidade';
    }

    public static function getEntityNamePlural()
    {
        return 'políticas de privacidade';
    }

    public static function getArticle()
    {
        return 'a';
    }
}
