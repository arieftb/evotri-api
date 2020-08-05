<?php

namespace App\Models;

use App\Models\Voters;
use Illuminate\Database\Eloquent\Model;

class Candidates extends Model
{
    protected $table = CANDIDATE_TABLE;

    protected $hidden = [CREATED_AT_FIELD, MODIFIED_AT_FIELD, VOTER_ID_FOREIGN_FIELD, CANDIDATE_ACTIVE_FIELD];

    protected $appends = [RESPONSE_IS_ACTIVE_FIELD];

    protected $guarded = [CANDIDATE_ID_FIELD, CREATED_AT_FIELD, MODIFIED_AT_FIELD];

    public static function candidateRules()
    {
        return [
            CANDIDATE_NUMBER_FIELD => 'required|numeric'
        ];
    }

    public static function candidateRequestRules()
    {
        return [
            VOTER_ID_FOREIGN_FIELD => 'required',
            CANDIDATE_ACTIVE_FIELD => 'required'
        ];
    }

    public function getIsActiveAttribute()
    {
        return (int) $this->active;
    }
    
    public function voters()
    {
        return $this->belongsTo(Voters::class, VOTER_ID_FOREIGN_FIELD);
    }
}
