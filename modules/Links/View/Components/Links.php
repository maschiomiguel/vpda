<?php

namespace Modules\Links\View\Components;

use Illuminate\View\Component;
use Modules\Links\Services\LinksService;

class Links extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(private LinksService $links)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('modules-links::components.links', [
            'links' => $this->links->getLinks(),
        ]);
    }
}
