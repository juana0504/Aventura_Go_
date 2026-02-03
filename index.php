<?php
//index.php - Router principal en larabel se tiene un archivo por cada carpeta de views

require_once __DIR__ . '/config/config.php';

$requestUri = $_SERVER['REQUEST_URI']; //OBTENER LA URI ACTUAL (por ejemplo: aventura_go/login)

$request = str_replace('/aventura_go', '', $requestUri); //Quitar el prefijo de la carpeta del proyecto

$request = strtok($request, '?'); //Quitar parametros tipo ?id=123

$request = rtrim($request, '/'); //Quitar la barra final (si existe)

if ($request === '') $request = '/'; //si la ruta queda vacia, se interpreta como "/"

//ENRUTAMIENTO BASICO
switch ($request) {

    // ===================================================================================================
    //                                            RUTAS LOGIN
    // ===================================================================================================
    case '/login':
        require BASE_PATH . '/app/views/auth/login.php'; //redirige a el login 
        break;
    case '/registrarse':
        require BASE_PATH . '/app/views/auth/registrarse.php'; //redirige a el login 
        break;
    case '/iniciar-sesion':
        require_once BASE_PATH . '/app/controllers/loginController.php'; //redirige al inicio de sesion
        break;
    case '/generar-clave':
        require_once BASE_PATH . '/app/controllers/password.php'; //redirige al inicio de sesion
        break;
    case '/recoverpw':
        require BASE_PATH . '/app/views/auth/resetPassword.php';  //redirige al guardar proveedor
        break;

    case '/logout':
        require_once BASE_PATH . '/app/controllers/logoutController.php';
        break;
    //fin rutas login


    // ===================================================================================================
    //                                   RUTAS DASBOARD ADMINISTRADOR
    // ===================================================================================================
    case '/administrador/dashboard':
        require BASE_PATH . '/app/views/dashboard/administrador/administrador.php';  //redirige al panel de administrador
        break;

    // Perfil administrador 
    case '/administrador/cambiar-password':
        require_once BASE_PATH . '/app/controllers/passwordChangeController.php';
        $controller = new PasswordChangeController();
        $controller->cambiarClave();
        break;

    // Registrar y consultar el Proveedor Turistico
    // CRUD del Proveedor Turistico
    case '/administrador/registrar-proveedor':
        require BASE_PATH . '/app/views/dashboard/administrador/registrar_proveedor_turistico.php';  //redirige al perfil de usuario de administrador
        break;
    case '/administrador/consultar-proveedor':
        require BASE_PATH . '/app/views/dashboard/administrador/consultar_proveedor_turistico.php';  //redirige al perfil de usuario de administrador
        break;
    case '/administrador/guardar-proveedor':
        require_once BASE_PATH . '/app/controllers/administrador/proveedor.php';  //redirige al guardar proveedor
        break;
    case '/administrador/editar-proveedor':
        require BASE_PATH . '/app/views/dashboard/administrador/editar_proveedor_turistico.php';  //redirige al guardar proveedor
        break;
    case '/administrador/actualizar-proveedor':
        require_once BASE_PATH . '/app/controllers/administrador/proveedor.php';  //redirige al actualizar el proveedor
        break;
    case '/administrador/eliminar-proveedor':
        require_once BASE_PATH . '/app/controllers/administrador/proveedor.php';  //elimina el proveedor
        break;
    case '/administrador/reporte':
        require_once BASE_PATH . '/app/controllers/reportesPdfController.php';  //elimina el proveedor
        reportesPdfControlers();
        break;
    case '/administrador/consultar-proveedor-id':
        require_once BASE_PATH . '/app/controllers/administrador/proveedor.php';
        consultarProveedorOjo(); // Llama a la función que devuelve JSON
        break;
    case '/administrador/cambiar-estado-proveedor':
        require_once BASE_PATH . '/app/controllers/administrador/proveedor.php';
        break;

    //Fin de Registrar y consultar el Proveedor Turistico

    //CRUD DE PROVEEDOR HOTELERO
    // Registrar y consultar el Proveedor Hotelero
    case '/administrador/registrar-proveedor-hotelero':
        require BASE_PATH . '/app/views/dashboard/administrador/registrar_proveedor_hotelero.php';  //redirige al perfil de usuario de administrador
        break;

    case '/administrador/consultar-proveedor-hotelero':
        require BASE_PATH . '/app/views/dashboard/administrador/consultar_proveedor_hotelero.php';  //redirige al perfil de usuario de administrador
        break;

    case '/administrador/consultar-proveedor-hotelero-id':
        require_once BASE_PATH . '/app/controllers/administrador/hotelero.php';
        consultarProveedorHoteleroOjo();
        break;

    case '/administrador/cambiar-estado-proveedor-hotelero':
        require_once BASE_PATH . '/app/controllers/administrador/hotelero.php';
        break;


    // CRUD del Proveedor Hotelero
    case '/administrador/guardar-proveedor-hotelero':
        require_once BASE_PATH . '/app/controllers/administrador/hotelero.php';  //redirige al guardar proveedor
        break;
    case '/administrador/editar-proveedor-hotelero':
        require BASE_PATH . '/app/views/dashboard/administrador/editar_proveedor_hotelero.php';  //redirige al guardar proveedor
        break;
    case '/administrador/actualizar-proveedor-hotelero':
        require_once BASE_PATH . '/app/controllers/administrador/hotelero.php';  //redirige al actualizar el proveedor
        break;
    case '/administrador/eliminar-proveedor-hotelero':
        require_once BASE_PATH . '/app/controllers/administrador/hotelero.php';  //elimina el proveedor
        break;
    //Fin de Registrar y consultar el Proveedor Hotelero


    // Registrar y consultar el Turista
    case '/administrador/registrar-turista':
        require BASE_PATH . '/app/views/dashboard/administrador/registrar_proveedor_turistico.php';  //redirige al perfil de usuario de administrador
        break;
    case '/administrador/consultar-turista':
        require BASE_PATH . '/app/views/dashboard/administrador/consultar_turista.php';  //redirige al perfil de usuario de administrador
        break;

    // CRUD del Turista
    case '/administrador/guardar-turista':
        require_once BASE_PATH . '/app/controllers/administrador/turista.php';  //redirige al guardar turista
        break;
    case '/administrador/editar-turista':
        require BASE_PATH . '/app/views/dashboard/administrador/editar_turista.php';  //redirige al guardar turista
        break;
    case '/administrador/actualizar-turista':
        require_once BASE_PATH . '/app/controllers/administrador/turista.php';  //redirige al actualizar el turista
        break;
    case '/administrador/eliminar-turista':
        require_once BASE_PATH . '/app/controllers/administrador/turista.php';  //elimina el turista
        break;
    case '/administrador/reporte-turista':
        require_once BASE_PATH . '/app/controllers/reportesPdfController.php';  //pdf del el turista
        reportesPdfControlers();
        break;
    //Fin de Registrar y consultar el Turista


    // Perfil del Administrador 
    case '/administrador/perfil':
        require BASE_PATH . '/app/views/dashboard/administrador/perfil_usuario.php';  //redirige al perfil del administradors
        break;

    case '/administrador/actualizar-perfil':
        require_once BASE_PATH . '/app/controllers/administrador/editarPerfilAdmin.php';
        break;



    // ===== TICKETS ADMIN =====
    case '/administrador/tickets':
        require_once BASE_PATH . '/app/controllers/administrador/TicketAdminController.php';
        $controller = new TicketAdminController();
        $controller->listar();
        break;

    case '/administrador/tickets/responder':
        require_once BASE_PATH . '/app/controllers/administrador/TicketAdminController.php';
        $controller = new TicketAdminController();
        $controller->responderForm($_GET['id'] ?? null);
        break;

    case '/administrador/tickets/guardar-respuesta':
        require_once BASE_PATH . '/app/controllers/administrador/TicketAdminController.php';
        $controller = new TicketAdminController();
        $controller->responder();
        break;

    case '/administrador/consultar-tickets':
        require BASE_PATH . '/app/views/dashboard/administrador/consultar_tickets.php'; //consultar tiquets enviados por el usuario
        break;
    //fin rutas administrador



    // ===================================================================================================
    //                                     RUTAS PROVEEDOR TURISTICO
    // ===================================================================================================

    case '/proveedor/dashboard':
        require BASE_PATH . '/app/views/dashboard/proveedor_turistico/dashboard.php';
        break;

    case '/proveedor/registrar-actividad':
        require BASE_PATH . '/app/views/dashboard/proveedor_turistico/registrar_actividad_turistica.php';
        break;

    case '/proveedor/guardar-actividad':
        require_once BASE_PATH . '/app/controllers/proveedor_turistico/actividadTuristica.php';  //redirige al guardar actividad turisitica
        break;

    case '/proveedor/consultar-actividad':
        require BASE_PATH . '/app/views/dashboard/proveedor_turistico/consultar_actividad_turistica.php'; //consulta la tabla con las actividades turisticas registradas
        break;

    case '/proveedor/pdf-actividades':
        require_once BASE_PATH . '/app/controllers/proveedor_turistico/actividadPdfController.php';
        generarPdfActividades();
        break;


    case '/proveedor/editar-actividad':
        require BASE_PATH . '/app/views/dashboard/proveedor_turistico/editar_actividad_turistica.php'; //editar la actividad turisitica 
        break;
    case '/proveedor/actualizar-actividad':
        require_once BASE_PATH . '/app/controllers/proveedor_turistico/actividadTuristica.php';  //elimina el proveedor
        break;

    case '/proveedor/eliminar-actividad':
        require_once BASE_PATH . '/app/controllers/proveedor_turistico/actividadTuristica.php';  //elimina el proveedor
        break;

    case '/proveedor/consultar-reservas':
        require_once BASE_PATH . '/app/controllers/proveedor_turistico/reservaController.php';
        break;

    case '/proveedor/reserva-detalle':
        require_once BASE_PATH . '/app/controllers/proveedor_turistico/reservaDetalle.php';
        break;

    case '/proveedor/pdf-reservas':
        require_once BASE_PATH . '/app/controllers/proveedor_turistico/reservaPdfController.php';
        generarPdfReservas();
        break;

    case '/proveedor/crear-ticket':
        require BASE_PATH . '/app/views/dashboard/proveedor_turistico/crear_ticket.php'; //crear los tiquets
        break;




    // Perfil del proveedor turistico 
    case '/proveedor/perfil':
        require BASE_PATH . '/app/views/dashboard/proveedor_turistico/perfil_usuario.php';  //redirige al perfil del proveedor turisitico
        break;

    case '/proveedor/actualizar-perfil':
        require_once BASE_PATH . '/app/controllers/proveedor_turistico/editarPerfilProveedor.php';
        break;





    case '/proveedor_turistico/listar':
        require_once BASE_PATH . '/app/controllers/proveedor_turistico/TicketProveedorController.php';
        $controller = new TicketProveedorController();
        $controller->listar();
        break;

    case '/proveedor_turistico/crear_ticket':
        require_once BASE_PATH . '/app/controllers/proveedor_turistico/TicketProveedorController.php';
        $controller = new TicketProveedorController();
        $controller->crear();
        break;

    case '/proveedor_turistico/guardar_ticket':
        require_once BASE_PATH . '/app/controllers/proveedor_turistico/TicketProveedorController.php';
        $controller = new TicketProveedorController();
        $controller->guardar();
        break;

    case '/proveedor/tickets':
        require_once BASE_PATH . '/app/controllers/proveedor_turistico/TicketProveedorController.php';
        $controller = new TicketProveedorController();
        $controller->listar();
        break;

    case '/proveedor_turistico/ticket/ver':
        require BASE_PATH . '/app/controllers/proveedor_turistico/TicketProveedorController.php';
        $controller = new TicketProveedorController();
        $controller->ver($_GET['id'] ?? null);
        break;
    // ================= FIN RUTAS PROVEEDOR TURISTICO =================




    // ===================================================================================================
    //                                      RUTAS TURISTA (USUARIO)
    // ===================================================================================================

    // PAGINAS PUBLICAS
    // INICIO
    case '/':
        require BASE_PATH . '/app/views/website/index.php';
        break;

    // Ruta: /destacados
    case '/destacados':
        require BASE_PATH . '/app/views/website/toursDestacados.php';
        break;

    // Ruta: /acerca-de-nosotros
    case '/acerca-de-nosotros':
        require BASE_PATH . '/app/views/website/acerca_de_nosotros.php';
        break;

    // Ruta: /contactanos
    case '/contactanos':
        require BASE_PATH . '/app/views/website/contactanos.php';
        break;

    // Ruta: descubre tours
    case '/descubre-tours':
        require BASE_PATH . '/app/views/website/descubre_tours.php';
        break;

    // Ruta: /tour escogido
    case '/tour-escogido':
        require BASE_PATH . '/app/views/website/tour_escogido.php';
        break;

    // Ruta: /formulario de reserva
    case '/formulario-reserva':
        require BASE_PATH . '/app/views/website/formulario_reserva.php';
        break;

    // ruta confirmar en formulario checkout
    case '/checkout':
        require_once 'app/views/website/checkout.php';
        break;




    // RUTAS DASHBOARD DE TURISTA
    case '/turista/dashboard':
        require BASE_PATH . '/app/views/dashboard/turista/dashboard.php';
        break;

    case '/turista/registrar-actividad':
        require BASE_PATH . '/app/views/dashboard/turista/registrar_reserva.php';
        break;

    case '/turista/ver-reservas':  //crud confirmar reserva 
        require_once BASE_PATH . '/app/controllers/turista/reservaController.php';
        (new ReservaController())->verReservas();
        break;

    case '/turista/seleccionar-actividad':
        require_once BASE_PATH . '/app/controllers/website/websiteController.php';
        break;

    // PDF
    case '/turista/pdf-reservas':
        require_once BASE_PATH . '/app/controllers/turista/verReservaPdfController.php';
        generarPdfReservasTurista();
        break;


    // RUTAS DASHBOARD PERFIL DE TURISTA__________ 
    case '/turista/perfil':
        require BASE_PATH . '/app/views/dashboard/turista/perfil_usuario.php';  //redirige al perfil del turista
        break;

    case '/turista/actualizar-perfil':
        require_once BASE_PATH . '/app/controllers/turista/editarPerfilTurista.php';
        break;

    // Perfil proveedor 
    case '/turista/cambiar-password':
        require BASE_PATH . '/app/controllers/passwordChangeController.php';
        $controller = new PasswordChangeController();
        $controller->cambiarClave();
        break;


    // RUTA DASHBOARD TICKETS DE TURISTA________________________________
    case '/turista/tickets':
        require_once BASE_PATH . '/app/controllers/turista/TicketTuristaController.php';
        $controller = new TicketTuristaController();
        $controller->listar();
        break;

    case '/turista/crear_ticket':
        require_once BASE_PATH . '/app/controllers/turista/TicketTuristaController.php';
        $controller = new TicketTuristaController();
        $controller->crear();
        break;

    case '/turista/guardar_ticket':
        require_once BASE_PATH . '/app/controllers/turista/TicketTuristaController.php';
        $controller = new TicketTuristaController();
        $controller->guardar();
        break;







    // RUTA EN TURISTA PARA SELECCIONAR HOSPEDAJE
    // Ruta: descubre hospedaje
    case '/descubre-hospedaje':
        require BASE_PATH . '/app/views/website/descubre_hospedaje.php';
        break;

    // ===================================================================================================
    //                                      RUTAS PROVEEDOR HOTELERO
    // ===================================================================================================

    // ACA VAN LAS RUTAS DEL PORVEEDOR HOTELERO ....



    // ===================================================================================================
    //                                    pagina ERROR 404
    // ===================================================================================================
    default:
        require BASE_PATH . '/app/views/auth/error404.php';
        break;
}
