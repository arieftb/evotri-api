<?php

namespace App\Http\Controllers;

use App\Users;
use Illuminate\Http\Request;
use App\Helpers\EncryptHelper;
use App\Models\Credentials;
use App\Models\Passwords;
use Illuminate\Support\Facades\Validator;

class CredentialController extends BaseController
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

    public function login(Request $request)
    {
        $user = Passwords::all()
            ->where(USER_EMAIL_FIELD, '=', $request->input(USER_EMAIL_FIELD))
            ->first();

        if ($user && password_verify(
            $request->input(USER_PASSWORD_FIELD),
            $user->password
        )) {
            $request[USER_ID_FOREIGN_FIELD] = $user[USER_ID_FIELD];
            $request[CREDENTIAL_LOGIN_DATETIME_FILED] = date('Y-m-d H:i:s');
            $request[CREDENTIAL_TOKEN_FIELD] =
                EncryptHelper::encryptPasword($user[USER_PASSWORD_FIELD] . $request->Input(CREDENTIAL_LOGIN_DATETIME_FILED));

            return $this->store($request);
        } else {
            return $this->response(null, 400, MESSAGE_ERROR_USER_FAILED_LOGIN);
        }
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            USER_ID_FOREIGN_FIELD => 'required',
            CREDENTIAL_LOGIN_DATETIME_FILED => 'required',
            CREDENTIAL_TOKEN_FIELD => 'required|unique:credentials'
        ]);

        if ($validation->fails()) {
            return $this->response(null, 400, MESSAGE_ERROR_USER_FAILED_LOGIN);
        }

        try {
            $credentials = Credentials::create($request->all());
            $credential = Credentials::where(USER_ID_FOREIGN_FIELD, $credentials[USER_ID_FOREIGN_FIELD])->first();

            return $this->response($credential, 200, null);
        } catch (\Throwable $th) {
            return $this->responseError($th->getCode());
        }
    }

    public function destroy(Request $request)
    {
        try {
            Credentials::where(CREDENTIAL_TOKEN_FIELD, $request->header(HEADER_AUTH_KEY))->delete();
            $this->response(null, 200);
        } catch (\Throwable $th) {
            $this->responseError($th->getCode());
        }
    }
}
