<?php
/**
 * Get authenticated user ID from session or legacy request body.
 * Session auth (web) takes priority. Falls back to $data['uid'] for mobile apps.
 */
function get_auth_uid($data = null, $evmulti = null) {
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        return intval($_SESSION['user_id']);
    }
    if ($data !== null && isset($data['uid']) && $data['uid'] !== '') {
        return intval($data['uid']);
    }
    return 0;
}

function require_auth() {
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        header('Content-type: application/json');
        echo json_encode([
            "ResponseCode" => "401",
            "Result" => "false",
            "ResponseMsg" => "Not authenticated"
        ]);
        exit;
    }
    return intval($_SESSION['user_id']);
}
