<?php

namespace Modules\PageHome\Services;

use Modules\PageHome\Models\PageHome;

class PageHomeService
{
    private $page;
    
    public function __construct()
    {
        $this->page = PageHome::withTranslation()->firstOrCreate();
    }

    public function getPage()
    {
        return $this->page;
    }
}
