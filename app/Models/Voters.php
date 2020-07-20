<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voters extends Model {
    protected $table = 'voters';

    protected $guarded = [];

    protected $fillable = [USER_ID_FOREIGN_FIELD, EVENT_ID_FOREIGN_FIELD, VOTER_IS_ACTIVE_FIELD];

    protected $hidden = [CREATED_AT_FIELD, MODIFIED_AT_FIELD];

    public function event()
    {
        return $this->belongsTo(Events::class, EVENT_ID_FOREIGN_FIELD);
    }

    public function admin()
    {
        return $this->hasOne(EventAdmins::class, VOTER_ID_FOREIGN_FIELD);
    }
}