<?php

namespace App\Http\Response;

trait  JsonResponse
{
    /**
     * Json response for api
     *
     * @param $message
     * @param array $data
     * @param int $response_code
     * @return \Illuminate\Http\JsonResponse
     */
    static function apiResponse($message, array $data = [], int $response_code = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $response_code);
    }
}
