<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $hidden = [MODIFIED_AT_FIELD, CREATED_AT_FIELD];
}
