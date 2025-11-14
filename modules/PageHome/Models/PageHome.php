<?php

namespace Modules\PageHome\Models;

use App\Modules\ModulesModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class PageHome extends ModulesModel implements TranslatableContract
{
    use Translatable;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'pages_home';

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
        'text_5',
        'text_6',
        'text_7',
        'text_8',
        'text_9',
        'text_10',
        'title',
        'title_1',
        'title_2',
        'title_3',
        'title_4',
        'title_5',
        'title_6',
        'title_7',
        'title_8',
        'title_9',
        'title_10',
        'call_text',
        'call_text_1',
        'call_text_2',
        'call_text_3',
        'call_text_4',
        'call_text_5',
        'call_text_6',
        'call_link',
        'call_link_1',
        'call_link_2',
        'call_link_3',
        'call_link_4',
        'call_link_5',
        'call_link_6',
        'call_text_link',
        'call_text_link_1',
        'call_text_link_2',
        'call_text_link_3',
        'call_text_link_4',
        'call_text_link_5',
        'call_text_link_6',
        'values',
        'count_up',
    ];
    
    public function images() 
    {
        return $this->attachment('image_page_home');
    }

    public function videoThumb() 
    {
        return $this->attachment('home_video_thumb');
    }

    public function videoFirstSection() 
    {
        return $this->attachment('video_first_section');
    }

    public function bgFirstSection()
    {
        return $this->attachment('bg_first_section');
    }

    public function imageFirstSection()
    {
        return $this->attachment('image_first_section');
    }

    public function galleryFirstSection()
    {
        return $this->attachment('gallery_first_section');
    }

    public function bgFormSection() 
    {
        return $this->attachment('bg_form_section');
    }

    public function imageCtaAppSection()
    {
        return $this->attachment('image_cta_app_section');
    }

    public function imageDifferential()
    {
        return $this->attachment('image_differential');
    }

    public function getLogName()
    {
        return '';
    }
    
    public static function getEntityNameSingular()
    {
        return 'página home';
    }

    public static function getEntityNamePlural()
    {
        return 'páginas home';
    }

    public static function getArticle()
    {
        return 'a';
    }
}
