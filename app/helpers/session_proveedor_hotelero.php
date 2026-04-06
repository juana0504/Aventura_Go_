<?php

session_start();

//VALIDAMOS SI HAY UNA SECCION ACTIVA, se crea solo cuando hay una sesion activa
if (!isset($_SESSION['user'])) {
    header('Location: /aventura_go/login');
    exit;
}

//validamos que el rol sea el correspondiente
if ($_SESSION['user']['rol'] !== 'proveedor_hotelero') {
    header('Location: /aventura_go/login');
    exit;
}



// NUEVA VALIDACIÓN DE APROBACIÓN
require_once __DIR__ . '/../../config/database.php';

$db = new conexion();
$conexion = $db->getConexion();

$idUsuario = $_SESSION['user']['id_usuario'];
// Consulta para obtener el estado de validación del proveedor hotelero
$sql = "SELECT validado FROM proveedor_hotelero WHERE id_usuario = :id LIMIT 1";
// Preparar y ejecutar la consulta
$stmt = $conexion->prepare($sql);
$stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);
$stmt->execute();
// Obtener el resultado como un arreglo asociativo
$proveedor = $stmt->fetch(PDO::FETCH_ASSOC);

// Si el proveedor existe y no está validado, redirige a la página de pendiente de aprobación
if ($proveedor && $proveedor['validado'] == 0) {
    // Verificar la ruta actual para evitar redirecciones infinitas
    $currentPath = $_SERVER['REQUEST_URI'];
    // Rutas que NO puede usar si no está validado
    $rutasBloqueadas = [
        '/proveedor_hotelero/registrar-hospedaje',
        '/proveedor_hotelero/guardar-hospedaje',
        '/proveedor_hotelero/editar-hospedaje',
        '/proveedor_hotelero/eliminar-hospedaje'
    ];
    // Si la ruta actual contiene alguna de las rutas bloqueadas, redirige a pendiente de aprobación
    foreach ($rutasBloqueadas as $ruta) {
        if (strpos($currentPath, $ruta) !== false) {
            header('Location: /aventura_go/proveedor_hotelero/pendiente');
            exit;
        }
    }
}
