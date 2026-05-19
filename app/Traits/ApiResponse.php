<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function successResponse($data, string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    protected function errorResponse(string $message, int $code = 400, $errors = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
        ], $code);
    }

    protected function paginatedResponse($resource, string $message = 'Success'): JsonResponse
    {
        return response()->json([
            'success'    => true,
            'message'    => $message,
            'data'       => $resource->items(),
            'pagination' => [
                'current_page' => $resource->currentPage(),
                'per_page'     => $resource->perPage(),
                'total'        => $resource->total(),
                'last_page'    => $resource->lastPage(),
            ],
        ]);
    }
}