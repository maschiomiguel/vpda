<?php

namespace Modules\PagePrivacy;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\PagePrivacy\Services\PagePrivacyService;

class PagePrivacyServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        PagePrivacyService::class => PagePrivacyService::class,
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
