<?php
require dirname(dirname(__FILE__)) . '/filemanager/evconfing.php';
header('Content-type: application/json');

$_SESSION = [];
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

echo json_encode([
    "ResponseCode" => "200",
    "Result"       => "true",
    "ResponseMsg"  => "Logged out successfully",
]);
