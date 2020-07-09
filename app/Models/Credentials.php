<?php

namespace App\Models;

use App\Users;
use Illuminate\Database\Eloquent\Model;

class Credentials extends Model {
    protected $table = 'credentials';

    protected $visible = [CREDENTIAL_TOKEN_FIELD, USER_ID_FOREIGN_FIELD, USER_NAME_FIELD, RESPONSE_IS_SUPERADMIN_FIELD];

    protected $fillable = [USER_ID_FOREIGN_FIELD, CREDENTIAL_LOGIN_DATETIME_FILED, CREDENTIAL_TOKEN_FIELD];

    protected $appends = [RESPONSE_IS_SUPERADMIN_FIELD];

    public function user()
    {
        return $this->belongsTo('App\Users');
    }

    public function getIsSuperadminAttribute() {
        // return $this::find($this->attributes[USER_ID_FOREIGN_FIELD]) != null ? 1 : 0;
        return 0;
    }
}
