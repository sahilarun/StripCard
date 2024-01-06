<?php
namespace App\Http\Helpers;

class Response {

    public static function error($errors,$data = null, $status = 400) {
        $responseData = [
            'message'   => [
                'error'    => $errors,
            ],
            'data'      => $data,
            'type'          => "error",
        ];
        
        return response()->json($responseData,$status);
    }

    public static function success($success,$data = null,$status = 200) {
        $responseData = [
            'message'       => [
                'success'   => $success,
            ],
            'data'          => $data,
            'type'          => "success",
        ];

        return response()->json($responseData,$status);
    }

    public static function warning($warning,$data = null,$status = 400) {
        $responseData = [
            'message'       => [
                'error'     => $warning,
            ],
            'data'          => $data,
            'type'          => "warning",
        ];

        return response()->json($responseData,$status);
    }
}