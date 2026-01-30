<?php

// Preparar reserva desde website (PUBLICO)
// Guarda la actividad y luego valida login


// NO proteger aquí con session_turista

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

// Ahora sí: validar login
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'turista') {

    // guardamos a dónde debe volver luego del login
    $_SESSION['redirect_after_login'] = '/turista/confirmar-reserva';

    header('Location: ' . BASE_URL . '/login');
    exit;
}

// Si ya está logueado, seguimos normal
header('Location: ' . BASE_URL . '/turista/confirmar-reserva');
exit;
