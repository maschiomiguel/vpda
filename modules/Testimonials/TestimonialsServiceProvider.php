<?php

namespace Modules\Testimonials;

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Testimonials\Services\TestimonialsService;
use Illuminate\Support\Facades\Blade;

class TestimonialsServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        TestimonialsService::class => TestimonialsService::class,
    ];

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        Blade::componentNamespace('Modules\\Testimonials\\View\\Components', 'modules-testimonials');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'modules-testimonials');

        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'modules-testimonials');
    }
}
