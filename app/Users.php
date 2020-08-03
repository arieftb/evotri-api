<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Users extends Model {
    protected $table = 'users';

    protected $hidden = [USER_PASSWORD_FIELD, 'created_at', 'updated_at'];

    protected $fillable = [USER_CODE_FIELD, USER_NAME_FIELD, USER_EMAIL_FIELD, USER_IMAGE_FIELD, USER_PHONE_FIELD, USER_PASSWORD_FIELD, USER_BIRTHDATE_FIELD];


    public function voters()
    {
        return $this->hasMany(Voters::class, USER_ID_FOREIGN_FIELD);
    }
}
