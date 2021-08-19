<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * @param $response
     * @param int $status
     * @return JsonResponse
     */
    public function successResponse($response, $status = 200)
    {
        $data = [];
        $data['data'] = $response;
        $data['status'] = $status;
        return response()->json($data, $status);
    }

    /**
     * @param $message
     * @param $status
     * @return JsonResponse
     */
    public function errorResponse($message, $status)
    {
        $data = [];
        $data['error']['message'] = $message;
        $data['error']['status'] = $status;
        return response()->json($data, $status);
    }

    /**
     * @param $message
     * @param int $status
     * @return JsonResponse
     */
    public function messageResponse(String $message, $status = 200)
    {
        return response()->json($message, $status);
    }
}
