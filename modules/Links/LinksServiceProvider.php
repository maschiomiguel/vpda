<?php

namespace Modules\Links;

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Links\Services\LinksService;
use Illuminate\Support\Facades\Blade;

class LinksServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        LinksService::class => LinksService::class,
    ];

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        Blade::componentNamespace('Modules\\Links\\View\\Components', 'modules-links');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'modules-links');

        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'modules-links');
    }
}
