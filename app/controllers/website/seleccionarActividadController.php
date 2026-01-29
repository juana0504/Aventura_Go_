
<?php
// Iniciamos sesión
session_start();

// Validamos que llegue el ID de la actividad
if (!isset($_POST['id_actividad'])) {
    header('Location: ' . BASE_URL . '/descubre-tours');
    exit;
}

// Capturamos datos enviados desde el formulario
$idActividad = $_POST['id_actividad'];
$fecha       = $_POST['fecha']       ?? null;
$personas    = $_POST['personas']    ?? 1;

// Guardamos la actividad seleccionada en sesión
$_SESSION['actividad_pendiente'] = [
    'tipo'      => 'actividad',
    'id'        => $idActividad,
    'fecha'     => $fecha,
    'personas'  => $personas
];

// ¿El usuario ya inició sesión?
if (isset($_SESSION['user']) && $_SESSION['user']['rol'] === 'turista') {
    header('Location: ' . BASE_URL . '/turista/confirmar-reserva');
    exit;
}

// Si no está logueado → login
header('Location: ' . BASE_URL . '/login');
exit;
