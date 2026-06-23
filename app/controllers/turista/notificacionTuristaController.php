<?php
require_once BASE_PATH . '/app/helpers/session_turista.php';
require_once BASE_PATH . '/app/models/NotificacionModel.php';

// Siempre JSON — va ANTES de cualquier operación DB para que llegue al navegador
header('Content-Type: application/json');

// Capturar cualquier salida inesperada (warnings de PHP, etc.) para no romper el JSON
ob_start();

try {
    $id_usuario = (int)$_SESSION['user']['id_usuario'];
    $model      = new NotificacionModel();
    $accion     = $_GET['accion'] ?? $_POST['accion'] ?? '';

    ob_end_clean(); // descartar warnings antes de enviar JSON

    switch ($accion) {

        case 'listar':
            try {
                $items = $model->listarActivas($id_usuario);
                $model->marcarTodasLeidas($id_usuario);
                echo json_encode(['ok' => true, 'notificaciones' => $items]);
            } catch (Throwable $e) {
                echo json_encode(['ok' => true, 'notificaciones' => []]);
            }
            break;

        case 'contar':
            try {
                echo json_encode(['ok' => true, 'total' => $model->contarNoLeidas($id_usuario)]);
            } catch (Throwable $e) {
                echo json_encode(['ok' => true, 'total' => 0]);
            }
            break;

        case 'archivar':
            $id = (int)($_POST['id'] ?? 0);
            if (!$id) { echo json_encode(['ok' => false]); break; }
            try {
                $ok = $model->archivar($id, $id_usuario);
                echo json_encode(['ok' => $ok]);
            } catch (Throwable $e) {
                echo json_encode(['ok' => false]);
            }
            break;

        case 'leer-todas':
            try {
                $ok = $model->marcarTodasLeidas($id_usuario);
                echo json_encode(['ok' => $ok]);
            } catch (Throwable $e) {
                echo json_encode(['ok' => true]);
            }
            break;

        default:
            echo json_encode(['ok' => false, 'error' => 'Acción no válida']);
    }

} catch (Throwable $e) {
    ob_end_clean();
    echo json_encode(['ok' => true, 'notificaciones' => [], 'total' => 0]);
}
