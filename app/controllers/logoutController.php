<?php
// 1. Cargamos el helper que tiene la función del diseño
require_once __DIR__ . '/../helpers/alert_helper.php';

// 2. Iniciamos sesión para poder destruirla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. Vaciamos el array de sesión
$_SESSION = [];     

// 4. Borramos la cookie del navegador (Seguridad extra)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// 5. Destruimos la sesión en el servidor
session_destroy();

// 6. Lanzamos la vista con el video y la alerta
// El orden de los parámetros es: Tipo, Título, Mensaje, Redirección, Video
mostrarSweetAlert(
    'success', 
    'Sesión cerrada', 
    'Has cerrado sesión correctamente. ¡Vuelve pronto!.', 
    '/aventura_go/', 
    BASE_URL . '/public/assets/video/roles/logout_bg.mp4'  // ← misma carpeta y usando BASE_URL
);

exit();