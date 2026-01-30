<?php
// =======================================================
// Preparar reserva desde website
// Crea la sesión y redirige al dashboard del turista
// =======================================================

// Protección de sesión por rol (si no está logueado, lo saca)
require_once BASE_PATH . '/app/helpers/session_turista.php';

// Validar que venga el id de la actividad
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: ' . BASE_URL . '/descubre-tours');
    exit;
}

// Guardamos la actividad pendiente en sesión
$_SESSION['actividad_pendiente'] = [
    'id_actividad' => (int) $_GET['id'],
    'fecha' => date('Y-m-d'),
    'personas' => 1
];


// Redirigimos al flujo correcto del dashboard
header('Location: ' . BASE_URL . '/turista/confirmar-reserva');
exit;
