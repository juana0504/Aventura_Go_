<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] !== 'proveedor') {
    header('Location: /aventura_go/login');
    exit;
}

require BASE_PATH . '/app/views/layouts/proveedor_turistico_dashboard.php';
