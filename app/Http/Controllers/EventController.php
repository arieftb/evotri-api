<?php

namespace App\Http\Controllers;

use App\Events\Event;
use App\Helpers\EncryptHelper;
use App\Http\Controllers\BaseController;
use App\Models\Credentials;
use App\Models\EventAdmins;
use App\Models\Events;
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

            $voterPost = $event->voter()->save($voter);

            if ($voterPost) {
                $eventAdmin = new EventAdmins();
                $eventAdmin[VOTER_ID_FOREIGN_FIELD] = $voterPost->id;
                $eventAdminPost = $voterPost->admin()->save($eventAdmin);

                if ($eventAdminPost) {
                    return $this->response(null, 201);
                } else {
                    return $this->response(null, 400);
                }
            } else {
                return $this->response(null, 400);
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
            return $this->responseError($th->getCode(), $th->getMessage());
        }
    }
}