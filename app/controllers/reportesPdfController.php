<?php

require_once BASE_PATH . '/app/helpers/pdf_helper.php';
require_once BASE_PATH . '/app/controllers/administrador/proveedor.php';
require_once BASE_PATH . '/app/controllers/administrador/hotelero.php';
require_once BASE_PATH . '/app/controllers/administrador/turista.php';


// ESTA FUNCION SE ENCARGA DE VALIDAR EL TIPO DE REPORTE Y EJECUTAR LA FUNCION CORRESPONDIENTE 
function reportesPdfControlers(){
    // CAPTURAMOS EL TIPO DE REPORTE ENVIADO DESDE LA VISTA 
    $tipo = $_GET['tipo'];
    // SEGUN EL TIPO DE REPORTE EJECUTAMOS X FUNCION 

    switch ($tipo) {
        case 'turistico':
            reporteProveedoresPdf();
            break;
        case 'hoteles':
            reporteHotelesPdf();
            break;
        case 'turista':
            reporteTuristasPdf();
            break;
        
        default:
            # code...
            break;
    }
}

function reporteProveedoresPdf(){

    // CARGAR LA VISTA Y OBTENERLACOMO HTML
    ob_start();

    // ASIGNAMOS LOS DATOS DE LA FUNCION EN EL CONTROLADOR ENLAZADO A UNA VARIABLE QUE PODAMOS MANIPULAR EN LA VISTA DEL PDF
    $proveedores = listarProveedores();

    // ARCHIVO QUE TIENE LA INTERFAZ DISEÑANDA EN HTML
    require_once BASE_PATH . '/app/views/pdf/proveedor_pdf.php';
    $html = ob_get_clean();

    generarPDF($html, 'reporte_proveedores.pdf', false);
}

function reporteHotelesPdf(){

    // CARGAR LA VISTA Y OBTENERLACOMO HTML
    ob_start();

    // ASIGNAMOS LOS DATOS DE LA FUNCION EN EL CONTROLADOR ENLAZADO A UNA VARIABLE QUE PODAMOS MANIPULAR EN LA VISTA DEL PDF
    $hoteles = listarHoteles();

    // ARCHIVO QUE TIENE LA INTERFAZ DISEÑANDA EN HTML
    require_once BASE_PATH . '/app/views/pdf/hoteles_pdf.php';
    $html = ob_get_clean();

    generarPDF($html, 'reporte_proveedores.pdf', false);
}

function reporteTuristasPdf(){

    // CARGAR LA VISTA Y OBTENERLACOMO HTML
    ob_start();

    // ASIGNAMOS LOS DATOS DE LA FUNCION EN EL CONTROLADOR ENLAZADO A UNA VARIABLE QUE PODAMOS MANIPULAR EN LA VISTA DEL PDF
    $turistas = listarTuristas();

    // ARCHIVO QUE TIENE LA INTERFAZ DISEÑANDA EN HTML
    require_once BASE_PATH . '/app/views/pdf/turista_pdf.php';
    $html = ob_get_clean();

    generarPDF($html, 'reporte_turistas.pdf', false);
}