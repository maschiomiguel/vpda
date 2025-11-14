<?php

namespace Modules\Links\Services;

use Modules\Links\Models\Link;

class LinksService
{
    public function getLinks(
        int $quantity = 10,
    )
    {
        $links = Link::where('active', 1)
            ->withTranslation()
            ->orderBy('order')
            ->paginate($quantity);
        
        return $links;
    }
}
