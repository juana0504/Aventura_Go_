<?php
require_once __DIR__ . '/../../helpers/session_proveedor_hotelero.php';
require_once __DIR__ . '/../../helpers/pdf_helper.php';
require_once __DIR__ . '/../../models/proveedor_hotelero/ReservaHotelero.php';
require_once __DIR__ . '/../../models/proveedor_hotelero/Proveedor_hotelero.php';

function generarPdfReservas()
{
    if (!isset($_SESSION['user'])) {
        die('Acceso denegado');
    }

    $id_proveedor_hotelero = (new Proveedor())->obtenerIdProveedorPorUsuario($_SESSION['user']['id_usuario']);
    $reservaModel          = new ReservaHotelero();
    $filtro                = $_GET['filtro'] ?? 'all';

    $reservas_pdf          = $reservaModel->listarParaPdf($id_proveedor_hotelero, $filtro);
    $estadisticas_pdf      = $reservaModel->obtenerEstadisticas($id_proveedor_hotelero);
    $filtro_actual         = $filtro;
    $nombre_proveedor      = $_SESSION['user']['nombre'] ?? '';

    ob_start();
    require_once BASE_PATH . '/app/views/pdf/reservas_hotelero_pdf.php';
    $html = ob_get_clean();

    try {
        generarPDF($html, 'reservas_hotelero_' . date('Y-m-d_H-i-s') . '.pdf', false);
    } catch (Exception $e) {
        error_log("Error PDF hotelero: " . $e->getMessage());
        die('Error al generar el reporte PDF.');
    }
}

generarPdfReservas();
