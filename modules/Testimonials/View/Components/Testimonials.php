<?php

namespace Modules\Testimonials\View\Components;

use Illuminate\View\Component;
use Modules\Testimonials\Services\TestimonialsService;

class Testimonials extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(private TestimonialsService $testimonials)
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
        return view('modules-testimonials::components.testimonials', [
            'testimonials' => $this->testimonials->getTestimonials(),
        ]);
    }
}
