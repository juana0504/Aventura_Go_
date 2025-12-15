<?php
//impotamos las dependencias
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/login.php';


// $clave = '0704';
// echo password_hash($clave, PASSWORD_DEFAULT);

//ejeciutar segun la solicitud al servisor "POST"
if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    //capturamos en variables los valores enviados a travez de los name del formulario y el method POST
    $correo = $_POST['email'] ?? '';
    $clave = $_POST['contrasena'] ?? '';

    //validamos que los campos/variables no esten vacios
    if (empty($correo) || empty($clave)){
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
    session_start();
    $_SESSION['user'] = [
        'id' => $resultado['id_usuario'],
        'nombre' => $resultado['nombre'],
        'rol' => $resultado['rol']
    ];

    // Redirección segun el rol 
    $rendirectUrl = '/aventura_go/login';
    $mensaje = 'Rol inexistente. Redirigiendo al inicio de sesión...';

    switch ($resultado['rol']) {
        case 'administrador':
            $rendirectUrl = '/aventura_go/administrador/dashboard';
            $mensaje = 'Bienvenido Administrador.';
            break;
        case 'proveedor-turistico':
            $rendirectUrl = '/aventura_go/proveedor_turistico/dashboard';
            $mensaje = 'Bienvenido Proveedor Turistico.';
            break;
        case 'proveedor-hotelero':
            $rendirectUrl = '/aventura_go/proveedor_hotelero/dashboard';
            $mensaje = 'Bienvenido Proveedor Hotelero.';
            break;
        case 'turista':
            $rendirectUrl = '/aventura_go/turista/tours';
            $mensaje = 'Bienvenido Turista.';
            break;
        
        default:
            # code...
            break;
    }

    mostrarSweetAlert('success', 'Ingreso exitoso', $mensaje, $rendirectUrl);
    exit();

} else{
    http_response_code(405);
    echo "Metodo no permitido";
    exit();
}


?>