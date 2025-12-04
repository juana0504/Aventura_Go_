<?php
//index.php - Router principal en larabel se tiene un archivo por cada carpeta de views

require_once __DIR__ . '/config/config.php';

//OBTENER LA URI ACTUAL (por ejemplo: aventura_go/login)
$requestUri = $_SERVER['REQUEST_URI'];

//Quitar el prefijo de la carpeta del proyecto
$request = str_replace('/aventura_go', '', $requestUri);

//Quitar parametros tipo ?id=123
$request = strtok($request, '?');

//Quitar la barra final (si existe)
$request = rtrim($request, '/');

//si la ruta queda vacia, se interpreta como "/"
if ($request === '') $request = '/';

//enrutamiento basico
switch ($request) {
    case '/':
        require BASE_PATH . '/app/views/website/index.html'; //redirige a la pagina de inicio
        break;
    //inicio rutas login
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

    
    //fin rutas login


    //........................inicio rutas administrador
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
    case '/administrador/registrar-proveedor-turistico':
        require BASE_PATH . '/app/views/dashboard/administrador/registrar_proveedor_turistico.php';  //redirige al perfil de usuario de administrador
        break;
    case '/administrador/consultar-proveedor-turistico':
        require BASE_PATH . '/app/views/dashboard/administrador/consultar_proveedor_turistico.php';  //redirige al perfil de usuario de administrador
        break;

    // CRUD del Proveedor Turistico
    case '/administrador/guardar-proveedor':
        require BASE_PATH . '/app/controllers/proveedor.php';  //redirige al guardar proveedor
        break;
    case '/administrador/editar-proveedor':
        require BASE_PATH . '/app/views/dashboard/administrador/editar_proveedor_turistico.php';  //redirige al guardar proveedor
        break;
    case '/administrador/actualizar-proveedor-turistico':
        require BASE_PATH . '/app/controllers/proveedor.php';  //redirige al actualizar el proveedor
        break;
    case '/administrador/eliminar-proveedor':
        require BASE_PATH . '/app/controllers/proveedor.php';  //elimina el proveedor
        break;
    case '/administrador/reporte':
        require BASE_PATH . '/app/controllers/reportesPdfController.php';  //elimina el proveedor
        reportesPdfControlers();
        break;
    //Fin de Registrar y consultar el Proveedor Turistico

    // Registrar y consultar el Proveedor Hotelero
    case '/administrador/registrar-proveedor-hotelero':
        require BASE_PATH . '/app/views/dashboard/administrador/registrar_proveedor_hotelero.php';  //redirige al perfil de usuario de administrador
        break;
    case '/administrador/consultar-proveedor-hotelero':
        require BASE_PATH . '/app/views/dashboard/administrador/consultar_proveedor_hotelero.php';  //redirige al perfil de usuario de administrador
        break;
    // CRUD del Proveedor Hotelero
    case '/administrador/guardar-proveedor-hotelero':
        require BASE_PATH . '/app/controllers/hotelero.php';  //redirige al guardar proveedor
        break;
    case '/administrador/editar-proveedor-hotelero':
        require BASE_PATH . '/app/views/dashboard/administrador/editar_proveedor_hotelero.php';  //redirige al guardar proveedor
        break;
    case '/administrador/actualizar-proveedor-hotelero':
        require BASE_PATH . '/app/controllers/hotelero.php';  //redirige al actualizar el proveedor
        break;
    case '/administrador/eliminar-proveedor-hotelero':
        require BASE_PATH . '/app/controllers/hotelero.php';  //elimina el proveedor
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
        require BASE_PATH . '/app/controllers/turista.php';  //redirige al guardar turista
        break;
    case '/administrador/editar-turista':
        require BASE_PATH . '/app/views/dashboard/administrador/editar_turista.php';  //redirige al guardar turista
        break;
    case '/administrador/actualizar-turista':
        require BASE_PATH . '/app/controllers/turista.php';  //redirige al actualizar el turista
        break;
    case '/administrador/eliminar-turista':
        require BASE_PATH . '/app/controllers/turista.php';  //elimina el turista
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
        require BASE_PATH . '/app/controllers/editarPerfilAdmin.php';
        break;


    //fin rutas administrador
    case '/turista/tours':
        require BASE_PATH . '/app/views/dashboard/turista/descubre_tours.php';  //redirige al perfil de usuario de administrador
        break;


    default:
        require BASE_PATH . '/app/views/auth/error404.html';
        break;
}
