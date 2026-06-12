<?php

require_once BASE_PATH . '/app/models/turista/ResenaModel.php';

class ResenaController
{
    private ResenaModel $model;

    public function __construct()
    {
        $this->model = new ResenaModel();
    }

    public function listar()
    {
        require_once BASE_PATH . '/app/helpers/session_turista.php';

        $idUsuario = $_SESSION['user']['id_usuario'];

        $resenas           = $this->model->obtenerResenasPorTurista($idUsuario);
        $reservasPendientes = $this->model->obtenerReservasPendientesDeReseña($idUsuario);

        require BASE_PATH . '/app/views/dashboard/turista/resenas.php';
    }

    public function guardar()
    {
        require_once BASE_PATH . '/app/helpers/session_turista.php';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'turista/resenas');
            exit;
        }

        $idUsuario   = $_SESSION['user']['id_usuario'];
        $idReserva   = (int) ($_POST['id_reserva'] ?? 0);
        $calificacion = (int) ($_POST['calificacion'] ?? 0);
        $comentario  = trim($_POST['comentario'] ?? '');

        // Validaciones básicas
        if ($idReserva <= 0 || $calificacion < 1 || $calificacion > 5) {
            header('Location: ' . BASE_URL . 'turista/resenas?error=datos_invalidos');
            exit;
        }

        // Verificar que la reserva pertenece al turista y está confirmada
        $reserva = $this->model->reservaValida($idReserva, $idUsuario);

        if (!$reserva) {
            header('Location: ' . BASE_URL . 'turista/resenas?error=reserva_invalida');
            exit;
        }

        $ok = $this->model->guardar(
            $idUsuario,
            $idReserva,
            $reserva['id_actividad'],
            $calificacion,
            $comentario
        );

        if ($ok) {
            header('Location: ' . BASE_URL . 'turista/resenas?ok=1');
        } else {
            header('Location: ' . BASE_URL . 'turista/resenas?error=guardado');
        }
        exit;
    }
}
