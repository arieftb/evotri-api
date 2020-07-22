<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Events extends Model {
    protected $table = 'events';

    protected $hidden = [CREATED_AT_FIELD, MODIFIED_AT_FIELD];

    protected $guarded = [ID_FIELD];

    protected $appends = [RESPONSE_IS_ADMIN_FIELD, RESPONSE_IS_JOINED_FIELD];


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

    public function getIsAdminAttribute()
    {
        return $this->voter->first()->is_admin;
    }

    public function getIsJoinedAttribute()
    {
        if ($this->voter) {
            return 1;
        } else {
            return 0;
        }
    }
}
