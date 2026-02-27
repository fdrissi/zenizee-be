<?php
require_once __DIR__ . '/env.php';

if (session_status() == PHP_SESSION_NONE) {
    $sessionPath = $_ENV['SESSION_PATH'] ?? '';
    if ($sessionPath !== '') {
        $fullPath = dirname(__DIR__) . '/' . $sessionPath;
        if (!is_dir($fullPath)) {
            mkdir($fullPath, 0755, true);
        }
        session_save_path($fullPath);
    }
    session_start();
}

try {
    $evmulti = new mysqli(
        $_ENV['DB_HOST'] ?? 'localhost',
        $_ENV['DB_USER'] ?? 'root',
        $_ENV['DB_PASS'] ?? '',
        $_ENV['DB_NAME'] ?? 'magicmate'
    );
    $evmulti->set_charset("utf8mb4");
} catch (Exception $e) {
    error_log($e->getMessage());
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
