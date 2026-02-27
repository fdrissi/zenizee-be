<?php
$sessionPath = __DIR__ . '/sessions';
if (!is_dir($sessionPath)) {
    mkdir($sessionPath, 0755, true);
}
session_save_path($sessionPath);
session_start();
session_destroy();
?>
<script>
window.location.href="/";
</script>
