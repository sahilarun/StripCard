<?php

namespace App\Http\Helpers\Api;

class Helpers {
    public static function unauthorized($data, $message = null)
    {
        return response()->json([ 'data' => $data, 'message' => $message,], 401);
    }
    public static function success($data, $message = null)
    {
        return response()->json([ 'message' => $message,'data' => $data], 200);
    }
    public static function onlysuccess($message = null)
    {
        return response()->json([ 'message' => $message], 200);
    }

    public static function no_content($message = 'No Data Found')
    {
        return response()->json(['data' => null, 'message' => $message], 204);
    }

    public static function created($message = 'Data Created', $data = null)
    {
        return response()->json([ 'message' => $message, 'data' => $data], 201);
    }

    public static function updated($message = 'Data Updated', $data = null)
    {
        return response()->json(['message' => $message,'data' => $data], 202);
    }

    public static function deleted($message = 'Data Deleted', $data = null)
    {
        return response()->json(['data' => $data, 'message' => $message], 202);
    }

    public static function error($message = 'Something Went Wrong', $data = null)
    {
        return response()->json(['data' => $data, 'message' => $message], 400);
    }

    public static function validation($message = 'Invalid Submission', $data = null)
    {
        return response()->json(['data' => $data, 'message' => $message], 422);
    }
}
