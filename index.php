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
        require BASE_PATH . '/app/views/website/index.html';
        break;
        // inicio rutas que sean necesarias para el login
    case '/login':
        require BASE_PATH . '/app/views/auth/login.php';
        break;
    case '/iniciar-sesion':
        require BASE_PATH . '/app/controllers/loginController.php';
        break;
        // Fin ruta login

    //inicio rutas de Administrador
    case '/administrador/dashboard':
        require BASE_PATH . '/app/views/dashboard/administrador/administrador.php';
        break;
    case '/administrador/registrar-proveedores':
        require BASE_PATH . '/app/views/dashboard/administrador/registrar_proveedor.php';
        break;
    case '/administrador/tabla':
        require BASE_PATH . '/app/views/dashboard/administrador/tabla.php';
        break;

    default:
        require BASE_PATH . '/app/views/auth/error404.html';
    break;

}
?>