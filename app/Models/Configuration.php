<?php

namespace App\Models;

use App\Modules\ModulesModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Configuration extends ModulesModel implements TranslatableContract
{
    use Translatable;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'configurations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email_authenticated',
        'email_dsn',
        'email_from',
        'primary_color',
        'hover_color',
        'whatsapp_button_color',
    ];

    public $translatedAttributes = [
        'description',
        'keywords',
        'custom_js_head',
        'custom_js_body',
    ];
    
    public function imageLogo ()
    {
        return $this->attachment('image_logo');
    }

    public function imageLogoFooter ()
    {
        return $this->attachment('image_logo_footer');
    }

    public function getLogName()
    {
        return '';
    }
    
    public static function getEntityNameSingular()
    {
        return 'configuração';
    }

    public static function getEntityNamePlural()
    {
        return 'configurações';
    }

    public static function getArticle()
    {
        return 'a';
    }
}
