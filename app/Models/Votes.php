<?php

namespace App\Models;

use App\Models\BaseModel;

class Votes extends BaseModel
{
    protected $table = VOTE_TABLE;

    protected $guarded = [VOTE_ID_FIELD];

    public static function voteRule()
    {
        return [
            VOTER_ID_FOREIGN_FIELD => 'required|numeric',
            CANDIDATE_ID_FOREIGN_FIELD => 'required|numeric'
        ];
    }

    public function voters()
    {
        return $this->belongsTo(Voters::class, VOTER_ID_FOREIGN_FIELD);
    }

    public function candidates()
    {
        return $this->belongsTo(Candidates::class, CANDIDATE_ID_FOREIGN_FIELD);
    }
}
