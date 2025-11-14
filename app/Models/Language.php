<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Language extends Model
{
    use HasFactory, AsSource, Filterable;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'languages';

    public function localeProcessed()
    {
        return str_replace('-', '_', $this->locale);
    }
}
