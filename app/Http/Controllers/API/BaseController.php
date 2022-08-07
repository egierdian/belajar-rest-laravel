<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#INI Bisa digunakan untuk templating response json
class BaseController extends Controller
{
    public function responseOk($result, $code = 200, $message = 'Success'){
        $response = [
            'code' => $code,
            'message' => $message,
            'data' => $result,
        ];

        return response()->json($response, $code);
    }
    public function responseError($error, $code = 422, $errorDetails = []){
        $response = [
            'code' => $code,
            'error' => $error,
        ];
        if(!empty($errorDetails)){
            $response['errorDetails'] = $errorDetails;
        }
        return response()->json($response, $code);
    }
}
