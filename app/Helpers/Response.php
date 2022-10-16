<?php

use Illuminate\Database\Eloquent\Collection;

function responseSuccess(
    array|Collection $data = [],
    string $message = 'Thành công',
    $statusCode = 200
) {
    return response()->json([
        'success' => true,
        'message' => $message,
        'data' => $data,
    ], $statusCode);
}

function reponseError(
    array $data = [],
    string $message = 'Đã có lỗi xảy ra, vui lòng thử lại sau',
    $statusCode = 404
) {
    return response()->json([
        'message' => $message,
        'data' => $data,
    ], $statusCode);
}