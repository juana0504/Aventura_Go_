<?php
// index.php - Router principal

require_once __DIR__ . '/config/config.php';

$requestUri = $_SERVER['REQUEST_URI'];
$request = str_replace('/aventura_go', '', $requestUri);
$request = strtok($request, '?');
$request = rtrim($request, '/');

if ($request === '') {
    $request = '/';
}

switch ($request) {

    // =====================================================================
    // RUTAS WEBSITE / TURISTA
    // =====================================================================
    case '/':
        require BASE_PATH . '/app/views/website/index.php';
        break;

    case '/descubre-tours':
        require BASE_PATH . '/app/controllers/website/descubreToursController.php';
        break;

    case '/descubre-hospedaje':
        require BASE_PATH . '/app/views/website/descubre_hospedaje.php';
        break;

    case '/destacados':
        require BASE_PATH . '/app/views/website/toursDestacados.php';
        break;

    case '/acerca-de-nosotros':
        require BASE_PATH . '/app/views/website/acerca_de_nosotros.php';
        break;

    case '/contactanos':
        require BASE_PATH . '/app/views/website/contactanos.php';
        break;

    case '/turista/tours':
        require BASE_PATH . '/app/controllers/website/descubreToursController.php';
        break;

    // Imágenes
    case '/imagen/turistico':
        require_once BASE_PATH . '/app/controllers/ImagenController.php';
        ImagenController::turistico($_GET['file'] ?? '');
        break;

    // =====================================================================
    // AUTH
    // =====================================================================
    case '/login':
        require BASE_PATH . '/app/views/auth/login.php';
        break;

    case '/registrarse':
        require BASE_PATH . '/app/views/auth/registrarse.php';
        break;

    case '/iniciar-sesion':
        require BASE_PATH . '/app/controllers/loginController.php';
        break;

    case '/generar-clave':
        require BASE_PATH . '/app/controllers/password.php';
        break;

    case '/recoverpw':
        require BASE_PATH . '/app/views/auth/resetPassword.php';
        break;

    case '/logout':
        require BASE_PATH . '/app/controllers/logoutController.php';
        break;

    // =====================================================================
    // ADMINISTRADOR
    // =====================================================================
    case '/administrador/dashboard':
        require BASE_PATH . '/app/views/dashboard/administrador/administrador.php';
        break;

    case '/administrador/perfil':
        require BASE_PATH . '/app/views/dashboard/administrador/perfil_usuario.php';
        break;

    case '/administrador/actualizar-perfil':
        require BASE_PATH . '/app/controllers/administrador/editarPerfilAdmin.php';
        break;

    case '/administrador/cambiar-password':
        require BASE_PATH . '/app/controllers/passwordChangeController.php';
        $controller = new PasswordChangeController();
        $controller->cambiarClave();
        break;

    // Proveedor turístico
    case '/administrador/registrar-proveedor':
        require BASE_PATH . '/app/views/dashboard/administrador/registrar_proveedor_turistico.php';
        break;

    case '/administrador/consultar-proveedor':
        require BASE_PATH . '/app/views/dashboard/administrador/consultar_proveedor_turistico.php';
        break;

    case '/administrador/guardar-proveedor':
    case '/administrador/editar-proveedor':
    case '/administrador/actualizar-proveedor':
    case '/administrador/eliminar-proveedor':
    case '/administrador/cambiar-estado-proveedor':
    case '/administrador/consultar-proveedor-id':
        require BASE_PATH . '/app/controllers/administrador/proveedor.php';
        break;

    // Proveedor hotelero
    case '/administrador/registrar-proveedor-hotelero':
        require BASE_PATH . '/app/views/dashboard/administrador/registrar_proveedor_hotelero.php';
        break;

    case '/administrador/consultar-proveedor-hotelero':
        require BASE_PATH . '/app/views/dashboard/administrador/consultar_proveedor_hotelero.php';
        break;

    case '/administrador/guardar-proveedor-hotelero':
    case '/administrador/editar-proveedor-hotelero':
    case '/administrador/actualizar-proveedor-hotelero':
    case '/administrador/eliminar-proveedor-hotelero':
        require BASE_PATH . '/app/controllers/administrador/hotelero.php';
        break;

    // Turista
    case '/administrador/consultar-turista':
        require BASE_PATH . '/app/views/dashboard/administrador/consultar_turista.php';
        break;

    case '/administrador/guardar-turista':
    case '/administrador/editar-turista':
    case '/administrador/actualizar-turista':
    case '/administrador/eliminar-turista':
        require BASE_PATH . '/app/controllers/administrador/turista.php';
        break;

    // Reportes
    case '/administrador/reporte':
    case '/administrador/reporte-turista':
        require BASE_PATH . '/app/controllers/reportesPdfController.php';
        reportesPdfControlers();
        break;

    // Tickets
    case '/administrador/crear-ticket':
        require BASE_PATH . '/app/views/dashboard/administrador/crear_ticket.php';
        break;

    case '/administrador/guardar-ticket':
        require BASE_PATH . '/app/controllers/ticketController.php';
        $controller = new TicketController();
        $controller->guardar();
        break;

    case '/administrador/consultar-tickets':
        require BASE_PATH . '/app/views/dashboard/administrador/consultar_tickets.php';
        break;

    // =====================================================================
    // PROVEEDOR TURÍSTICO
    // =====================================================================
    case '/proveedor/dashboard':
        require BASE_PATH . '/app/views/dashboard/proveedor_turistico/dashboard.php';
        break;

    case '/proveedor/registrar-actividad':
        require BASE_PATH . '/app/views/dashboard/proveedor_turistico/registrar_actividad_turistica.php';
        break;

    case '/proveedor/guardar-actividad':
        require BASE_PATH . '/app/controllers/proveedor_turistico/actividadTuristica.php';
        break;

    case '/proveedor/consultar-actividad':
        require BASE_PATH . '/app/views/dashboard/proveedor_turistico/consultar_actividad_turistica.php';
        break;

    case '/proveedor/perfil':
        require BASE_PATH . '/app/views/dashboard/proveedor_turistico/perfil_usuario.php';
        break;

    case '/proveedor/actualizar-perfil':
        require BASE_PATH . '/app/controllers/proveedor_turistico/editarPerfilProveedor.php';
        break;

    // =====================================================================
    // 404
    // =====================================================================
    default:
        require BASE_PATH . '/app/views/auth/error404.html';
        break;
}
