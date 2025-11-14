<?php

namespace Modules\Differentials\View\Components;

use Illuminate\View\Component;
use Modules\Differentials\Services\DifferentialsService;

class Differentials extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(private DifferentialsService $differentials)
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
        return view('modules-differentials::components.differentials', [
            'differentials' => $this->differentials->getDifferentials(),
            'differentialsSection' => $this->differentials->getDifferentialsSection(),
        ]);
    }
}
