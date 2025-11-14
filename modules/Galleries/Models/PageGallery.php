<?php

namespace Modules\Galleries\Models;

use App\Modules\ModulesModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class PageGallery extends ModulesModel implements TranslatableContract
{
    use Translatable;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'pages_galleries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        
    ];

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
        return $this->attachment('image_page_gallery');
    }

    public function getLogName()
    {
        return '';
    }
    
    public static function getEntityNameSingular()
    {
        return 'página de galeria';
    }

    public static function getEntityNamePlural()
    {
        return 'páginas de posts';
    }

    public static function getArticle()
    {
        return 'a';
    }
}
