<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//VALIDAMOS SI HAY UNA SECCION ACTIVA, se crea solo cuando hay una sesion activa
if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . 'login');
    exit;
}

//validamos que el rol sea el correspondiente
if ($_SESSION['user']['rol'] !== 'proveedor') {
    header('Location: ' . BASE_URL . 'login');
    exit;
}

// NUEVA VALIDACIÓN DE APROBACIÓN

require_once __DIR__ . '/../../config/database.php';

$db = new conexion();
$conexion = $db->getConexion();

$idUsuario = $_SESSION['user']['id_usuario'];

$sql = "SELECT validado FROM proveedor WHERE id_usuario = :id LIMIT 1";
$stmt = $conexion->prepare($sql);
$stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);
$stmt->execute();

$proveedor = $stmt->fetch(PDO::FETCH_ASSOC);

if ($proveedor && $proveedor['validado'] == 0) {

    $currentPath = $_SERVER['REQUEST_URI'];

    // Rutas que NO puede usar si no está validado
    $rutasBloqueadas = [
        '/proveedor/registrar-actividad',
        '/proveedor/guardar-actividad',
        '/proveedor/editar-actividad',
        '/proveedor/eliminar-actividad'
    ];

    foreach ($rutasBloqueadas as $ruta) {
        if (strpos($currentPath, $ruta) !== false) {
            header('Location: ' . BASE_URL . 'proveedor/pendiente');
            exit;
        }
    }
}
