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

// Mantiene sincronizados los datos base del admin (nombre/foto) para el topbar.
if (!empty($_SESSION['user']['id_usuario'])) {
    require_once __DIR__ . '/../models/perfil.php';

    try {
        $perfilModel = new Perfil();
        $adminActual = $perfilModel->mostrarPerfilAdmin((int) $_SESSION['user']['id_usuario']);

        if (is_array($adminActual)) {
            if (!empty($adminActual['nombre'])) {
                $_SESSION['user']['nombre'] = $adminActual['nombre'];
            }

            $_SESSION['user']['foto'] = $adminActual['foto'] ?? 'default.png';
        }
    } catch (\Throwable $e) {
        // Si falla la lectura de perfil, se conserva la sesión actual.
    }
}
