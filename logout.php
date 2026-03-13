<?php
require __DIR__ . '/filemanager/env.php';
$sessionPath = $_ENV['SESSION_PATH'] ?? '';
if ($sessionPath !== '') {
    $fullPath = __DIR__ . '/' . $sessionPath;
    if (!is_dir($fullPath)) {
        mkdir($fullPath, 0755, true);
    }
    session_save_path($fullPath);
}
session_start();
session_destroy();
?>
<script>
window.location.href="/";
</script>
