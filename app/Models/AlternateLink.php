<?php

namespace App\Models;

class AlternateLink
{
    public function __construct(private Language $language, private string $url)
    {
        
    }

    public function getLanguage() : Language
    {
        return $this->language;
    }
    
    public function getUrl() : string
    {
        return $this->url;
    }
}
