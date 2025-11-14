<?php

namespace Modules\Advantages\View\Components;

use Illuminate\View\Component;
use Modules\Advantages\Services\AdvantagesService;

class Advantages extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        private AdvantagesService $advantages
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
        return view('modules-advantages::components.advantages', [
            'advantages' => $this->advantages->getAdvantages(),
        ]);
    }
}
