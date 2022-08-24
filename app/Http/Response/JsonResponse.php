<?php

namespace App\Http\Response;

trait  JsonResponse
{
    static function apiResponse($message, $data = [], $response_code = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $response_code);
    }
}
