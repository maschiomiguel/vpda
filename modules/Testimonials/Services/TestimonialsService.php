<?php

namespace Modules\Testimonials\Services;

use Modules\Testimonials\Models\Testimony;

class TestimonialsService
{
    public function getTestimonials(
        int $quantity = 10,
    )
    {
        $testimonials = Testimony::where('active', 1)
            ->withTranslation()
            ->orderBy('order')
            ->paginate($quantity);
        
        return $testimonials;
    }
}
