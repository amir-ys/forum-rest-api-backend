<?php


namespace App\Responses;


use Illuminate\Http\Response;

class AjaxResponse
{
    public static function ok($message, $status = \Illuminate\Http\Response::HTTP_OK)
    {
        return response()->json(['message' => $message], $status);
    }

    public static function SendData($data, $statusCode = \Illuminate\Http\Response::HTTP_OK)
    {
        return response()->json($data, $statusCode);
    }

    public static function created($message)
    {
        return response()->json(['message' => $message], \Illuminate\Http\Response::HTTP_CREATED);
    }

}
