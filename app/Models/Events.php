<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Events extends Model {
    protected $table = 'events';

    protected $hidded = [CREATED_AT_FIELD, MODIFIED_AT_FIELD];

    protected $guarded = [];


    public static function getEventPostRule() {
        return [
            EVENT_NAME_FIELD => 'required',
            EVENT_DATE_FIELD => 'required',
            EVENT_REGISTRATION_OPEN_FIELD => 'required',
            EVENT_REGISTRATION_CLOSE_FIELD => 'required'
        ];
    }


    public function voter()
    {
        return $this->hasMany(Voters::class, EVENT_ID_FOREIGN_FIELD);
    }
}
