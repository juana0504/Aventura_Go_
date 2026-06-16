<?php
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] !== 'proveedor_turistico') {
    echo json_encode(['ok' => false, 'error' => 'No autorizado']);
    exit;
}

$idActividad = $_GET['id'] ?? null;
if (!$idActividad) {
    echo json_encode(['ok' => false, 'error' => 'ID de actividad no recibido']);
    exit;
}

require_once BASE_PATH . '/app/models/proveedor_turistico/Proveedor.php';
require_once BASE_PATH . '/app/models/turista/ResenaModel.php';

$idProveedor = Proveedor::obtenerIdProveedorPorUsuario($_SESSION['user']['id_usuario']);
if (!$idProveedor) {
    echo json_encode(['ok' => false, 'error' => 'Proveedor no encontrado']);
    exit;
}

$model   = new ResenaModel();
$resenas = $model->obtenerResenasPorActividad((int)$idActividad, $idProveedor);

echo json_encode(['ok' => true, 'resenas' => $resenas]);
exit;
