<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function set_flash($type, $msg) {
    $_SESSION['flash'][$type] = $msg;
}

function get_flash($type) {
    if (isset($_SESSION['flash'][$type])) {
        $msg = $_SESSION['flash'][$type];
        unset($_SESSION['flash'][$type]);
        return $msg;
    }
    return null;
}