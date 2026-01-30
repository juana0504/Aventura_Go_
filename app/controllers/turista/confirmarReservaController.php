<?php
// Protección de sesión por rol
require_once BASE_PATH . '/app/helpers/session_turista.php';
require_once BASE_PATH . '/app/models/proveedor_turistico/ActividadTuristica.php';


// Validar que exista una actividad pendiente
if (!isset($_SESSION['actividad_pendiente'])) {
    header('Location: ' . BASE_URL . '/turista/dashboard');
    exit;
}

// Traemos datos guardados en sesión
$pendiente = $_SESSION['actividad_pendiente'];

// Cargamos el modelo de actividad turística
require_once BASE_PATH . '/app/models/proveedor_turistico/ActividadTuristica.php';
$actividadModel = new ActividadTuristica();

// Consultamos la actividad real desde BD
$actividad = $actividadModel->obtenerPorId($pendiente['id_actividad']);

// Validación de seguridad
if (!$actividad) {
    unset($_SESSION['actividad_pendiente']);
    header('Location: ' . BASE_URL . '/descubre-tours');
    exit;
}

// Cargamos la vista de confirmación
require_once BASE_PATH . '/app/views/dashboard/turista/confirmar_reserva.php';
