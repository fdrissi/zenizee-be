<?php
require dirname(dirname(__FILE__)) . '/filemanager/evconfing.php';
header('Content-type: application/json');

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    echo json_encode([
        "ResponseCode" => "401",
        "Result"       => "false",
        "ResponseMsg"  => "Not authenticated",
        "UserLogin"    => null,
    ]);
    exit;
}

$uid = intval($_SESSION['user_id']);
$result = $evmulti->query("SELECT * FROM tbl_user WHERE id = " . $uid . " AND status = 1");

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    unset($user['password']);
    echo json_encode([
        "ResponseCode" => "200",
        "Result"       => "true",
        "ResponseMsg"  => "User data retrieved",
        "UserLogin"    => $user,
    ]);
} else {
    session_destroy();
    echo json_encode([
        "ResponseCode" => "401",
        "Result"       => "false",
        "ResponseMsg"  => "Session invalid",
        "UserLogin"    => null,
    ]);
}
