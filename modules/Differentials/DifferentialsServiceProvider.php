<?php

namespace Modules\Differentials;

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Differentials\Services\DifferentialsService;
use Illuminate\Support\Facades\Blade;

class DifferentialsServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        DifferentialsService::class => DifferentialsService::class,
    ];

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        Blade::componentNamespace('Modules\\Differentials\\View\\Components', 'modules-differentials');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'modules-differentials');

        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'modules-differentials');
    }
}
