<?php

namespace Modules\Differentials\Services;

use Modules\Differentials\Models\Differential;

class DifferentialsService
{
    public function getDifferentials(
        int $quantity = 10,
    )
    {
        $differentials = Differential::where('active', 1)
            ->withTranslation()
            ->orderBy('order')
            ->paginate($quantity);
        
        return $differentials;
    }

    public function getDifferentialsSection(
        int $quantity = 10,
    )
    {
        $differentials = Differential::where('active_section', 1)
            ->orderBy('order')
            ->paginate($quantity);
        
        return $differentials;
    }
}
