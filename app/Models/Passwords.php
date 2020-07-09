<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Passwords extends Model {
    protected $table = 'users';

    protected $visible  = [USER_PASSWORD_FIELD, USER_ID_FIELD];
}
