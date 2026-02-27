<?php
if (session_status() == PHP_SESSION_NONE) {
$sessionPath = __DIR__ . '/../sessions';
if (!is_dir($sessionPath)) {
        mkdir($sessionPath, 0755, true);
    }
session_save_path($sessionPath);
session_start();	
}


try {
    $evmulti = new mysqli("localhost", "dnemdcudnp", "zDbQHVPM7p", "dnemdcudnp");
    $evmulti->set_charset("utf8mb4");
} catch (Exception $e) {
    error_log($e->getMessage());
    //Should be a message a typical user could understand
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
if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }
