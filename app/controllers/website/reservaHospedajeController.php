<?php
session_start();

require_once BASE_PATH . '/app/models/proveedor_hotelero/hospedaje.php';
require_once BASE_PATH . '/app/models/proveedor_hotelero/ReservaHotelero.php';
require_once BASE_PATH . '/app/helpers/alert_helper.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'descubre-hospedaje');
    exit;
}

if (!isset($_SESSION['user'])) {
    $id_hosp = (int)($_POST['id_hospedaje'] ?? 0);
    $_SESSION['redirect_after_login'] = BASE_URL . 'hospedaje-escogido?id=' . $id_hosp;
    header('Location: ' . BASE_URL . 'login');
    exit;
}

if (($_SESSION['user']['rol'] ?? '') !== 'turista') {
    mostrarSweetAlert('error', 'Acceso denegado', 'Solo los turistas pueden hacer reservas.', BASE_URL . 'descubre-hospedaje');
    exit;
}

$id_hospedaje      = (int)($_POST['id_hospedaje'] ?? 0);
$fecha             = trim($_POST['fecha'] ?? '');
$cantidad_personas = (int)($_POST['cantidad_personas'] ?? 0);
$id_turista        = (int)$_SESSION['user']['id_usuario'];

if (!$id_hospedaje || !$fecha || $cantidad_personas < 1) {
    mostrarSweetAlert('error', 'Datos incompletos', 'Completa todos los campos para reservar.', BASE_URL . 'hospedaje-escogido?id=' . $id_hospedaje);
    exit;
}

if (strtotime($fecha) < strtotime(date('Y-m-d'))) {
    mostrarSweetAlert('error', 'Fecha inválida', 'La fecha de llegada no puede ser anterior a hoy.', BASE_URL . 'hospedaje-escogido?id=' . $id_hospedaje);
    exit;
}

$hospedajeModel = new Hospedaje();
$hospedaje      = $hospedajeModel->obtenerPublico($id_hospedaje);

if (!$hospedaje) {
    mostrarSweetAlert('error', 'Hospedaje no disponible', 'El hospedaje no está disponible.', BASE_URL . 'descubre-hospedaje');
    exit;
}

if ($cantidad_personas > (int)$hospedaje['capacidad']) {
    mostrarSweetAlert('error', 'Sin capacidad', 'La cantidad de personas supera la capacidad de esta acomodación (' . $hospedaje['capacidad'] . ' personas).', BASE_URL . 'hospedaje-escogido?id=' . $id_hospedaje);
    exit;
}

// Verificar disponibilidad específica para la fecha solicitada
if (!$hospedajeModel->haycapacidadDisponibles($id_hospedaje, $fecha, $cantidad_personas)) {
    mostrarSweetAlert(
        'error',
        'Fecha no disponible',
        'Esta acomodación ya está completa para el ' . date('d/m/Y', strtotime($fecha)) . '. Por favor elige otra fecha.',
        BASE_URL . 'hospedaje-escogido?id=' . $id_hospedaje
    );
    exit;
}

$reservaModel = new ReservaHotelero();
$id_reserva   = $reservaModel->crear([
    'id_hospedaje'      => $id_hospedaje,
    'id_turista'        => $id_turista,
    'fecha'             => $fecha,
    'cantidad_personas' => $cantidad_personas,
    'precio'            => $hospedaje['precio'] ?? 0,
]);

if ($id_reserva) {
    // Notificación al turista
    require_once BASE_PATH . '/app/models/NotificacionModel.php';
    (new NotificacionModel())->crear(
        $id_turista,
        'reserva_hospedaje',
        '¡Reserva de hospedaje registrada!',
        'Tu reserva en "' . $hospedaje['nombre'] . '" para el ' . date('d/m/Y', strtotime($fecha)) . ' fue registrada. El proveedor la confirmará pronto.',
        'bi-building-check',
        'blue',
        'turista/ver-reservas-hotel',
        $id_reserva
    );
    mostrarSweetAlert(
        'success',
        '¡Reserva realizada!',
        'Tu reserva en "' . htmlspecialchars($hospedaje['nombre']) . '" fue registrada. El proveedor la confirmará pronto.',
        BASE_URL . 'turista/dashboard'
    );
} else {
    mostrarSweetAlert('error', 'Error al reservar', 'No se pudo completar la reserva. Intenta de nuevo.', BASE_URL . 'hospedaje-escogido?id=' . $id_hospedaje);
}
