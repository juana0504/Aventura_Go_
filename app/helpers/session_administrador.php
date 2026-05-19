<?php

// Ensure session is started only once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Validate session and role
if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . 'login');
    exit();
}

if ($_SESSION['user']['rol'] != 'administrador') {
    header('Location: ' . BASE_URL . 'login');
    exit();
}
