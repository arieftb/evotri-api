<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Candidates as ModelsCandidates;
use App\Models\Credentials;
use App\Models\Events;
use App\Models\Voters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CandidateController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(Request $request, $event_id)
    {
        $credential = Credentials::where(CREDENTIAL_TOKEN_FIELD, $request->header(HEADER_AUTH_KEY))->first();

        $userId = $credential != null ? $credential->user_id : null;
        $event = Events::allEventsFiltered($userId)->where(EVENT_ID_FIELD, $event_id)->isVisibleEvent()->first();

        if (!$event) return $this->response(null, 404);

        // TODO : IMPROVE THIS FILTERING NEXT UPDATE
        $candidates = ModelsCandidates::with(VOTER_TABLE)->get()
            ->filter(function ($item) use ($event) {
                return $item->voters->event_id == $event->id;
            })->sortBy(CANDIDATE_NUMBER_FIELD);

        if ($request->has(RESPONSE_IS_ACTIVE_FIELD)) {
            $candidates = $candidates->where(RESPONSE_IS_ACTIVE_FIELD, $request->input(RESPONSE_IS_ACTIVE_FIELD));
        }

        return $this->response($candidates, 200);
    }

    public function store(Request $request, $event_id)
    {
        $validationRequest = Validator::make($request->all(), ModelsCandidates::candidateRequestRules());
        if ($validationRequest->fails()) return $this->response(null, 400, MESSAGE_ERROR_CANDIDATE_FAILED_POST);

        $credential = Credentials::where(CREDENTIAL_TOKEN_FIELD, $request->header(HEADER_AUTH_KEY))->first();
        $userId = $credential != null ? $credential->user_id : null;

        $event = Events::allEventsFiltered($userId)->where(EVENT_ID_FIELD, $event_id)->isVisibleEvent()->first();
        if (!$event) return $this->response($event, 404, MESSAGE_ERROR_EVENT_NOT_FOUND);
        if ($event && $event->is_admin == 0) return $this->response(null, 401);


        $voter = Voters::where(VOTER_ID_FIELD, $request->input(VOTER_ID_FOREIGN_FIELD))->first();
        if (!$voter) return $this->response($voter, 404, MESSAGE_ERROR_VOTER_NOT_FOUND);

        $candidate = $voter->candidates;
        if ($voter && $candidate) return $this->response(null, 409);

        if ($request->input(CANDIDATE_NUMBER_FIELD)) {
            $request[CANDIDATE_NUMBER_FIELD] = $request->input(CANDIDATE_NUMBER_FIELD);
        } else {
            $number = ModelsCandidates::with(VOTER_TABLE)->get()
                ->filter(function ($item) use ($event) {
                    return $item->voters->event_id == $event->id;
                })->sortBy(CANDIDATE_NUMBER_FIELD)->last()->number;
            $request[CANDIDATE_NUMBER_FIELD] = $number ? $number + 1 : 1;
        }

        $validation = Validator::make($request->all(), ModelsCandidates::candidateRules());
        if ($validation->fails()) return $this->response(null, 400, MESSAGE_ERROR_CANDIDATE_FAILED_POST);

        try {
            $candidate = ModelsCandidates::create($request->all());
            if ($candidate) {
                return $this->response(null, 201);
            }
            return $this->response(null, 400);
        } catch (\Throwable $th) {
            return $this->responseError($th->getCode(), $th->getMessage());
        }
    }

    public function update(Request $request, $event_id, $id)
    {
        $credential = Credentials::where(CREDENTIAL_TOKEN_FIELD, $request->header(HEADER_AUTH_KEY))->first();
        $userId = $credential != null ? $credential->user_id : null;
        if (!$userId) return $this->response(null, 401);

        $voter = Voters::where(EVENT_ID_FOREIGN_FIELD, $event_id)->where(USER_ID_FOREIGN_FIELD, $userId)->first();
        if (!$voter) return $this->response($voter, 404, MESSAGE_ERROR_CANDIDATE_NOT_FOUND);

        if ($voter->is_admin == 1 || $voter->user->id == $userId) {
            try {
                ModelsCandidates::find($id)->update($request->all());
                return $this->response(null, 204);
            } catch (\Throwable $th) {
                return $this->responseError($th->getCode(), $th->getMessage());
            }
        } else return $this->response(null, 401);
    }
}
