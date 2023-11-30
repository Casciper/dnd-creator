<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait CommonResponsesTrait
{
    protected function responseOk(string $message = ''): JsonResponse
    {
        return response()->json(data: ['result' => true, 'errors' => [], 'message' => $message], options: JSON_UNESCAPED_UNICODE);
    }

    protected function responseFail(array $errors = [], string $message = ''): JsonResponse
    {
        return response()->json(['result' => false, 'errors' => $errors, 'message' => $message], options: JSON_UNESCAPED_UNICODE);
    }

    protected function responseData(array $data = []): JsonResponse
    {
        return response()->json(data: ['result' => true, 'data' => $data], options: JSON_UNESCAPED_UNICODE);
    }
}
