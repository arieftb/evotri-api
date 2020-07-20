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

    public function storeByEvent(Request $request, $event_id)
    {
        $user_id = Credentials::where(CREDENTIAL_TOKEN_FIELD, $request->header(HEADER_AUTH_KEY))->firstOrFail()->user_id;
        $event = Events::where(ID_FIELD, $event_id)->where(EVENT_CODE_FIELD, $request->input(EVENT_CODE_FIELD))->firstOrFail();
        $voter = $event->voter->where(USER_ID_FOREIGN_FIELD, $user_id)->first();

        if ($voter) {
            return $this->response(null, 409);
        }

        if ($user_id && $event) {
            $request[USER_ID_FOREIGN_FIELD]  = $user_id;
            $request[EVENT_ID_FOREIGN_FIELD] = $event->id;

            try {
                //code...
                $voter = Voters::create($request->all());

                if ($voter) {
                    return $this->response(null, 201);
                } else {
                    return $this->response(null, 400);
                }
            } catch (\Throwable $th) {
                //throw $th;
                return $this->responseError($th->getCode(), $th->getMessage());
            }
        } else {
            return $this->response(null, 400);
        }
    }
}
