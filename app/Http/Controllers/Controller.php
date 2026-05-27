<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    /**
     * Standard API response method for success.
     *
     * @param  mixed $data The data payload (e.g., model, collection, array).
     * @param  string $message A descriptive success message.
     * @param  int $code HTTP status code (default 200).
     * @return JsonResponse
     */
    public function handleResponse(mixed $data = [], string $message = "", int $code = 200) : JsonResponse {
        $response = [
            'success' => true,
            'data' => $data,
            'message' => $message
        ];

        return response()->json($response, $code);
    }

    /**
     * Standard API response method for errors.
     *
     * @param  string $message The main error message.
     * @param  mixed $data the data payload.
     * @param  int $code HTTP status code (default 404).
     * @return JsonResponse
     */
    public function handleErrorResponse(mixed $data = [], string $message = "", int $code = 500) : JsonResponse {
        $response = [
            'success' => false,
            'data' => $data,
            'message' => $message
        ];

        return response()->json($response, $code);
    }
}
