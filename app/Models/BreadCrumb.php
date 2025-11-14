<?php 

namespace App\Models;

class BreadCrumb
{
    public function __construct(private $text, private $url)
    {

    }

    public function getText()
    {
        return $this->text;
    }
    
    public function getUrl()
    {
        return $this->url;
    }
}
