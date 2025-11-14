<?php

namespace Modules\PageHome\Models;

use App\Modules\ModulesModel;

class PageHomeTranslation extends ModulesModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pages_home_translations';

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

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'values' => 'array',
        'count_up' => 'array',
    ];
}
