<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/helpers/pdf_helper.php';
require_once BASE_PATH . '/app/models/administrador/proveedor.php';
require_once BASE_PATH . '/app/models/administrador/hotelero.php';
require_once BASE_PATH . '/app/models/administrador/turista.php';

function reportesPdfControlers()
{
    $tipo = strtolower(trim($_GET['tipo'] ?? ''));

    // Si no llega tipo, se muestra el modulo visual de reportes.
    if ($tipo === '') {
        require_once BASE_PATH . '/app/views/dashboard/administrador/reportes.php';
        return;
    }

    switch ($tipo) {
        case 'turistico':
        case 'proveedor':
        case 'proveedores':
            reporteProveedoresPdf();
            break;

        case 'hoteles':
        case 'hotelero':
        case 'hoteleros':
            reporteHotelesPdf();
            break;

        case 'turista':
        case 'turistas':
            reporteTuristasPdf();
            break;

        default:
            http_response_code(400);
            die('Error: Tipo de reporte no valido.');
    }
}

function reporteProveedoresPdf()
{
    $proveedorModel = new Proveedor();
    $proveedores = $proveedorModel->listar();

    ob_start();
    require_once BASE_PATH . '/app/views/pdf/proveedor_pdf.php';
    $html = ob_get_clean();

    generarPDF($html, 'reporte_proveedores.pdf', false);
}

function reporteHotelesPdf()
{
    $hoteleroModel = new Hotelero();
    $hoteles = $hoteleroModel->listar();

    ob_start();
    require_once BASE_PATH . '/app/views/pdf/hoteles_pdf.php';
    $html = ob_get_clean();

    generarPDF($html, 'reporte_hoteles.pdf', false);
}

function reporteTuristasPdf()
{
    $turistaModel = new Turista();
    $turistas = $turistaModel->listar();

    ob_start();
    require_once BASE_PATH . '/app/views/pdf/turista_pdf.php';
    $html = ob_get_clean();

    generarPDF($html, 'reporte_turistas.pdf', false);
}
