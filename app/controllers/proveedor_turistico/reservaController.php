<?php
require_once __DIR__ . '/../../helpers/session_proveedor.php';
require_once __DIR__ . '/../../helpers/alert_helper.php';
require_once __DIR__ . '/../../models/proveedor_turistico/Reserva.php';

// Inicializar modelo
$reservaModel = new Reserva();
$id_proveedor = $_SESSION['id_proveedor'] ?? null;


// Manejar acciones GET para confirmar/cancelar reservas
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $accion = $_GET['accion'] ?? '';
    $id = $_GET['id'] ?? '';

    if ($accion === 'confirmar' && $id) {
        // Verificar seguridad: la reserva debe pertenecer al proveedor
        if ($reservaModel->verificarReservaDeProveedor($id, $id_proveedor)) {
            if ($reservaModel->confirmarReserva($id)) {
                mostrarSweetAlert('success', 'Reserva confirmada correctamente', 'La reserva ha sido marcada como confirmada');
            } else {
                mostrarSweetAlert('error', 'Error al confirmar reserva', 'No se pudo actualizar el estado de la reserva');
            }
        } else {
            mostrarSweetAlert('error', 'Acceso denegado', 'No tiene permisos para modificar esta reserva');
        }
        header("Location: " . BASE_URL . "/proveedor/consultar-reservas");
        exit;
    }

    if ($accion === 'cancelar' && $id) {
        // Verificar seguridad: la reserva debe pertenecer al proveedor
        if ($reservaModel->verificarReservaDeProveedor($id, $id_proveedor)) {
            if ($reservaModel->cancelarReserva($id)) {
                mostrarSweetAlert('info', 'Reserva cancelada correctamente', 'La reserva ha sido marcada como cancelada');
            } else {
                mostrarSweetAlert('error', 'Error al cancelar reserva', 'No se pudo actualizar el estado de la reserva');
            }
        } else {
            mostrarSweetAlert('error', 'Acceso denegado', 'No tiene permisos para modificar esta reserva');
        }
        header("Location: " . BASE_URL . "/proveedor/consultar-reservas");
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
