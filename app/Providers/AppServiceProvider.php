<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Services;
use Illuminate\Foundation\AliasLoader;

class AppServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        Services\LogsService::class => Services\LogsService::class,
        Services\LanguagesService::class => Services\LanguagesService::class,
        Services\ScreensService::class => Services\ScreensService::class,
        Services\AlternatesService::class => Services\AlternatesService::class,
        Services\SiteService::class => Services\SiteService::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(190);

        $is_https = strpos(env('APP_URL'), 'https://') === 0;

        if ($is_https) {
            if (!request()->secure() && $this->app->environment('production')) {
                return redirect()->secure(request()->getRequestUri());
            }

            URL::forceScheme('https');
        }

        // usado para sobre-escrever a lógica de login do Orchid
        $this->app->bind(
            \Orchid\Platform\Http\Controllers\LoginController::class,
            \App\Http\Controllers\Restrita\LoginController::class
        );

        // usado para sobre-escrever a lógica de upload do Orchid
        $this->app->bind(
            \Orchid\Platform\Http\Controllers\AttachmentController::class,
            \App\Http\Controllers\Restrita\AttachmentController::class,
        );

        /*
        * Utilizado para sobrescrever a classe Cell do Orchid;
        * Motivo: Necessário passar a classe checkbox em um head da tabela, porém só aceitava string.
        */
        AliasLoader::getInstance()->alias(\Orchid\Screen\Cell::class, \App\Orchid\src\Screen\Cell::class,);

        /*
        * Utilizado para sobrescrever a classe Table do Orchid;
        * Motivo: O último return da função subNotFound() não estava sendo utilizado com multilingue;
        */
        AliasLoader::getInstance()->alias(\Orchid\Screen\Layouts\Table::class, \App\Orchid\src\Layouts\Table::class,);

        /*
        * Sobrescreve classe Menu
        * Adiciona método Tutorial
        */
        AliasLoader::getInstance()->alias(\Orchid\Screen\Actions\Menu::class, \App\Orchid\src\Screen\Actions\Menu::class,);

        /*
        * Sobrescreve classe Matrix
        */
        AliasLoader::getInstance()->alias(\Orchid\Screen\Fields\Matrix::class, \App\Orchid\Fields\Matrix::class,);

        /*
        * Sobrescreve classe Upload
        * Correção no Upload Controller
        */
        AliasLoader::getInstance()->alias(\Orchid\Screen\Fields\Upload::class, \App\Orchid\Fields\Upload::class,);
    }
}
