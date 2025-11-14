<?php 

namespace App\Models;

class MetaTag
{
    private $attributes = [];

    public function __construct()
    {

    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setName($name)
    {
        $this->attributes['name'] = $name;
        return $this;
    }
    
    public function setContent($content)
    {
        $this->attributes['content'] = $content;
        return $this;
    }
    
    public function setProperty($property)
    {
        $this->attributes['property'] = $property;
        return $this;
    }
}
