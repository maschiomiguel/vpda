<?php

namespace App\Models;

use Modules\Representatives\Models\Representative;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public function representatives()
    {
        return $this->belongsToMany(Representative::class, 'rel_representatives_states', 'state_id', 'representative_id');
    }
}
