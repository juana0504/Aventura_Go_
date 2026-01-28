<?php
// Protección de sesión
require_once BASE_PATH . '/app/helpers/session_turista.php';

// Validar actividad pendiente
if (!isset($_SESSION['actividad_pendiente'])) {
    header('Location: ' . BASE_URL . '/turista/dashboard');
    exit;
}

$pendiente = $_SESSION['actividad_pendiente'];
$idTurista = $_SESSION['user']['id_usuario'];

// Cargar modelo de reservas
require_once BASE_PATH . '/app/models/turista/Reserva.php';
$reservaModel = new Reserva();

// Registrar la reserva
$reservaCreada = $reservaModel->crearReservaActividad(
    $idTurista,
    $pendiente['id'],
    $pendiente['fecha'],
    $pendiente['personas']
);

// Validar resultado
if ($reservaCreada) {
    // Limpiar sesión pendiente
    unset($_SESSION['actividad_pendiente']);

    header('Location: ' . BASE_URL . '/turista/dashboard');
    exit;
}

// Error controlado
header('Location: ' . BASE_URL . '/turista/confirmar-reserva');
exit;
