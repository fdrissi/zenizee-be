<?php
if (session_status() == PHP_SESSION_NONE) {
    $sessionPath = __DIR__ . '/sessions';
    if (!is_dir($sessionPath)) {
        mkdir($sessionPath, 0755, true);
    }
    session_save_path($sessionPath);
    session_start();
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $evmulti = new mysqli("localhost", "dnemdcudnp", "zDbQHVPM7p", "dnemdcudnp");
    $evmulti->set_charset("utf8mb4");
} catch (Exception $e) {
    error_log($e->getMessage());
    error_log($e->getMessage());
    //Should be a message a typical user could understand
}
if (!$evmulti) {
    die("Database not initialized.");
}
$set = $evmulti->query("SELECT * FROM `tbl_setting`")->fetch_assoc();
date_default_timezone_set($set["timezone"]);

if (isset($_SESSION["stype"]) && $_SESSION["stype"] == "sowner") {

    $sdata = $evmulti
        ->query(
            "SELECT * FROM `tbl_sponsore` where email='" .
            $_SESSION["evename"] .
            "'"
        )
        ->fetch_assoc();

}

$maindata = $evmulti->query("SELECT * FROM `tbl_etom`")->fetch_assoc();
