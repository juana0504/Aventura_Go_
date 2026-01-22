<?php
require_once __DIR__ . '/../../helpers/session_proveedor.php';
require_once __DIR__ . '/../../models/proveedor_turistico/ActividadTuristica.php';

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'ID no recibido']);
    exit;
}

$id = (int) $_GET['id'];

$model = new ActividadTuristica();
$actividad = $model->listarPorId($id);

if (!$actividad) {
    echo json_encode(['error' => 'Actividad no encontrada']);
    exit;
}

header('Content-Type: application/json');
echo json_encode($actividad);
