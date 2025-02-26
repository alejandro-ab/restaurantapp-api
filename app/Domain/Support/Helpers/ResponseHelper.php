<?php

namespace App\Domain\Support\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ResponseHelper
{
    public static function success(array|JsonResource|null $data = null, int $statusCode = Response::HTTP_OK): JsonResponse
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

    public static function validationError(ValidationException $validationException): JsonResponse
    {
        $errors = implode(' ', array_map(fn($error) => implode(' ', $error), $validationException->errors()));

        return self::error($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
