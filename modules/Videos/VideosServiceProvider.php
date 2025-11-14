<?php

namespace Modules\Videos;

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Videos\Services\VideosService;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use Modules\Videos\Http\Livewire as Components;

class VideosServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        VideosService::class => VideosService::class,
    ];

    /**
     * Bootstrap any package videos.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        Blade::componentNamespace('Modules\\Videos\\View\\Components', 'modules-videos');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'modules-videos');

        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/email'),
        ]);

        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'modules-videos');
        Livewire::component('form-interest-video', Components\FormInterestVideo::class);

    }
}
