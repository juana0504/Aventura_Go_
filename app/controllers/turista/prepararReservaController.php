<?php
session_start();

require_once BASE_PATH . '/app/models/proveedor_turistico/ActividadTuristica.php';

// Validar que venga el id
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: ' . BASE_URL . '/website/descubre_tours');
    exit;
}

$idActividad = (int) $_GET['id'];

// Obtener datos reales de la actividad
$model = new ActividadTuristica();
$actividad = $model->obtenerDetalleActividad($idActividad);

if (!$actividad) {
    header('Location: ' . BASE_URL . '/website/descubre_tours');
    exit;
}

// Guardar actividad pendiente en sesión
$_SESSION['actividad_pendiente'] = [
    'id_actividad' => $actividad['id_actividad'],
    'fecha'        => date('Y-m-d'),
    'personas'     => 1,
    'actividad'    => $actividad
];

// Si NO está logueado como turista → login
if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] !== 'turista') {

    $_SESSION['redirect_after_login'] = '/turista/confirmar-reserva';

    header('Location: ' . BASE_URL . '/login');
    exit;
}

// Si ya está logueado → confirmar reserva
header('Location: ' . BASE_URL . '/turista/confirmar-reserva');
exit;
