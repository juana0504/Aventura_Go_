<?php
header('Content-Type: application/json');

$id = $_GET['id'] ?? null;
if (!$id) {
    echo json_encode(['ok' => false, 'error' => 'ID no recibido']);
    exit;
}

require_once BASE_PATH . '/app/models/proveedor_hotelero/ResenaHospedajeModel.php';

$model   = new ResenaHospedajeModel();
$resenas = $model->obtenerPorHospedaje((int)$id);

echo json_encode(['ok' => true, 'resenas' => $resenas]);
exit;
