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
    //                                      RUTAS TURISTA (USUARIO)
    // ===================================================================================================
    case '/':
        require BASE_PATH . '/app/views/website/index.php';
        break;

    // Ruta: descubre tours
    case '/descubre-tours':
        require BASE_PATH . '/app/views/website/descubre_tours.php';
        break;

    // Ruta: descubre hospedaje
    case '/descubre-hospedaje':
        require BASE_PATH . '/app/views/website/descubre_hospedaje.php';
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
        require BASE_PATH . '/app/controllers/loginController.php'; //redirige al inicio de sesion
        break;
    case '/generar-clave':
        require BASE_PATH . '/app/controllers/password.php'; //redirige al inicio de sesion
        break;
    case '/recoverpw':
        require BASE_PATH . '/app/views/auth/resetPassword.php';  //redirige al guardar proveedor
        break;

    case '/logout':
        require BASE_PATH . '/app/controllers/logoutController.php';
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
        require BASE_PATH . '/app/controllers/passwordChangeController.php';
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
        require BASE_PATH . '/app/controllers/administrador/proveedor.php';  //redirige al guardar proveedor
        break;
    case '/administrador/editar-proveedor':
        require BASE_PATH . '/app/views/dashboard/administrador/editar_proveedor_turistico.php';  //redirige al guardar proveedor
        break;
    case '/administrador/actualizar-proveedor':
        require BASE_PATH . '/app/controllers/administrador/proveedor.php';  //redirige al actualizar el proveedor
        break;
    case '/administrador/eliminar-proveedor':
        require BASE_PATH . '/app/controllers/administrador/proveedor.php';  //elimina el proveedor
        break;
    case '/administrador/reporte':
        require BASE_PATH . '/app/controllers/reportesPdfController.php';  //elimina el proveedor
        reportesPdfControlers();
        break;
    case '/administrador/consultar-proveedor-id':
        require BASE_PATH . '/app/controllers/administrador/proveedor.php';
        consultarProveedorOjo(); // Llama a la función que devuelve JSON
        break;
    case '/administrador/cambiar-estado-proveedor':
        require BASE_PATH . '/app/controllers/administrador/proveedor.php';
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
    // CRUD del Proveedor Hotelero
    case '/administrador/guardar-proveedor-hotelero':
        require BASE_PATH . '/app/controllers/administrador/hotelero.php';  //redirige al guardar proveedor
        break;
    case '/administrador/editar-proveedor-hotelero':
        require BASE_PATH . '/app/views/dashboard/administrador/editar_proveedor_hotelero.php';  //redirige al guardar proveedor
        break;
    case '/administrador/actualizar-proveedor-hotelero':
        require BASE_PATH . '/app/controllers/administrador/hotelero.php';  //redirige al actualizar el proveedor
        break;
    case '/administrador/eliminar-proveedor-hotelero':
        require BASE_PATH . '/app/controllers/administrador/hotelero.php';  //elimina el proveedor
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
        require BASE_PATH . '/app/controllers/administrador/turista.php';  //redirige al guardar turista
        break;
    case '/administrador/editar-turista':
        require BASE_PATH . '/app/views/dashboard/administrador/editar_turista.php';  //redirige al guardar turista
        break;
    case '/administrador/actualizar-turista':
        require BASE_PATH . '/app/controllers/administrador/turista.php';  //redirige al actualizar el turista
        break;
    case '/administrador/eliminar-turista':
        require BASE_PATH . '/app/controllers/administrador/turista.php';  //elimina el turista
        break;
    case '/administrador/reporte-turista':
        require BASE_PATH . '/app/controllers/reportesPdfController.php';  //pdf del el turista
        reportesPdfControlers();
        break;
    //Fin de Registrar y consultar el Turista

    // Perfil del Administrador 
    case '/administrador/perfil':
        require BASE_PATH . '/app/views/dashboard/administrador/perfil_usuario.php';  //redirige al perfil del administradors
        break;

    case '/administrador/actualizar-perfil':
        require BASE_PATH . '/app/controllers/administrador/editarPerfilAdmin.php';
        break;


    //fin rutas administrador
    case '/turista/tours':
        require BASE_PATH . '/app/views/website/descubre_tours.php';  //redirige al perfil de usuario de administrador
        break;



    // ===================================================================================================
    //                                     RUTAS PROVEEDOR TURISTICO
    // ===================================================================================================

    case '/proveedor/dashboard':
        require BASE_PATH . '/app/views/dashboard/proveedor_turistico/dashboard.php';
        break;

    case '/proveedor/registrar-actividad':
        require BASE_PATH . '/app/views/dashboard/proveedor_turistico/registrar_actividad_turistica.php';
        break;

    case '/proveedor/consultar-actividad':
        require BASE_PATH . '/app/views/dashboard/proveedor_turistico/consultar_actividad_turistica.php';
        break;

    // Perfil del proveedor turistico 
    case '/proveedor/perfil':
        require BASE_PATH . '/app/views/dashboard/proveedor_turistico/perfil_usuario.php';  //redirige al perfil del proveedor turisitico
        break;

    case '/proveedor/actualizar-perfil':
        require BASE_PATH . '/app/controllers/proveedor_turistico/editarPerfilProveedor.php';
        break;
    // ================= FIN RUTAS PROVEEDOR TURISTICO =================




    // ===================================================================================================
    //                                      RUTAS PROVEEDOR HOTELERO
    // ===================================================================================================








    default:
        require BASE_PATH . '/app/views/auth/error404.html';
        break;
}
