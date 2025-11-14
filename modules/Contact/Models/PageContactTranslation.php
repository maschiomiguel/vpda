<?php

namespace Modules\Contact\Models;

use App\Modules\ModulesModel;

class PageContactTranslation extends ModulesModel
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'pages_contact_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
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
        'adresses',
        'iframes_links',
        'phones',
        'emails',
        'whatsapps',
        'social_networks',
        'site_messages_destinies',
        'sitelink',
        'buttontext',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'adresses' => 'array',
        'iframes_links' => 'array',
        'phones' => 'array',
        'emails' => 'array',
        'whatsapps' => 'array',
        'social_networks' => 'array',
        'site_messages_destinies' => 'array',
    ];
}
