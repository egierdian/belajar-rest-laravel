<?php

namespace App\Helpers;

class ApiFormatter {
    protected static $response = [
        'code' => null,
        'message' => null,
        'data' => null,
    ];

    public static function createApi($code=null,$message=null,$data=null){
        self::$response['code'] = $code;
        self::$response['message'] = $message;
        self::$response['data'] = $data;
        // self::$response['detail_data']['data'] = 'ini coba-coba aja';


        return response()->json(self::$response, self::$response['code']);
    }
}