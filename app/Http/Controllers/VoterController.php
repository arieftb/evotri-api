<?php

namespace App\Http\Controllers;

use App\Models\Credentials;
use App\Models\Events;
use App\Models\Voters;
use Illuminate\Http\Request;

class VoterController extends BaseController
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

    //


    // TODO : Change Function Name
    public function storeByEvent(Request $request, $event_id)
    {
        $user_id = Credentials::where(CREDENTIAL_TOKEN_FIELD, $request->header(HEADER_AUTH_KEY))->firstOrFail()->user_id;
        $event = Events::where(ID_FIELD, $event_id)->where(EVENT_CODE_FIELD, $request->input(EVENT_CODE_FIELD))->firstOrFail();
        $voter = $event->voters->where(USER_ID_FOREIGN_FIELD, $user_id)->first();

        if ($voter) {
            return $this->response(null, 409);
        }

        if ($user_id && $event) {
            $request[USER_ID_FOREIGN_FIELD]  = $user_id;
            $request[EVENT_ID_FOREIGN_FIELD] = $event->id;

            try {
                $voter = Voters::create($request->all());

                if ($voter) {
                    return $this->response(null, 201);
                } else {
                    return $this->response(null, 400);
                }
            } catch (\Throwable $th) {
                return $this->responseError($th->getCode(), $th->getMessage());
            }
        } else {
            return $this->response(null, 400);
        }
    }

    // TODO : GET VOTERS BY EVENT
    public function index(Request $request, $event_id)
    {
        $credential = Credentials::where(CREDENTIAL_TOKEN_FIELD, $request->header(HEADER_AUTH_KEY))->first();

        $userId = $credential != null ? $credential->user_id : null;
        $events = Events::allEventsFiltered($userId)->where(EVENT_ID_FIELD, $event_id)->isVisibleEvent()->first();

        if (!$events) {
            return $this->response($events, 404);
        }

        $event = $events->first();
        $is_admin = $event->is_admin == 1;
        $is_public = $event->is_public == 1;
        $is_joined = $event->is_joined == 1;

        if ($is_admin || $is_joined || $is_public) {
            $voters = Voters::where(EVENT_ID_FOREIGN_FIELD, $event_id)->get();

            if ($request->has(RESPONSE_IS_ACTIVE_FIELD)) {
                $is_active = $request->input(RESPONSE_IS_ACTIVE_FIELD);
                $voters = $voters->where(RESPONSE_IS_ACTIVE_FIELD, $is_active);
            }

            if ($request->has(RESPONSE_IS_ADMIN_FIELD)) {
                $is_admin = $request->input(RESPONSE_IS_ADMIN_FIELD);
                $voters = $voters->where(RESPONSE_IS_ADMIN_FIELD, $is_admin);
            }

            return $this->response($voters, 200);
        } else {
            return $this->response(null, 400);
        }
    }

    public function update(Request $request, $event_id, $id) {
        $credential = Credentials::where(CREDENTIAL_TOKEN_FIELD, $request->header(HEADER_AUTH_KEY))->first();

        $userId = $credential != null ? $credential->user_id : null;
        $event = Events::allEventsFiltered($userId)->where(EVENT_ID_FIELD, $event_id)->isVisibleEvent()->first();

        if (!$event) {
            return $this->response($event, 404);
        }

        $is_admin = $event->is_admin == 1;

        if ($is_admin) {
            try {
                Voters::findOrFail($id)->update($request->all());
                return $this->response(null, 204);
            } catch (\Throwable $th) {
                return $this->responseError($th->getCode(), $th->getMessage());
            }
        } else return $this->response(null, 401);
    }
}
