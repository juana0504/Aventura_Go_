<?php
require_once BASE_PATH . '/app/models/turista/ActividadModel.php';

class ReservaController
{
    public function prepararReserva()
    {
        require_once BASE_PATH . '/app/helpers/session_turista.php';
        require_once BASE_PATH . '/app/models/turista/ActividadModel.php';
        require_once BASE_PATH . '/app/models/turista/ReservaModel.php';

        if (!isset($_GET['id'])) {
            header('Location: ' . BASE_URL . '/descubre-tours');
            exit;
        }

        $idActividad = (int) $_GET['id'];
        $idUsuario   = $_SESSION['user']['id_usuario'];

        $actividadModel = new ActividadModel();
        $reservaModel   = new ReservaModel();

        $actividad = $actividadModel->obtenerPorId($idActividad);

        if (!$actividad || $actividad['estado'] !== 'ACTIVO') {
            header('Location: ' . BASE_URL . '/descubre-tours');
            exit;
        }

        $reservaModel->crearReserva([
            ':id_turista'        => $idUsuario,
            ':id_actividad'      => $idActividad,
            ':fecha'             => date('Y-m-d'),
            ':cantidad_personas' => 1,
            ':precio'            => $actividad['precio'],
            ':estado'            => 'pendiente'
        ]);

        header('Location: ' . BASE_URL . '/turista/ver-reservas');
        exit;
    }




    public function verReservas()
    {
        require_once BASE_PATH . '/app/helpers/session_turista.php';
        require_once BASE_PATH . '/app/models/turista/ReservaModel.php';

        $idUsuario = $_SESSION['user']['id_usuario'];

        $reservaModel = new ReservaModel();
        $reservas = $reservaModel->obtenerPorTurista($idUsuario);

        require BASE_PATH . '/app/views/dashboard/turista/ver_reservas.php';
    }



    public function detalleReserva()
    {
        // NO usar session_turista.php aquí
        session_start();

        if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] !== 'turista') {
            echo json_encode(['error' => 'No autorizado']);
            exit;
        }

        require_once BASE_PATH . '/app/models/turista/ReservaModel.php';

        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo json_encode(['error' => 'ID no recibido']);
            exit;
        }

        $model = new ReservaModel();
        $data = $model->obtenerDetalleReserva($id);

        echo json_encode($data);
        exit;
    }






    public function confirmarReserva()
    {
        require_once BASE_PATH . '/app/helpers/session_turista.php';
        require_once BASE_PATH . '/app/models/turista/ReservaModel.php';
        require_once BASE_PATH . '/app/models/turista/ActividadModel.php';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Método no permitido']);
            exit;
        }

        $idReserva = (int) ($_POST['id_reserva'] ?? 0);
        $idTurista = $_SESSION['user']['id_usuario'];

        $reservaModel   = new ReservaModel();
        $actividadModel = new ActividadModel();

        $reserva = $reservaModel->obtenerPorId($idReserva, $idTurista);

        if (!$reserva || $reserva['estado'] !== 'pendiente') {
            echo json_encode(['error' => 'Reserva inválida']);
            exit;
        }

        // 1️⃣ Validar cupos
        $actividad = $actividadModel->obtenerPorId($reserva['id_actividad']);

        if ($actividad['cupos'] < $reserva['cantidad_personas']) {
            echo json_encode(['error' => 'No hay cupos disponibles']);
            exit;
        }

        // 2️⃣ Descontar cupos
        $actividadModel->descontarCupos(
            $actividad['id_actividad'],
            $reserva['cantidad_personas']
        );

        // 3️⃣ Confirmar reserva
        $reservaModel->confirmar($idReserva);

        echo json_encode(['ok' => true]);
        exit;
    }




    public function obtenerReserva()
    {
        header('Content-Type: application/json');

        echo json_encode([
            'nombre_actividad'  => 'PRUEBA OK',
            'estado'            => 'pendiente',
            'fecha'             => date('Y-m-d'),
            'proveedor'         => 'Proveedor prueba',
            'cantidad_personas' => 1,
            'precio'            => 10000,
            'descripcion'       => 'Descripción prueba',
            'imagenes'          => []
        ]);

        exit;
    }


    // public function accionReserva()
    // {
    //     require_once BASE_PATH . '/app/helpers/session_turista.php';
    //     require_once BASE_PATH . '/app/models/turista/ReservaModel.php';

    //     if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    //         echo json_encode(['ok' => false]);
    //         exit;
    //     }

    //     $idReserva = $_POST['id_reserva'] ?? null;
    //     $accion    = $_POST['accion'] ?? null;

    //     if (!$idReserva || !in_array($accion, ['confirmar', 'cancelar'])) {
    //         echo json_encode(['ok' => false]);
    //         exit;
    //     }

    //     $estado = $accion === 'confirmar' ? 'confirmada' : 'cancelada';

    //     $model = new ReservaModel();
    //     $model->actualizarEstado($idReserva, $estado);

    //     echo json_encode(['ok' => true]);
    //     exit;
    // }

    public function accionReserva()
    {
        session_start();

        if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] !== 'turista') {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            exit;
        }

        require_once BASE_PATH . '/app/models/turista/ReservaModel.php';

        $idReserva = $_POST['id_reserva'] ?? null;
        $accion    = $_POST['accion'] ?? null;

        if (!$idReserva || !$accion) {
            echo json_encode(['ok' => false, 'error' => 'Datos incompletos']);
            exit;
        }

        $estado = ($accion === 'confirmar') ? 'confirmada' : 'cancelada';

        $model = new ReservaModel();
        $ok = $model->actualizarEstado($idReserva, $estado);

        echo json_encode(['ok' => $ok]);
        exit;
    }
}
