<?php

namespace App\Services;

use App\Models\State;

class StatesService
{
    public function getStates()
    {
        $states = State::all();
        return $states;
    }
}
