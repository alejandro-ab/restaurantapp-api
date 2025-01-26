<?php

namespace App\Domain\Support\Helpers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseHelper
{
    public static function success(?array $data = null, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json(array_filter([
            'status' => 'OK',
            'data' => $data,
        ]), $statusCode);
    }

    public static function error(string $errorMessage, int $statusCode): JsonResponse
    {
        return response()->json([
            'status' => 'FAILED',
            'message' => $errorMessage,
        ], $statusCode);
    }

    public static function validationError(array $errors): JsonResponse
    {
        return response()->json([
            'status' => 'FAILED',
            'errors' => $errors,
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
