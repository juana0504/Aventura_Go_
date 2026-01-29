<?php
require_once __DIR__ . '/../../helpers/session_proveedor.php';
require_once __DIR__ . '/../../helpers/pdf_helper.php';
require_once __DIR__ . '/../../models/proveedor_turistico/Reserva.php';

/**
 * Función principal para generar PDF de reservas
 */
function generarPdfReservas() {
    // Verificar sesión activa
    if (!isset($_SESSION['id_proveedor'])) {
        die('Acceso denegado: no hay sesión de proveedor activa');
    }
    
    // Inicializar modelo y obtener datos
    $reservaModel = new Reserva();
    $id_proveedor = $_SESSION['id_proveedor'];
    $filtro = $_GET['filtro'] ?? 'all';
    
    // Obtener las reservas según el filtro
    $reservas = $reservaModel->listarParaPdf($id_proveedor, $filtro);
    
    // Obtener estadísticas adicionales
    $estadisticas = $reservaModel->obtenerEstadisticas($id_proveedor);
    
    // Capturar el HTML del reporte
    ob_start();
    
    // Pasar variables a la vista
    $reservas_pdf = $reservas;
    $estadisticas_pdf = $estadisticas;
    $filtro_actual = $filtro;
    
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
    // Verificar sesión y permisos
    if (!isset($_SESSION['id_proveedor'])) {
        die('Acceso denegado: no hay sesión de proveedor activa');
    }
    
    $reservaModel = new Reserva();
    $id_proveedor = $_SESSION['id_proveedor'];
    
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