<?php

namespace App\Http\Controllers;

use App\Helpers\EncryptHelper;
use App\Models\Credentials;
use App\Users;

use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    //
    public function index()
    {
        return $this->response(Users::all(), 200);
    }

    public function show(Request $request, $id)
    {
        try {
            $credential = Credentials::where(CREDENTIAL_TOKEN_FIELD, $request->header(HEADER_AUTH_KEY))->first();

            if($credential[RESPONSE_IS_SUPERADMIN_FIELD]) {
                $user = Users::find($id);
                return $this->response($user, 200);
            } else {
                if ($credential[USER_ID_FOREIGN_FIELD] == $id) {
                    return $this->response($credential->user, 200);
                } else {
                    return $this->response(null, 401);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            // echo $th->getMessage();
            return $this->responseError($th->getCode());
        }
    }

    public function store(Request $request)
    {
        try {
            $request[USER_PASSWORD_FIELD] = EncryptHelper::encryptPasword($request->input(USER_PASSWORD_FIELD));

            Users::create($request->all());
            return $this->response(null, 201);
        } catch (\Throwable $th) {
            return $this->responseError($th->getCode());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Users::findOrFail($id)->update($request->all());
            return $this->response(null, 204);
        } catch (\Throwable $th) {
            return $this->responseError($th->getCode());
        }
    }

    public function destroy($id)
    {
        try {
            Users::findOrFail($id)->delete();
            return $this->response(null, 204);
        } catch (\Throwable $th) {
            return $this->responseError($th->getCode());
        }
    }
}
