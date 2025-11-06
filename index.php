<?php
//index.php - Router principal en larabel se tiene un archivo por cada carpeta de views

define('BASE_PATH', __DIR__);

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
    case '/administrador':
        require BASE_PATH . '/app/views/dashboard/administrador/administrador.html';
        break;

    case '/iniciarSesion':
        require BASE_PATH . '/app/controllers/loginController.php';
        break;
        // Fin ruta login
    default:
        require BASE_PATH . '/app/views/auth/error404.html';
    break;

}
?>