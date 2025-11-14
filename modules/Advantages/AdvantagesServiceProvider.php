<?php

namespace Modules\Advantages;

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Advantages\Services\AdvantagesService;
use Illuminate\Support\Facades\Blade;

class AdvantagesServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        AdvantagesService::class => AdvantagesService::class,
    ];

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        
        Blade::componentNamespace('Modules\\Advantages\\View\\Components', 'modules-advantages');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'modules-advantages');

        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'modules-advantages');
    }
}
