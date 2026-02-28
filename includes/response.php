<?php
/**
 * Standard API response helpers.
 */

function cors_headers() {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }
}

function json_success($message, $extras = []) {
    echo json_encode(array_merge([
        "ResponseCode" => "200",
        "Result"       => "true",
        "ResponseMsg"  => $message,
    ], $extras));
    exit;
}

function json_error($message, $code = "401", $extras = []) {
    echo json_encode(array_merge([
        "ResponseCode" => $code,
        "Result"       => "false",
        "ResponseMsg"  => $message,
    ], $extras));
    exit;
}
