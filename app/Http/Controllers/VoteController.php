<?php

namespace App\Http\Controllers;

use App\Models\Candidates;
use App\Models\Credentials;
use App\Models\Voters;
use App\Models\Votes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoteController extends BaseController
{
    public function store(Request $request, $event_id, $id)
    {
        $credential = Credentials::where(CREDENTIAL_TOKEN_FIELD, $request->header(HEADER_AUTH_KEY))->first();
        $userId = $credential != null ? $credential->user_id : null;

        $voter = Voters::where(EVENT_ID_FOREIGN_FIELD, $event_id)->where(USER_ID_FOREIGN_FIELD, $userId)->first();
        $event = $voter->events;
        if ($event->id != $event_id) return $this->response(null, 401);
        if (!$voter) return $this->response($voter, 404);
        if ($voter->is_active != 1) return $this->response(null, 401);
        if ($voter->votes) return $this->response(null, 409);

        $candidate = Candidates::find($id);
        if (!$candidate) return $this->response($candidate, 404);

        $request[CANDIDATE_ID_FOREIGN_FIELD] = $candidate->id;
        $request[VOTER_ID_FOREIGN_FIELD] = $voter->id;

        $validationRequest = Validator::make($request->all(), Votes::voteRule());
        if ($validationRequest->fails()) return $this->response(null, 400, MESSAGE_ERROR_CANDIDATE_FAILED_POST);

        try {
            $vote = Votes::create($request->all());
            if ($vote) {
                return $this->response(null, 201);
            }        
            return $this->response(null, 400);
        } catch (\Throwable $th) {
            return $this->responseError($th->getCode(), $th->getMessage());
        }
    }
}
