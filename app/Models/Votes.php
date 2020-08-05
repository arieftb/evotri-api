<?php

namespace App\Models;

use App\Models\BaseModel;

class Votes extends BaseModel
{
    protected $table = VOTE_TABLE;

    protected $guarded = [VOTE_ID_FIELD];

    public function voters()
    {
        return $this->belongsTo(Voters::class, VOTER_ID_FOREIGN_FIELD);
    }

    public function candidates()
    {
        return $this->belongsTo(Candidates::class, CANDIDATE_ID_FOREIGN_FIELD);
    }
}
