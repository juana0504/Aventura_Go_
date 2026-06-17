<?php
header('Content-Type: application/json');

require_once BASE_PATH . '/app/models/proveedor_turistico/actividadTuristica.php';

$model = new ActividadTuristica();
$tours = $model->listarPopulares(8);

echo json_encode(['ok' => true, 'tours' => $tours]);
exit;
