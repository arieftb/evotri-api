<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventAdmins extends Model {
    protected $table = 'event_administrators';

    protected $guarded = [ID_FIELD];

    protected $fillable = [VOTER_ID_FOREIGN_FIELD, EVENT_ADMIN_IS_ACTIVE_FIELD];

    protected $hidden = [CREATED_AT_FIELD, MODIFIED_AT_FIELD];

    public function voter()
    {
        return $this->belongsTo(Voters::class, VOTER_ID_FOREIGN_FIELD);
    }
}