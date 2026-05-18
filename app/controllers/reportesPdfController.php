<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/helpers/pdf_helper.php';
require_once BASE_PATH . '/app/models/administrador/proveedor.php';
require_once BASE_PATH . '/app/models/administrador/hotelero.php';
require_once BASE_PATH . '/app/models/administrador/turista.php';

function reportesPdfControlers()
{
    $tipo = strtolower(trim($_GET['tipo'] ?? ''));
    $estado = strtolower(trim($_GET['estado'] ?? ''));
    $fechaDesde = trim($_GET['fecha_desde'] ?? '');
    $fechaHasta = trim($_GET['fecha_hasta'] ?? '');

    // Si no llega tipo, se muestra el modulo visual de reportes.
    if ($tipo === '') {
        require_once BASE_PATH . '/app/views/dashboard/administrador/reportes.php';
        return;
    }

    switch ($tipo) {
        case 'turistico':
        case 'proveedor':
        case 'proveedores':
            reporteProveedoresPdf($estado, $fechaDesde, $fechaHasta);
            break;

        case 'hoteles':
        case 'hotelero':
        case 'hoteleros':
            reporteHotelesPdf($estado, $fechaDesde, $fechaHasta);
            break;

        case 'turista':
        case 'turistas':
            reporteTuristasPdf($estado, $fechaDesde, $fechaHasta);
            break;

        default:
            http_response_code(400);
            die('Error: Tipo de reporte no valido.');
    }
}

function normalizarEstado($estado)
{
    $estado = strtolower(trim((string)$estado));
    if ($estado === 'todos' || $estado === 'all') {
        return '';
    }
    return $estado;
}

function normalizarFechaInicio($fecha)
{
    if ($fecha === '') {
        return null;
    }

    $timestamp = strtotime($fecha . ' 00:00:00');
    return $timestamp !== false ? $timestamp : null;
}

function normalizarFechaFin($fecha)
{
    if ($fecha === '') {
        return null;
    }

    $timestamp = strtotime($fecha . ' 23:59:59');
    return $timestamp !== false ? $timestamp : null;
}

function extraerFechaFila(array $fila)
{
    $keys = ['fecha_creacion', 'fecha_registro', 'created_at', 'fecha', 'fecha_alta'];

    foreach ($keys as $key) {
        if (!empty($fila[$key])) {
            $timestamp = strtotime((string)$fila[$key]);
            if ($timestamp !== false) {
                return $timestamp;
            }
        }
    }

    return null;
}

function filtrarRegistros(array $items, $estado, $fechaDesde, $fechaHasta)
{
    $estado = normalizarEstado($estado);
    $desdeTs = normalizarFechaInicio($fechaDesde);
    $hastaTs = normalizarFechaFin($fechaHasta);

    return array_values(array_filter($items, function ($fila) use ($estado, $desdeTs, $hastaTs) {
        $estadoFila = strtolower(trim((string)($fila['estado'] ?? '')));

        if ($estado !== '' && $estadoFila !== $estado) {
            return false;
        }

        if ($desdeTs !== null || $hastaTs !== null) {
            $fechaFila = extraerFechaFila($fila);

            if ($fechaFila === null) {
                return false;
            }
            if ($desdeTs !== null && $fechaFila < $desdeTs) {
                return false;
            }
            if ($hastaTs !== null && $fechaFila > $hastaTs) {
                return false;
            }
        }

        return true;
    }));
}

function reporteProveedoresPdf($estado = '', $fechaDesde = '', $fechaHasta = '')
{
    $proveedorModel = new Proveedor();
    $proveedores = $proveedorModel->listar();
    $proveedores = filtrarRegistros($proveedores, $estado, $fechaDesde, $fechaHasta);

    ob_start();
    require_once BASE_PATH . '/app/views/pdf/proveedor_pdf.php';
    $html = ob_get_clean();

    generarPDF($html, 'reporte_proveedores.pdf', false);
}

function reporteHotelesPdf($estado = '', $fechaDesde = '', $fechaHasta = '')
{
    $hoteleroModel = new Hotelero();
    $hoteles = $hoteleroModel->listar();
    $hoteles = filtrarRegistros($hoteles, $estado, $fechaDesde, $fechaHasta);

    ob_start();
    require_once BASE_PATH . '/app/views/pdf/hoteles_pdf.php';
    $html = ob_get_clean();

    generarPDF($html, 'reporte_hoteles.pdf', false);
}

function reporteTuristasPdf($estado = '', $fechaDesde = '', $fechaHasta = '')
{
    $turistaModel = new Turista();
    $turistas = $turistaModel->listar();
    $turistas = filtrarRegistros($turistas, $estado, $fechaDesde, $fechaHasta);

    ob_start();
    require_once BASE_PATH . '/app/views/pdf/turista_pdf.php';
    $html = ob_get_clean();

    generarPDF($html, 'reporte_turistas.pdf', false);
}
