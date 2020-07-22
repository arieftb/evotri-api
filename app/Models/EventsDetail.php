<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventsDetail extends Events {
    public function __construct()
    {
        $this->makeVisible([VOTER_TABLE]);
    }
}
