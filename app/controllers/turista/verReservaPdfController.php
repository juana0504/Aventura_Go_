<?php
// Usar el helper de sesión directamente
require_once __DIR__ . '/../../helpers/session_turista.php';

// Definir BASE_URL si no está definida
if (!defined('BASE_URL')) {
    define('BASE_URL', '/aventura_go');
}

require_once __DIR__ . '/../../helpers/pdf_helper.php';
require_once __DIR__ . '/../../models/turista/ReservaTurista.php';

/**
 * Función principal para generar PDF de reservas del turista
 */
function generarPdfReservasTurista() {
    // La sesión ya está validada por session_turista.php
    
    // Inicializar modelo y obtener datos
    $reservaModel = new ReservaTurista();
    $id_turista = $_SESSION['user']['id'];
    $filtro = $_GET['filtro'] ?? 'all';
    
    // Obtener las reservas según el filtro
    $reservas = $reservaModel->listarParaPdf($id_turista, $filtro);
    
    // Obtener estadísticas adicionales
    $estadisticas = $reservaModel->obtenerEstadisticas($id_turista);
    
    // Obtener actividades populares
    $actividades_populares = $reservaModel->obtenerActividadesPopulares($id_turista);
    
    // Capturar el HTML del reporte
    ob_start();
    
    // Pasar variables a la vista
    $reservas_pdf = $reservas;
    $estadisticas_pdf = $estadisticas;
    $actividades_populares_pdf = $actividades_populares;
    $filtro_actual = $filtro;
    $nombre_turista = $_SESSION['user']['nombre'] ?? 'Turista';
    $email_turista = $_SESSION['user']['email'] ?? '';
    
    // Cargar la vista del PDF
    require_once BASE_PATH . '/app/views/pdf/reservas_turista_pdf.php';
    
    $html = ob_get_clean();
    
    // Establecer cabeceras para mantener sesión
    header('Cache-Control: private, no-cache, no-store, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    // Generar el PDF usando el helper
    try {
        // Nombre del archivo PDF
        $nombre_archivo = 'mis_reservas_' . date('Y-m-d_H-i-s') . '.pdf';
        
        // Generar PDF y mostrarlo en nueva pestaña (false) como el del proveedor
        generarPDF($html, $nombre_archivo, false);
        
    } catch (Exception $e) {
        error_log("Error al generar PDF de reservas turista: " . $e->getMessage());
        die('Error al generar el reporte PDF. Por favor, intente nuevamente.');
    }
}

/**
 * Función para generar PDF de reserva individual para el turista
 */
function generarPdfReservaIndividualTurista($id_reserva) {
    // Verificar sesión y permisos
    if (!isset($_SESSION['user']['id'])) {
        die('Acceso denegado: no hay sesión de turista activa');
    }
    
    $reservaModel = new ReservaTurista();
    $id_turista = $_SESSION['user']['id'];
    
    // Verificar que la reserva pertenezca al turista
    if (!$reservaModel->verificarReservaDeTurista($id_reserva, $id_turista)) {
        die('Acceso denegado: esta reserva no pertenece a su cuenta');
    }
    
    // Obtener detalles de la reserva específica
    $reserva = $reservaModel->listarPorId($id_reserva, $id_turista);
    
    if (!$reserva) {
        die('Reserva no encontrada');
    }
    
    // Capturar HTML para PDF individual
    ob_start();
    
    // Pasar variables a la vista individual
    $reserva_individual = $reserva;
    $nombre_turista = $_SESSION['user']['nombre'] ?? 'Turista';
    $email_turista = $_SESSION['user']['email'] ?? '';
    
    // Cargar vista específica para reserva individual
    require_once BASE_PATH . '/app/views/pdf/reserva_individual_turista_pdf.php';
    
    $html = ob_get_clean();
    
    // Generar PDF individual
    $nombre_archivo = 'reserva_' . $id_reserva . '_' . date('Y-m-d') . '.pdf';
    generarPDF($html, $nombre_archivo, false);
}

// Ejecutar la función principal
generarPdfReservasTurista();
?>