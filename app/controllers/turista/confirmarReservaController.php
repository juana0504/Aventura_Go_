<?php
require_once BASE_PATH . '/app/helpers/session_turista.php';
require_once BASE_PATH . '/app/models/turista/ReservaTurista.php';
require_once BASE_PATH . '/app/models/proveedor_turistico/ActividadTuristica.php';

if (!isset($_GET['id'])) {
    header('Location: ' . BASE_URL . '/turista/ver-reservas');
    exit;
}

$id_reserva = (int) $_GET['id'];
$id_turista = $_SESSION['user']['id_usuario'];

$reservaModel   = new ReservaTurista();
$actividadModel = new ActividadTuristica();

// Obtener reserva
$reserva = $reservaModel->obtenerReservaPorId($id_reserva);

// Seguridad
if (!$reserva || $reserva['id_turista'] != $id_turista) {
    header('Location: ' . BASE_URL . '/turista/ver-reservas');
    exit;
}

// Confirmar reserva
$reservaModel->confirmarReserva($id_reserva, $id_turista);

// Descontar cupos
$actividadModel->descontarCupos(
    $reserva['id_actividad'],
    $reserva['cantidad_personas']
);

// Redirigir
header('Location: ' . BASE_URL . '/turista/ver-reservas');
exit;
