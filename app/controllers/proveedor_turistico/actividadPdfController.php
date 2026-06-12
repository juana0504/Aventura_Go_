<?php

require_once BASE_PATH . '/app/helpers/session_proveedor.php';
require_once BASE_PATH . '/app/helpers/pdf_helper.php';
require_once BASE_PATH . '/app/models/proveedor_turistico/actividadTuristica.php';

function generarPdfActividades()
{
    require_once BASE_PATH . '/app/models/proveedor_turistico/Proveedor.php';

    $proveedorModel = new Proveedor();
    $idUsuario      = $_SESSION['user']['id_usuario'];
    $idProveedor    = $proveedorModel->obtenerIdProveedorPorUsuario($idUsuario);

    ob_start();

    $actividadModel = new ActividadTuristica();
    $actividades    = $idProveedor ? $actividadModel->listarPorProveedor($idProveedor) : [];

    require_once BASE_PATH . '/app/views/pdf/actividades_turisticas_pdf.php';

    $html = ob_get_clean();

    generarPDF($html, 'actividades_turisticas.pdf', false);
}
