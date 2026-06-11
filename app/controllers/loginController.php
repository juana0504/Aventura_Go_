<?php
//impotamos las dependencias
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/login.php';


// $clave = '0704';
// echo password_hash($clave, PASSWORD_DEFAULT);

//ejeciutar segun la solicitud al servisor "POST"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //capturamos en variables los valores enviados a travez de los name del formulario y el method POST
    $correo = $_POST['email'] ?? '';
    $clave = $_POST['contrasena'] ?? '';

    //validamos que los campos/variables no esten vacios
    if (empty($correo) || empty($clave)) {
        mostrarSweetAlert('error', 'Campos vacios', 'Por favor completar todos los campos');
        exit();
    }
    //POO -INSTANCIAMOS LA CLASE DEL MODELO, PARA ACCEDER A UN METHOD (FUNCION) EN ESPECIFICO
    $login = new login();
    $resultado = $login->autenticar($correo, $clave);

    //verificar si el modelo devolvio un error
    if (isset($resultado['error'])) {
        mostrarSweetAlert('error', 'Error de autenticacion', $resultado['error']);
        exit();
    }

    //si pasa esta linea el ususario es valido
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['user'] = [
        'id_usuario' => $resultado['id_usuario'],
        'nombre' => $resultado['nombre'],
        'rol' => $resultado['rol'],
        'foto' => $resultado['foto'] ?? 'default.png'
    ];

    // Redirección segun el rol 
    $redirectUrl = BASE_URL . 'login';
    $mensaje = 'Rol inexistente. Redirigiendo al inicio de sesión...';
    $bgVideo = null; // video de fondo por defecto (ninguno)

    // 🔥 PRIORIDAD: si existe redirección pendiente
    if (!empty($_SESSION['redirect_after_login'])) {
        $redirectUrl = $_SESSION['redirect_after_login'];
        unset($_SESSION['redirect_after_login']);
        mostrarSweetAlert('success', 'Ingreso exitoso', 'Continuando proceso...', $redirectUrl);
        exit();
    }


    switch ($resultado['rol']) {
        case 'administrador':
            $redirectUrl = BASE_URL . 'administrador/dashboard';
            $mensaje = 'Bienvenido Administrador.';
            $bgVideo = BASE_URL . 'public/assets/video/roles/bg_administrador.mp4';
            break;
        case 'proveedor':
            $redirectUrl = BASE_URL . 'proveedor/dashboard';
            $mensaje = 'Bienvenido Proveedor Turistico.';
            $bgVideo = BASE_URL . 'public/assets/video/roles/bg_proveedor.mp4';
            break;
        case 'proveedor_hotelero':
            $redirectUrl = BASE_URL . 'proveedor_hotelero/dashboard';
            $mensaje = 'Bienvenido Proveedor Hotelero.';
            $bgVideo = BASE_URL . 'public/assets/video/roles/bg_proveedor_hotelero.mp4';
            break;
        case 'turista':
            $redirectUrl = BASE_URL;
            $mensaje = 'Bienvenido Turista.';
            $bgVideo = BASE_URL . 'public/assets/video/roles/bg_turista.mp4';
            break;

        default:
            # code...
            break;
    }

    mostrarSweetAlert('success', 'Ingreso exitoso', $mensaje, $redirectUrl, $bgVideo);
    exit();
} else {
    http_response_code(405);
    echo "Metodo no permitido";
    exit();
}