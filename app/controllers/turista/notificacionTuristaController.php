<?php
require_once BASE_PATH . '/app/helpers/session_turista.php';
require_once BASE_PATH . '/app/models/NotificacionModel.php';

header('Content-Type: application/json');

$id_usuario = (int)$_SESSION['user']['id_usuario'];
$model      = new NotificacionModel();
$accion     = $_GET['accion'] ?? $_POST['accion'] ?? '';

switch ($accion) {

    case 'listar':
        $items = $model->listarActivas($id_usuario);
        // Marcar todas como leídas al abrir el panel
        $model->marcarTodasLeidas($id_usuario);
        echo json_encode(['ok' => true, 'notificaciones' => $items]);
        break;

    case 'contar':
        echo json_encode(['ok' => true, 'total' => $model->contarNoLeidas($id_usuario)]);
        break;

    case 'archivar':
        $id = (int)($_POST['id'] ?? 0);
        if (!$id) { echo json_encode(['ok' => false]); break; }
        $ok = $model->archivar($id, $id_usuario);
        echo json_encode(['ok' => $ok]);
        break;

    case 'leer-todas':
        $ok = $model->marcarTodasLeidas($id_usuario);
        echo json_encode(['ok' => $ok]);
        break;

    default:
        echo json_encode(['ok' => false, 'error' => 'Acción no válida']);
}
