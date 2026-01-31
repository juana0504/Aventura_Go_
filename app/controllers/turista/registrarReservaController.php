<?php
require_once BASE_PATH . '/app/helpers/session_turista.php';
require_once BASE_PATH . '/app/models/turista/ReservaTurista.php';
require_once BASE_PATH . '/app/models/proveedor_turistico/ActividadTuristica.php';

// Validar que exista reserva pendiente
if (!isset($_SESSION['actividad_pendiente']['id_reserva'])) {
    header('Location: ' . BASE_URL . '/turista/ver-reservas');
    exit;
}

$id_reserva = $_SESSION['actividad_pendiente']['id_reserva'];
$id_turista = $_SESSION['user']['id_usuario'];

$reservaModel   = new ReservaTurista();
$actividadModel = new ActividadTuristica();

// 1️⃣ Confirmar la reserva
$reservaModel->confirmarReserva($id_reserva, $id_turista);

// 2️⃣ Obtener datos de la reserva confirmada
$reserva = $reservaModel->obtenerReservaPorId($id_reserva);

// Seguridad extra
if (!$reserva) {
    header('Location: ' . BASE_URL . '/turista/ver-reservas');
    exit;
}

// 3️⃣ Descontar cupos
$actividadModel->descontarCupos(
    $reserva['id_actividad'],
    $reserva['cantidad_personas']
);

// 4️⃣ Limpiar sesión
unset($_SESSION['actividad_pendiente']);

// 5️⃣ Redirigir
header('Location: ' . BASE_URL . '/turista/ver-reservas');
exit;
