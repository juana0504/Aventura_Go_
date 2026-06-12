<?php
require_once __DIR__ . '/../../helpers/session_proveedor_hotelero.php';
require_once __DIR__ . '/../../helpers/alert_helper.php';
require_once __DIR__ . '/../../models/proveedor_hotelero/ReservaHotelero.php';
require_once __DIR__ . '/../../models/proveedor_hotelero/Proveedor_hotelero.php';

$reservaModel          = new ReservaHotelero();
$id_proveedor_hotelero = (new Proveedor())->obtenerIdProveedorPorUsuario($_SESSION['user']['id_usuario']);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $accion = $_GET['accion'] ?? '';
    $id     = $_GET['id'] ?? '';

    if ($accion === 'confirmar' && $id) {
        if ($reservaModel->verificarReservaDeProveedor($id, $id_proveedor_hotelero)) {
            if ($reservaModel->confirmarReserva($id)) {
                mostrarSweetAlert('success', 'Reserva confirmada', 'La reserva ha sido marcada como confirmada');
            } else {
                mostrarSweetAlert('error', 'Error', 'No se pudo confirmar la reserva');
            }
        } else {
            mostrarSweetAlert('error', 'Acceso denegado', 'Esta reserva no pertenece a su establecimiento');
        }
        header('Location: ' . BASE_URL . 'proveedor_hotelero/consultar-reservas');
        exit;
    }

    if ($accion === 'cancelar' && $id) {
        if ($reservaModel->verificarReservaDeProveedor($id, $id_proveedor_hotelero)) {
            if ($reservaModel->cancelarReserva($id)) {
                mostrarSweetAlert('info', 'Reserva cancelada', 'La reserva ha sido cancelada');
            } else {
                mostrarSweetAlert('error', 'Error', 'No se pudo cancelar la reserva');
            }
        } else {
            mostrarSweetAlert('error', 'Acceso denegado', 'Esta reserva no pertenece a su establecimiento');
        }
        header('Location: ' . BASE_URL . 'proveedor_hotelero/consultar-reservas');
        exit;
    }
}

$filtro       = $_GET['filtro'] ?? '';
$reservas     = $id_proveedor_hotelero ? $reservaModel->listarPorProveedor($id_proveedor_hotelero, $filtro) : [];
$estadisticas = $id_proveedor_hotelero ? $reservaModel->obtenerEstadisticas($id_proveedor_hotelero) : [];

require_once __DIR__ . '/../../views/dashboard/proveedor_hotelero/consultar_reservas.php';
