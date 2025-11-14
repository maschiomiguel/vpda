<?php

namespace Modules\Galleries\View\Components;

use Illuminate\View\Component;
use Modules\Galleries\Services\GalleriesService;

class Gallery extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        private GalleriesService $galleries
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
        return view('modules-galleries::components.gallery', [
            'galleries' => $this->galleries->getGalleries(),
        ]);
    }
}
