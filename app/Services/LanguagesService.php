<?php

namespace App\Services;

use App\Models\Language;
use Illuminate\Support\Collection;

class LanguagesService
{
    private Collection $languages;
    private Collection $shown_languages;

    private ?Language $currentLanguage;

    public function __construct()
    {
        $this->loadVariables();
        $this->setCurrentLanguage($this->getDefault());
    }

    private function loadVariables()
    {
        static $has_loaded = false;

        if (!$has_loaded) {
            $this->languages = Language::where('active', 1)->get();
            $this->shown_languages = Language::where('active', 1)->where('show', 1)->get();

            $has_loaded = true;
        }
    }

    public function languages() : Collection
    {
        return $this->languages;
    }

    public function siteLanguages() : Collection
    {
        return $this->shown_languages;
    }

    public function getByCode(string $code) : ?Language
    {
        $code = strtolower($code);

        return $this->languages->first(
            fn($l) => strtolower($l->code) === $code
        );
    }

    public function getDefault() : Language
    {
        return $this->languages->first(
            fn($l) => $l->main
        );
    }

    public function setCurrentLanguage(Language $language)
    {
        $this->currentLanguage = $language;
    }

    public function getCurrentLanguage() : Language
    {
        return $this->currentLanguage;
    }

    public function otherLanguages()
    {
        static $others = NULL;
        
        if ($others === NULL) {
            $others = $this->languages->count() > 1;
        }

        return $others;
    }
}
