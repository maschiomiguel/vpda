<?php

namespace App\Services;

use App\Models\Language;
use App\Models\AlternateLink;
use Illuminate\Support\Collection;

class AlternatesService
{
    private Collection $alternates;

    public function __construct(private LanguagesService $languages)
    {
        $this->alternates = collect();
    }

    /**
     * Seta os links de meta tags alternate para o site
     * 
     * @param string $route_name Nome da rota para gerar alternates
     */
    public function setAlternates(string $route_name)
    {
        foreach ($this->languages->siteLanguages() as $language) {
            
            $url = route_for_lang($route_name, $language);

            $alternate = new AlternateLink(
                language: $language,
                url: $url,
            );

            $this->alternates = $this->alternates->put($language->id, $alternate);
        }
    }

    /**
     * Retorna os links alternate do site
     * 
     * @param bool $include_current Se deve retornar a rota para o idioma atual também
     */
    public function getAlternates(bool $include_current = true)
    {
        return $this->alternates->filter(
            fn($a) => $include_current 
                ? true
                : $a->getLanguage()->code !== $this->languages->getCurrentLanguage()->code
        );
    }
}
