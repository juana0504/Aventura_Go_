<?php
require_once __DIR__ . '/../../helpers/session_proveedor.php';
require_once __DIR__ . '/../../helpers/alert_helper.php';
require_once __DIR__ . '/../../models/proveedor_turistico/Reserva.php';
require_once __DIR__ . '/../../models/proveedor_turistico/Proveedor.php';

// Obtener id_proveedor real desde la tabla proveedor
$reservaModel = new Reserva();
$id_proveedor = (new Proveedor())->obtenerIdProveedorPorUsuario($_SESSION['user']['id_usuario']);


// Manejar acciones GET para confirmar/cancelar reservas
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $accion     = $_GET['accion'] ?? '';
    $id         = $_GET['id'] ?? '';
    $urlVolver  = BASE_URL . 'proveedor/consultar-reservas';

    if ($accion === 'confirmar' && $id) {
        if ($reservaModel->verificarReservaDeProveedor($id, $id_proveedor)) {
            if ($reservaModel->confirmarReserva($id)) {
                mostrarSweetAlert('success', '¡Reserva confirmada!', 'La reserva fue marcada como confirmada exitosamente.', $urlVolver);
            } else {
                mostrarSweetAlert('error', 'Error al confirmar', 'No se pudo actualizar el estado de la reserva.', $urlVolver);
            }
        } else {
            mostrarSweetAlert('error', 'Acceso denegado', 'No tienes permisos para modificar esta reserva.', $urlVolver);
        }
        exit;
    }

    if ($accion === 'cancelar' && $id) {
        if ($reservaModel->verificarReservaDeProveedor($id, $id_proveedor)) {
            if ($reservaModel->cancelarReserva($id)) {
                mostrarSweetAlert('info', 'Reserva cancelada', 'La reserva fue cancelada y los cupos quedaron disponibles.', $urlVolver);
            } else {
                mostrarSweetAlert('error', 'Error al cancelar', 'No se pudo actualizar el estado de la reserva.', $urlVolver);
            }
        } else {
            mostrarSweetAlert('error', 'Acceso denegado', 'No tienes permisos para modificar esta reserva.', $urlVolver);
        }
        exit;
    }
}

// Obtener filtro actual (por URL)
$filtro = $_GET['filtro'] ?? '';

// Listar reservas del proveedor actual
$reservas = $reservaModel->listarPorProveedor($id_proveedor, $filtro);

// Obtener estadísticas para mostrar en la vista (opcional)
$estadisticas = $reservaModel->obtenerEstadisticas($id_proveedor);

// Cargar la vista con los datos
require_once __DIR__ . '/../../views/dashboard/proveedor_turistico/consultar_reservas.php';
