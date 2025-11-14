<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\LanguagesService;
use Illuminate\Support\Facades\App;

class Languages
{
    public function __construct(private LanguagesService $languages)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        // nome da rota
        // deve ter o prefixo do idioma
        // que é o código do idioma na tabela 'languages'
        $route_name = explode('.', $request->route()->getName());
        $code = $route_name[0];

        $language = $this->languages->getByCode($code)
            ?: $this->languages->getDefault();

        App::setLocale($language->locale);
        $this->languages->setCurrentLanguage($language);

        return $next($request);
    }
}
