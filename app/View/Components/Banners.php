<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\Banners\Services\BannersService;

class Banners extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        private BannersService $banners
    )
    {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.banners', [
            'banners' => $this->banners->getBanners(),
        ]);
    }
}
