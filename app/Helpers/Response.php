<?php

function responseSuccess(
    array $data = [],
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
    string $message = 'That bai',
    $statusCode = 404
) {
    return response()->json([
        'success' => false,
        'message' => $message,
        'data' => $data,
    ], $statusCode);
}