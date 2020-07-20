<?php

namespace App\Http\Controllers;

use Exception;

class BaseController extends Controller
{

    protected $baseToken = HEADER_TOKEN_VALUE;

    protected function response($data, $statusCode = 200, $message = null)
    {
        $response = [
            'status' => $statusCode >= 200 && $statusCode < 300,
            'code' => $statusCode,
            'message' => ($message != null) ? $message : $this->getMessageOfStatusCode($statusCode),
            'data' => $data != null ? ['data' => $data] : null
        ];

        return response()->json($response, $statusCode);
    }

    protected function responseError($exceptionCode, $message = null)
    {
        $response = [
            'status' => $exceptionCode >= 200 && $exceptionCode < 300,
            'code' => (int) $exceptionCode,
            'message' => $message != null ? $message : $this->getMessageOfStatusCode($exceptionCode)
        ];

        return response()->json($response, $this->getCodeByThrowable($exceptionCode));
    }

    private function getCodeByThrowable($th)
    {
        switch ($th) {
            case 23000:
                return 400;
                break;
            default:
                return 500;
                break;
        }
    }

    private function getMessageOfStatusCode($statusCode = 200)
    {
        switch ($statusCode) {
            case 200:
            case 201:
                return 'Success';
                break;
            case 401:
                return 'Unauthorized';
                break;
            case 403:
                return 'Bad Request';
                break;
            case 409:
                return 'Duplicate';
                break;
            case 23000:
                return 'Duplicate Value';
                break;
            default:
                return 'Something Went Wrong';
                break;
        }
    }
}
