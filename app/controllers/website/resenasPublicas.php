<?php
header('Content-Type: application/json');

$idActividad = $_GET['id'] ?? null;
if (!$idActividad) {
    echo json_encode(['ok' => false, 'error' => 'ID no recibido']);
    exit;
}

require_once BASE_PATH . '/app/models/turista/ResenaModel.php';

$model   = new ResenaModel();
$resenas = $model->obtenerResenasPorActividadPublico((int)$idActividad);

echo json_encode(['ok' => true, 'resenas' => $resenas]);
exit;
