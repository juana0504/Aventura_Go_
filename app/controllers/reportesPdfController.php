<?php
// Al principio de tu archivo de controlador de reportes, añade esto:
require_once BASE_PATH . '/app/controllers/turista/reservas.php'; // Ajusta la ruta a donde tengas la función listarReservas
require_once BASE_PATH . '/app/helpers/pdf_helper.php';
require_once BASE_PATH . '/app/controllers/administrador/proveedor.php';
require_once BASE_PATH . '/app/controllers/administrador/hotelero.php';
require_once BASE_PATH . '/app/controllers/administrador/turista.php';
require_once BASE_PATH . '/app/controllers/turista/verReservaPdfController.php';


function reportesPdfControlers()
{
    // Usamos el operador null coalescing ?? para evitar error si 'tipo' no existe
    $tipo = $_GET['tipo'] ?? ''; 

    switch ($tipo) {
        case 'turista_reservas': // Nuevo caso
            reporteMisReservasPdf();
            break;
        case 'turista':
            reporteTuristasPdf();
            break;
            $tipo = $_GET['tipo'] ?? '';
        if ($tipo === 'turista_reservas') {
            generarPdfReservasTurista();
    }
        default:
            die("Error: Tipo de reporte no especificado o no válido.");
            break;
    }
}

function reporteMisReservasPdf()
{
    // 1. Validar sesión
    if (!isset($_SESSION['user']['id_usuario'])) {
        die("Error: No has iniciado sesión.");
    }

    $id_usuario = $_SESSION['user']['id_usuario'];

    // 2. IMPORTANTE: Asegúrate de que esta función exista en 
    // app/controllers/turista/reservas.php. 
    // Si en ese archivo la función se llama diferente (ej: obtenerReservas), cámbiala aquí.
    if (function_exists('listarReservasPorUsuario')) {
        $reservas = listarReservasPorUsuario($id_usuario);
    } else {
        // Esto te dirá exactamente si el error es que la función no existe
        die("Error crítico: La función 'listarReservasPorUsuario' no se encuentra. Verifica el archivo reservas.php");
    }

    // 3. Generar el buffer
    ob_start();
    
    // Pasamos el BASE_URL para las imágenes en el PDF
    $reservas_data = $reservas; 

    // Cargar la vista diseñada
    require_once BASE_PATH . '/app/views/pdf/mis_reservas_pdf.php'; 
    
    $html = ob_get_clean();

    // 4. Llamar al helper para convertir a PDF
    generarPDF($html, 'Mis_Reservas_AventuraGO.pdf', false);
}

function reporteProveedoresPdf()
{

    // CARGAR LA VISTA Y OBTENERLACOMO HTML
    ob_start();

    // ASIGNAMOS LOS DATOS DE LA FUNCION EN EL CONTROLADOR ENLAZADO A UNA VARIABLE QUE PODAMOS MANIPULAR EN LA VISTA DEL PDF
    $proveedores = listarProveedores();

    // ARCHIVO QUE TIENE LA INTERFAZ DISEÑANDA EN HTML
    require_once BASE_PATH . '/app/views/pdf/proveedor_pdf.php';
    $html = ob_get_clean();

    generarPDF($html, 'reporte_proveedores.pdf', false);
}

function reporteHotelesPdf()
{

    // CARGAR LA VISTA Y OBTENERLACOMO HTML
    ob_start();

    // ASIGNAMOS LOS DATOS DE LA FUNCION EN EL CONTROLADOR ENLAZADO A UNA VARIABLE QUE PODAMOS MANIPULAR EN LA VISTA DEL PDF
    $hoteles = listarHoteles();

    // ARCHIVO QUE TIENE LA INTERFAZ DISEÑANDA EN HTML
    require_once BASE_PATH . '/app/views/pdf/hoteles_pdf.php';
    $html = ob_get_clean();

    generarPDF($html, 'reporte_proveedores.pdf', false);
}

function reporteTuristasPdf()
{

    // CARGAR LA VISTA Y OBTENERLACOMO HTML
    ob_start();

    // ASIGNAMOS LOS DATOS DE LA FUNCION EN EL CONTROLADOR ENLAZADO A UNA VARIABLE QUE PODAMOS MANIPULAR EN LA VISTA DEL PDF
    $turistas = listarTuristas();

    // ARCHIVO QUE TIENE LA INTERFAZ DISEÑANDA EN HTML
    require_once BASE_PATH . '/app/views/pdf/turista_pdf.php';
    $html = ob_get_clean();

    generarPDF($html, 'reporte_turistas.pdf', false);
}
