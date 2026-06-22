<?php
class FavoritoController
{
    public function ver()
    {
        require_once BASE_PATH . '/app/helpers/session_turista.php';
        require_once BASE_PATH . '/app/models/turista/FavoritoModel.php';

        $idTurista   = (int)$_SESSION['user']['id_usuario'];
        $favModel    = new FavoritoModel();
        $actividades = $favModel->listarActividades($idTurista);
        $hospedajes  = $favModel->listarHospedajes($idTurista);

        require BASE_PATH . '/app/views/dashboard/turista/favoritos.php';
    }

    public function toggle()
    {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (empty($_SESSION['user']['id_usuario']) || ($_SESSION['user']['rol'] ?? '') !== 'turista') {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            exit;
        }

        $idTurista = (int)$_SESSION['user']['id_usuario'];
        $tipo      = $_POST['tipo'] ?? '';
        $idRef     = (int)($_POST['id_referencia'] ?? 0);

        if (!in_array($tipo, ['actividad', 'hospedaje']) || $idRef <= 0) {
            echo json_encode(['ok' => false, 'error' => 'Datos inválidos']);
            exit;
        }

        try {
            require_once BASE_PATH . '/app/models/turista/FavoritoModel.php';
            $favModel = new FavoritoModel();
            $estado   = $favModel->toggle($idTurista, $tipo, $idRef);
            echo json_encode(['ok' => true, 'estado' => $estado]);
        } catch (Throwable $e) {
            error_log('FavoritoController::toggle ' . $e->getMessage());
            echo json_encode(['ok' => false, 'error' => 'Error interno']);
        }
        exit;
    }
}
