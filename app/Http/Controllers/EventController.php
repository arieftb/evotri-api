<?php

namespace App\Http\Controllers;

use App\Helpers\EncryptHelper;
use App\Http\Controllers\BaseController;
use App\Models\Credentials;
use App\Models\Events;
use App\Models\EventsDetail;
use App\Models\Voters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends BaseController
{
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), Events::getEventPostRule());

        if ($validation->fails()) {
            return $this->response(null, 400, MESSAGE_ERROR_EVENT_FAILED_POST);
        }

        try {
            $credential = Credentials::where(CREDENTIAL_TOKEN_FIELD, $request->header(HEADER_AUTH_KEY))->first();

            $user_id = $credential->user->id;

            $request[EVENT_CODE_FIELD] = EncryptHelper::encryptPasword($request[EVENT_NAME_FIELD] . $request->Input(EVENT_DATE_FIELD));
            $event = Events::create($request->all());

            $voter = new Voters();
            $voter[USER_ID_FOREIGN_FIELD] = $user_id;
            $voter[EVENT_ID_FOREIGN_FIELD] = $event->id;
            $voter[VOTER_IS_ACTIVE_FIELD] = '1';
            $voter[VOTER_IS_ADMIN_FIELD] = '1';

            $voterPost = $event->voters()->save($voter);

            if ($voterPost) {
                return $this->response(null, 201);
            } else {
                return $this->response(null, 400);
            }
        } catch (\Throwable $th) {
            return $this->responseError($th->getCode(), $th->getMessage());
        }
    }

    // TODO : Not Finish Yet
    public function index(Request $request)
    {
        if ($request->has(HEADER_AUTH_KEY)) {
            $credential = Credentials::where(CREDENTIAL_TOKEN_FIELD, $request->header(HEADER_AUTH_KEY))->first();
            $user_id = $credential->user_id;
            $request[USER_ID_FOREIGN_FIELD] = $user_id;
            $events = Events::allEventsFiltered($user_id);
        } else {
            $events =  $this->indexPublic();
        }

        if ($request->has(RESPONSE_IS_PUBLIC_FIELD)) {
            $is_public = $request->input(EVENT_IS_PUBLIC);
            $events = $events->where(EVENT_IS_PUBLIC, $is_public);
        }

        if ($request->has(RESPONSE_IS_JOINED_FIELD)) {
            $is_joined = $request->input(RESPONSE_IS_JOINED_FIELD);
            $events = $events->where(RESPONSE_IS_JOINED_FIELD, $is_joined);
        }

        if ($request->has(RESPONSE_IS_ADMIN_FIELD)) {
            $is_admin = $request->input(RESPONSE_IS_ADMIN_FIELD);
            $events = $events->where(VOTER_IS_ADMIN_FIELD, $is_admin);
        }

        return $this->response($events, 200);
    }

    public function indexPublic()
    {
        $events = Events::where(EVENT_IS_PUBLIC, (string) 1)->get();
        return $events;
    }

    public function update(Request $request, $id)
    {
        $credential = Credentials::where(CREDENTIAL_TOKEN_FIELD, $request->header(HEADER_AUTH_KEY))->first();

        if ($credential) {
            $user_id = $credential->user_id;
        } else return $this->response(null, 401);

        $is_admin = Voters::where(USER_ID_FOREIGN_FIELD, $user_id)->where(EVENT_ID_FOREIGN_FIELD, $id)->first()->is_admin;

        if ($is_admin != 1) return $this->response(null, 401);

        try {
            Events::findOrFail($id)->update($request->all());
            return $this->response(null, 204);
        } catch (\Throwable $th) {
            return $this->responseError($th->getCode(), $th->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $credential = Credentials::where(CREDENTIAL_TOKEN_FIELD, $request->header(HEADER_AUTH_KEY))->first();

        if ($credential) {
            $user_id = $credential->user_id;
        } else return $this->response(null, 401);

        try {
            $events = Events::allEventsFiltered($user_id)->where(EVENT_ID_FIELD, $id)->first();
            if ($events && $events->is_admin == 1) {
                $events->delete();
                return $this->response(null, 204);
            } else return $this->response(null, 401);
        } catch (\Throwable $th) {
            echo $th->getMessage();
            return $this->responseError($th->getCode());
        }
    }
}
