<?php

require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/models/administrador/NotificacionAdmin.php';

class NotificacionAdminController
{
    private $model;

    public function __construct()
    {
        $this->model = new NotificacionAdmin();
    }

    public function listarJson(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $idAdmin = (int) ($_SESSION['user']['id_usuario'] ?? 0);
        if ($idAdmin <= 0) {
            http_response_code(401);
            echo json_encode([
                'ok' => false,
                'mensaje' => 'Sesion invalida.'
            ]);
            return;
        }

        $limite = isset($_GET['limite']) ? (int) $_GET['limite'] : 6;
        $notificaciones = $this->model->listar($idAdmin, $limite);
        $noLeidas = $this->model->contarNoLeidas($idAdmin);

        echo json_encode([
            'ok' => true,
            'notificaciones' => $notificaciones,
            'noLeidas' => $noLeidas,
        ]);
    }

    public function marcarTodasLeidas(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode([
                'ok' => false,
                'mensaje' => 'Metodo no permitido.'
            ]);
            return;
        }

        $idAdmin = (int) ($_SESSION['user']['id_usuario'] ?? 0);
        if ($idAdmin <= 0) {
            http_response_code(401);
            echo json_encode([
                'ok' => false,
                'mensaje' => 'Sesion invalida.'
            ]);
            return;
        }

        $actualizadas = $this->model->marcarTodasLeidas($idAdmin);

        echo json_encode([
            'ok' => true,
            'actualizadas' => $actualizadas,
        ]);
    }
}
