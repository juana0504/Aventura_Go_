<?php
require_once __DIR__ . '/../../helpers/session_proveedor.php';
require_once __DIR__ . '/../../helpers/pdf_helper.php';
require_once __DIR__ . '/../../models/proveedor_turistico/Reserva.php';
require_once __DIR__ . '/../../models/proveedor_turistico/Proveedor.php';

function generarPdfReservas() {
    if (!isset($_SESSION['user'])) {
        die('Acceso denegado: no hay sesión activa');
    }

    $reservaModel = new Reserva();
    $id_proveedor = (new Proveedor())->obtenerIdProveedorPorUsuario($_SESSION['user']['id_usuario']);
    $filtro = $_GET['filtro'] ?? 'all';

    $reservas_pdf     = $reservaModel->listarParaPdf($id_proveedor, $filtro);
    $estadisticas_pdf = $reservaModel->obtenerEstadisticas($id_proveedor);
    $filtro_actual    = $filtro;
    $nombre_proveedor = $_SESSION['user']['nombre'] ?? '';

    ob_start();
    
    // Cargar la vista del PDF con estilos de actividades
    require_once BASE_PATH . '/app/views/pdf/reservas_proveedor_pdf.php';
    
    $html = ob_get_clean();
    
    // Generar el PDF usando el helper
    try {
        // Nombre del archivo PDF
        $nombre_archivo = 'reporte_reservas_' . date('Y-m-d_H-i-s') . '.pdf';
        
        // Generar PDF y mostrarlo inline (false) o descargar (true)
        generarPDF($html, $nombre_archivo, false);
        
    } catch (Exception $e) {
        error_log("Error al generar PDF de reservas: " . $e->getMessage());
        die('Error al generar el reporte PDF. Por favor, intente nuevamente.');
    }
}

// Función para generar PDF de reserva individual (opcional)
function generarPdfReservaIndividual($id_reserva) {
    if (!isset($_SESSION['user'])) {
        die('Acceso denegado: no hay sesión activa');
    }

    $reservaModel = new Reserva();
    $id_proveedor = (new Proveedor())->obtenerIdProveedorPorUsuario($_SESSION['user']['id_usuario']);
    
    // Verificar que la reserva pertenezca al proveedor
    if (!$reservaModel->verificarReservaDeProveedor($id_reserva, $id_proveedor)) {
        die('Acceso denegado: esta reserva no pertenece a su empresa');
    }
    
    // Obtener detalles de la reserva específica
    $reserva = $reservaModel->listarPorId($id_reserva);
    
    if (!$reserva) {
        die('Reserva no encontrada');
    }
    
    // Capturar HTML para PDF individual
    ob_start();
    
    // Pasar variables a la vista individual
    $reserva_individual = $reserva;
    
    // Cargar vista específica para reserva individual (podría ser otra vista)
    require_once BASE_PATH . '/app/views/pdf/reserva_individual_pdf.php';
    
    $html = ob_get_clean();
    
    // Generar PDF individual
    $nombre_archivo = 'reserva_' . $id_reserva . '_' . date('Y-m-d') . '.pdf';
    generarPDF($html, $nombre_archivo, false);
}

// Ejecutar la función principal
generarPdfReservas();
?>