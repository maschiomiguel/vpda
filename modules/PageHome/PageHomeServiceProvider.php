<?php

namespace Modules\PageHome;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\PageHome\Services\PageHomeService;

class PageHomeServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        PageHomeService::class => PageHomeService::class,
    ];

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }
}
