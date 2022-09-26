<?php

namespace App\Http\Middleware;

use App\Enums\Response\MessageEnum;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use App\Enums\Response\StatusCode;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            throw new HttpResponseException(response()->json(
                [
                    'error' => MessageEnum::AUTHENTICATE_FAILD,
                    'status_code' => StatusCode::FAIL_AUTHENTICATE,
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        }
    }
}
