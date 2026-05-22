<?php

try {
    include_once __DIR__ . '/frontend/config/config.php';
    require_once __DIR__ . '/frontend/views/includes/header.php';
    require_once __DIR__ . '/frontend/route.php';
    require_once __DIR__ . '/frontend/views/includes/footer.php';
} catch (Exception $e) {
    // echo $e->getMessage();
    error_log($e->getMessage());
}
