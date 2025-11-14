<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class PersonType extends Model
{
    use HasFactory, AsSource, Filterable;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'person_types';
}
