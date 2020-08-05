<?php

namespace App\Models;

use App\Users;
use Illuminate\Database\Eloquent\Model;

class Voters extends Model {
    protected $table = 'voters';

    protected $fillable = [USER_ID_FOREIGN_FIELD, EVENT_ID_FOREIGN_FIELD, VOTER_IS_ACTIVE_FIELD, VOTER_IS_ADMIN_FIELD];

    protected $hidden = [CREATED_AT_FIELD, MODIFIED_AT_FIELD, USER_TABLE, USER_ID_FOREIGN_FIELD, VOTER_IS_ACTIVE_FIELD, VOTER_IS_ADMIN_FIELD];

    protected $appends = [RESPONSE_IS_ADMIN_FIELD, RESPONSE_IS_ACTIVE_FIELD, RESPONSE_USER_FIELD];

    public function getVoterRules()
    {
        return [
            EVENT_ID_FOREIGN_FIELD => 'required',
            USER_ID_FOREIGN_FIELD => 'required',
            EVENT_CODE_FIELD => 'required',
        ];
    }

    public function events()
    {
        return $this->belongsTo(Events::class, EVENT_ID_FOREIGN_FIELD);
    }

    public function users()
    {
        return $this->belongsTo(Users::class, USER_ID_FOREIGN_FIELD);
    }

    public function candidates()
    {
        return $this->hasOne(Candidates::class, VOTER_ID_FOREIGN_FIELD);
    }

    public function getIsAdminAttribute()
    {
        return (int) $this->admin;
    }

    public function getIsActiveAttribute()
    {
        return (int) $this->active;
    }

    public function getUserAttribute()
    {
        $this->users->makeHidden(USER_CODE_FIELD);
        $this->users->makeHidden(USER_BIRTHDATE_FIELD);
        return $this->users;
    }
}