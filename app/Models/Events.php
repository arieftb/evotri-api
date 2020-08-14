<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $table = 'events';

    protected $hidden = [CREATED_AT_FIELD, MODIFIED_AT_FIELD, EVENT_IS_PUBLIC, EVENT_IS_ACTIVE_FIELD, USER_ID_FOREIGN_FIELD];

    protected $guarded = [ID_FIELD, USER_ID_FOREIGN_FIELD];

    protected $appends = [RESPONSE_IS_PUBLIC_FIELD, RESPONSE_IS_ACTIVE_FIELD, USER_ID_FOREIGN_FIELD];

    protected $fillable = [EVENT_NAME_FIELD, EVENT_DATE_FIELD, EVENT_IS_PUBLIC, EVENT_REGISTRATION_OPEN_FIELD, EVENT_REGISTRATION_CLOSE_FIELD, EVENT_CODE_FIELD, EVENT_IS_ACTIVE_FIELD,
        EVENT_ELECTION_END_DATE_FIELD, EVENT_ELECTION_START_DATE_FIELD, EVENT_PUBLISH_DATE_FIELD,
    ];

    public static function getEventPostRule()
    {
        return [
            EVENT_NAME_FIELD => 'required',
            EVENT_DATE_FIELD => 'required',
            EVENT_REGISTRATION_OPEN_FIELD => 'required',
            EVENT_REGISTRATION_CLOSE_FIELD => 'required',
        ];
    }

    public function voters()
    {
        return $this->hasMany(Voters::class, EVENT_ID_FOREIGN_FIELD);
    }

    public function getIsPublicAttribute()
    {
        return (int) $this->public;
    }

    public function getUserIdAttribute()
    {
        return 33;
    }

    public function getIsActiveAttribute()
    {
        return (int) $this->active;
    }

    public static function allEventsFiltered($userId)
    {
        $events = Events::all();
        $collection = $events->map(function ($item) use ($userId) {
            $eventId = $item->id;

            $isJoin = $item[VOTER_TABLE]->map(function ($item) use ($userId, $eventId) {
                return $item->user_id == $userId && $item->event_id == $eventId;
            });

            $isAdmin = $item[VOTER_TABLE]->map(function ($item) use ($userId, $eventId) {
                return $item->user_id == $userId && $item->admin == '1' && $item->event_id == $eventId;
            });

            $item[RESPONSE_IS_ADMIN_FIELD] = $isAdmin->first() ? 1 : 0;
            $item[RESPONSE_IS_JOINED_FIELD] = $isJoin->first() ? 1 : 0;

            unset($item->voters);

            return $item;
        });

        return $collection;
    }

    public function scopeFilterIsAdminIsPublicIsJoined($query)
    {
        return $query->get()->filter(function ($event) {
            return $event->is_admin == 1 || $event->is_joined == 1 || $event->is_public == 1;
        });

    }
}
