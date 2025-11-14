<?php

namespace Modules\Galleries;

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Galleries\Services\GalleriesService;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use Modules\Galleries\Http\Livewire as Components;

class GalleriesServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        GalleriesService::class => GalleriesService::class,
    ];

    /**
     * Bootstrap any package galleries.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        Blade::componentNamespace('Modules\\Galleries\\View\\Components', 'modules-galleries');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'modules-galleries');

        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/email'),
        ]);

        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'modules-galleries');
        Livewire::component('form-interest-gallery', Components\FormInterestGallery::class);

    }
}
