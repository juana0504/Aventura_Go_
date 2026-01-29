<?php

require_once BASE_PATH . '/app/helpers/session_proveedor.php';
require_once BASE_PATH . '/app/helpers/pdf_helper.php';
require_once BASE_PATH . '/app/models/proveedor_turistico/ActividadTuristica.php';

function generarPdfActividades()
{
    ob_start();

    $actividadModel = new ActividadTuristica();
    $actividades = $actividadModel->listarTodas();

    require_once BASE_PATH . '/app/views/pdf/actividades_turisticas_pdf.php';

    $html = ob_get_clean();

    generarPDF($html, 'actividades_turisticas.pdf', false);
}
