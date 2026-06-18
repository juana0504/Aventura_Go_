<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'descubre-hospedaje');
    exit;
}

if (!isset($_SESSION['user'])) {
    $reserva = $_SESSION['hotel_reserva'] ?? null;
    $id = $reserva['id_hospedaje'] ?? 0;
    $_SESSION['redirect_after_login'] = BASE_URL . 'hotel-checkout';
    header('Location: ' . BASE_URL . 'login');
    exit;
}

if (($_SESSION['user']['rol'] ?? '') !== 'turista') {
    header('Location: ' . BASE_URL . 'descubre-hospedaje');
    exit;
}

$reserva = $_SESSION['hotel_reserva'] ?? null;
if (!$reserva) {
    header('Location: ' . BASE_URL . 'descubre-hospedaje');
    exit;
}

require_once BASE_PATH . '/app/models/proveedor_hotelero/ReservaHotelero.php';
require_once BASE_PATH . '/app/helpers/alert_helper.php';

$id_turista = (int)$_SESSION['user']['id_usuario'];

$reservaModel = new ReservaHotelero();
$id_reserva   = $reservaModel->crear([
    'id_hospedaje'      => $reserva['id_hospedaje'],
    'id_turista'        => $id_turista,
    'fecha'             => $reserva['fecha'],
    'cantidad_personas' => $reserva['cantidad_personas'],
    'precio'            => $reserva['precio_noche'],
]);

if (!$id_reserva) {
    mostrarSweetAlert('error', 'Error al reservar', 'No se pudo completar la reserva. Intenta de nuevo.', BASE_URL . 'hotel-checkout');
    exit;
}

// Guardar datos de confirmación en sesión
$_SESSION['hotel_confirmacion'] = [
    'reference'              => $_SESSION['hotel_reference'] ?? ('HOT-' . $id_reserva),
    'nombre_hospedaje'       => $reserva['nombre_hospedaje'],
    'nombre_establecimiento' => $reserva['nombre_establecimiento'] ?? '',
    'fecha'                  => $reserva['fecha'],
    'cantidad_personas'      => $reserva['cantidad_personas'],
    'precio_noche'           => $reserva['precio_noche'],
    'total'                  => $reserva['total'],
];

// Limpiar datos temporales
unset($_SESSION['hotel_reserva'], $_SESSION['hotel_reference']);

header('Location: ' . BASE_URL . 'hotel-confirmacion');
exit;
