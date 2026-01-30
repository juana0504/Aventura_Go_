<?php
require_once __DIR__ . '/../../helpers/session_proveedor.php';
require_once __DIR__ . '/../../models/proveedor_turistico/ActividadTuristica.php';

header('Content-Type: application/json');

// ===============================
// VALIDAR ID
// ===============================
if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'ID no recibido']);
    exit;
}

$id = (int) $_GET['id'];

if ($id <= 0) {
    echo json_encode(['error' => 'ID inválido']);
    exit;
}

// ===============================
// CONSULTAR MODELO
// ===============================
$model = new ActividadTuristica();
$actividad = $model->obtenerDetalleActividad($id);

if (!$actividad) {
    echo json_encode(['error' => 'Actividad no encontrada']);
    exit;
}

// ===============================
// NORMALIZAR ESTADO (CLAVE)
// ===============================
if (!isset($actividad['estado']) || trim($actividad['estado']) === '') {
    $actividad['estado'] = 'INACTIVO';
}

// ===============================
// RESPUESTA FINAL
// ===============================
echo json_encode($actividad);
exit;
