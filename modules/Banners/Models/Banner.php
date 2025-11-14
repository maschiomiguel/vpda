<?php

namespace Modules\Banners\Models;

use App\Modules\ModulesModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Banner extends ModulesModel implements TranslatableContract
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
        'words',
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

    public function bannerDesktop($locale = 'pt-BR')
    {
        return $this->attachment("desktop_banner_$locale");
    }
    public function bannerMobile($locale = 'pt-BR')
    {
        return $this->attachment("mobile_banner_$locale");
    }

    public function getLogName()
    {
        return $this->name;
    }

    public static function getEntityNameSingular()
    {
        return 'banner';
    }

    public static function getEntityNamePlural()
    {
        return 'banners';
    }

    public static function getArticle()
    {
        return 'o';
    }

    public function getImagemDesktop()
    {
        $language = languages()->getCurrentLanguage();

        $img_language = $this->bannerDesktop($language->locale)->first();

        if ($img_language) {
            return $img_language;
        }

        return $this->bannerDesktop->first();
    }

    public function getImagemMobile()
    {
        $language = languages()->getCurrentLanguage();

        $img_language = $this->bannerMobile($language->locale)->first();

        if ($img_language) {
            return $img_language;
        }

        $img_fallback = $this->bannerMobile->first();

        if ($img_fallback) {
            return $img_fallback;
        }

        return $this->getImagemDesktop();
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'words' => 'array',
    ];
}
