<?php
require_once BASE_PATH . '/app/helpers/session_turista.php';
require_once BASE_PATH . '/app/models/turista/ReservaTurista.php';

// Validar sesión pendiente
if (!isset($_SESSION['actividad_pendiente'])) {
    header('Location: ' . BASE_URL . '/website/descubre-tours');
    exit;
}

$pendiente = $_SESSION['actividad_pendiente'];
$actividad = $pendiente['actividad'];

$data = [
    'id_turista'         => $_SESSION['user']['id_usuario'],
    'id_actividad'       => $actividad['id_actividad'],
    'fecha'              => $pendiente['fecha'],
    'cantidad_personas'  => $pendiente['personas'],
    'precio'             => $actividad['precio'],
    'estado'             => 'pendiente',
    'tipo_reserva'       => 'actividad'
];

$reservaModel = new ReservaTurista();
$id_reserva = $reservaModel->crearReserva($data);

// Guardar id_reserva para el siguiente paso
$_SESSION['actividad_pendiente']['id_reserva'] = $id_reserva;

// Redirigir
header('Location: ' . BASE_URL . '/turista/ver-reservas');
exit;
