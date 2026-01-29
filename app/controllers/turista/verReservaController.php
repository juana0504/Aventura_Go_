<?php
require_once __DIR__ . '/../../helpers/session_turista.php';
require_once __DIR__ . '/../../helpers/alert_helper.php';
require_once __DIR__ . '/../../models/turista/ReservaTurista.php';

// Inicializar modelo
$reservaModel = new ReservaTurista();
$id_turista = $_SESSION['user']['id'];

// Manejar acciones GET para cancelar reservas
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $accion = $_GET['accion'] ?? '';
    $id = $_GET['id'] ?? '';
    
    if ($accion === 'cancelar' && $id) {
        // Verificar seguridad: la reserva debe pertenecer al turista
        if ($reservaModel->verificarReservaDeTurista($id, $id_turista)) {
            if ($reservaModel->cancelarReserva($id, $id_turista)) {
                mostrarSweetAlert('info', 'Reserva cancelada correctamente', 'Su reserva ha sido cancelada. El proveedor será notificado.');
            } else {
                mostrarSweetAlert('error', 'Error al cancelar reserva', 'No se pudo cancelar la reserva. Por favor, intente nuevamente.');
            }
        } else {
            mostrarSweetAlert('error', 'Acceso denegado', 'No tiene permisos para modificar esta reserva');
        }
        header("Location: " . BASE_URL . "/turista/ver-reservas");
        exit;
    }
}

// Obtener filtro actual (por URL)
$filtro = $_GET['filtro'] ?? '';

// Listar reservas del turista actual
$reservas = $reservaModel->listarPorTurista($id_turista, $filtro);

// Obtener estadísticas para mostrar en la vista
$estadisticas = $reservaModel->obtenerEstadisticas($id_turista);

// Obtener actividades populares
$actividades_populares = $reservaModel->obtenerActividadesPopulares($id_turista);

// Obtener información del turista para mostrar en el reporte PDF
$nombre_turista = $_SESSION['user']['nombre'] ?? 'Turista';
$email_turista = $_SESSION['user']['email'] ?? '';

// Cargar la vista con los datos
require_once __DIR__ . '/../../views/dashboard/turista/ver_reservas.php';
?>