<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Events extends Model {
    protected $table = 'events';

    protected $hidden = [CREATED_AT_FIELD, MODIFIED_AT_FIELD, EVENT_IS_PUBLIC, VOTER_TABLE];

    protected $guarded = [ID_FIELD];

    protected $appends = [RESPONSE_IS_ADMIN_FIELD, RESPONSE_IS_JOINED_FIELD, RESPONSE_IS_PUBLIC_FIELD];


    public static function getEventPostRule() {
        return [
            EVENT_NAME_FIELD => 'required',
            EVENT_DATE_FIELD => 'required',
            EVENT_REGISTRATION_OPEN_FIELD => 'required',
            EVENT_REGISTRATION_CLOSE_FIELD => 'required'
        ];
    }


    public function voters()
    {
        return $this->hasMany(Voters::class, EVENT_ID_FOREIGN_FIELD);
    }

    public function getIsPublicEventAttribute()
    {
        return (int)$this->is_public;
    }

    public function getIsAdminAttribute()
    {
        return (int) $this->voters->first()->is_admin;
    }

    public function getIsJoinedAttribute()
    {
        if ($this->voters) {
            return 1;
        } else {
            return 0;
        }
    }

    public function setHide($hidden_list)
    {
        $this->setHidden($hidden_list);
    }
}
