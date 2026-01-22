<?php
//impotamos las dependencias
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/Recoverypass.php';



// aterrizamos los datos del formulario
$email = $_POST['email'] ?? '';


if (empty($email)) {
    mostrarSweetAlert('error', 'campo vacio', 'por favor complete el campos');
}

$objmodelo = new Recoverypass();
$resultado = $objmodelo->recuperarClave($email);

// agregar sweet alert de envio o no envio delcorreo 
if ($resultado === true) {
    mostrarSweetAlert('success', 'Sera enviado una nueva clave', 'Se ha enviado una nueva contraseña al correo electronico.', '/aventura_go/login');
} else {
    mostrarSweetAlert('error', 'Usuario no encontrado', 'Verifique su correo electrónico e intente nuevamente.');
}
