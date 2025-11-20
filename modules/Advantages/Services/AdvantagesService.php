<?php

namespace Modules\Advantages\Services;

use Modules\Advantages\Models\Advantage;

class AdvantagesService
{
    public function getAdvantages(
        int $quantity = 10,
    )
    {
        $advantages = Advantage::where('active', 1)
            ->withTranslation()
            ->orderBy('order')
            ->paginate($quantity);
        
        // $advantages = $advantages->filter(
        //     fn($b) => $b->image->count() > 0,
        // );
        
        return $advantages;
    }
}
