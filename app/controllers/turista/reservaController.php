<?php
class ReservaController
{
    public function prepararReserva()
    {
        require_once BASE_PATH . '/app/helpers/session_turista.php';
        require_once BASE_PATH . '/app/models/turista/actividadModel.php';
        require_once BASE_PATH . '/app/models/turista/reservaModel.php';

        if (!isset($_GET['id'])) {
            header('Location: ' . BASE_URL . 'descubre-tours');
            exit;
        }

        $idActividad = (int) $_GET['id'];
        $idUsuario   = $_SESSION['user']['id_usuario'];

        $actividadModel = new ActividadModel();
        $reservaModel   = new ReservaModel();

        $actividad = $actividadModel->obtenerPorId($idActividad);

        if (!$actividad || $actividad['estado'] !== 'ACTIVO') {
            header('Location: ' . BASE_URL . 'descubre-tours');
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

        // Notificación al turista por reserva de actividad
        require_once BASE_PATH . '/app/models/NotificacionModel.php';
        (new NotificacionModel())->crear(
            (int)$idUsuario,
            'reserva_actividad',
            '¡Reserva de actividad registrada!',
            'Tu reserva para "' . ($actividad['nombre'] ?? 'actividad') . '" fue registrada con estado pendiente.',
            'bi-compass',
            'green',
            'turista/ver-reservas'
        );

        header('Location: ' . BASE_URL . 'turista/ver-reservas');
        exit;
    }




    public function verReservas()
    {
        require_once BASE_PATH . '/app/helpers/session_turista.php';
        require_once BASE_PATH . '/app/models/turista/ReservaTurista.php';

        $idUsuario    = (int) $_SESSION['user']['id_usuario'];
        $reservaModel = new ReservaTurista();
        $reservas     = $reservaModel->listarActividadesPorTurista($idUsuario);

        require BASE_PATH . '/app/views/dashboard/turista/ver_reservas.php';
    }

    public function verReservasHotel()
    {
        require_once BASE_PATH . '/app/helpers/session_turista.php';
        require_once BASE_PATH . '/app/models/turista/ReservaTurista.php';

        $idUsuario    = (int) $_SESSION['user']['id_usuario'];
        $reservaModel = new ReservaTurista();
        $reservas     = $reservaModel->listarHospedajesPorTurista($idUsuario);

        require BASE_PATH . '/app/views/dashboard/turista/ver_reservas_hotel.php';
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
        require_once BASE_PATH . '/app/models/turista/reservaModel.php';
        require_once BASE_PATH . '/app/models/turista/actividadModel.php';

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

        if (session_status() === PHP_SESSION_NONE) { session_start(); }

        if (empty($_SESSION['user']['id_usuario']) || ($_SESSION['user']['rol'] ?? '') !== 'turista') {
            echo json_encode(['error' => 'No autorizado']);
            exit;
        }

        $id        = (int)($_GET['id'] ?? 0);
        $idTurista = (int)$_SESSION['user']['id_usuario'];

        if ($id <= 0) {
            echo json_encode(['error' => 'ID inválido']);
            exit;
        }

        try {
            require_once BASE_PATH . '/config/database.php';
            $db = (new conexion())->getConexion();

            // Paso 1: reserva — verificar propietario en la misma query
            $stmt = $db->prepare(
                "SELECT * FROM reserva WHERE id_reserva = ? AND id_turista = ? LIMIT 1"
            );
            $stmt->execute([$id, $idTurista]);
            $base = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$base) {
                echo json_encode(['error' => 'Reserva no encontrada']);
                exit;
            }

            $esHospedaje = ($base['tipo_reserva'] ?? '') === 'hospedaje';

            // Paso 2: datos del servicio reservado
            if ($esHospedaje) {
                $stmt = $db->prepare("
                    SELECT h.nombre AS nombre_actividad, h.descripcion,
                           h.imagen AS imagen_fallback,
                           ph.nombre_establecimiento AS proveedor
                    FROM hospedaje h
                    LEFT JOIN proveedor_hotelero ph
                        ON h.id_proveedor_hotelero = ph.id_proveedor_hotelero
                    WHERE h.id_hospedaje = ? LIMIT 1
                ");
                $stmt->execute([$base['id_hospedaje'] ?? 0]);

                $stmtImg = $db->prepare(
                    "SELECT imagen, es_principal FROM hospedaje_imagen
                     WHERE id_hospedaje = ? ORDER BY es_principal DESC"
                );
                $stmtImg->execute([$base['id_hospedaje'] ?? 0]);
            } else {
                $stmt = $db->prepare("
                    SELECT a.nombre AS nombre_actividad, a.descripcion,
                           p.nombre_empresa AS proveedor
                    FROM actividad a
                    LEFT JOIN proveedor p ON a.id_proveedor = p.id_proveedor
                    WHERE a.id_actividad = ? LIMIT 1
                ");
                $stmt->execute([$base['id_actividad'] ?? 0]);

                $stmtImg = $db->prepare(
                    "SELECT imagen, es_principal FROM actividad_imagen
                     WHERE id_actividad = ? ORDER BY es_principal DESC"
                );
                $stmtImg->execute([$base['id_actividad'] ?? 0]);
            }

            $extra    = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
            $imagenes = $stmtImg->fetchAll(PDO::FETCH_ASSOC);

            // Fallback: si hospedaje_imagen está vacía usa h.imagen directamente
            if ($esHospedaje && empty($imagenes) && !empty($extra['imagen_fallback'])
                && $extra['imagen_fallback'] !== 'hospedaje_default.png') {
                $imagenes = [['imagen' => $extra['imagen_fallback'], 'es_principal' => 1]];
            }

            $data = array_merge($base, $extra, ['imagenes' => $imagenes]);

            echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_IGNORE);

        } catch (Throwable $e) {
            error_log('obtenerReserva: ' . $e->getMessage());
            echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
        }

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

        require_once BASE_PATH . '/app/models/turista/reservaModel.php';

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

    public function cancelarReserva()
    {
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) { session_start(); }

        if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] !== 'turista') {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            exit;
        }

        $idReserva = $_POST['id_reserva'] ?? null;
        if (!$idReserva) {
            echo json_encode(['ok' => false, 'error' => 'ID de reserva no recibido']);
            exit;
        }

        require_once BASE_PATH . '/app/models/turista/ReservaTurista.php';

        $idTurista = $_SESSION['user']['id_usuario'];
        $model     = new ReservaTurista();

        if (!$model->verificarReservaDeTurista($idReserva, $idTurista)) {
            echo json_encode(['ok' => false, 'error' => 'Reserva no encontrada o no autorizada']);
            exit;
        }

        $ok = $model->cancelarReserva($idReserva, $idTurista);

        if ($ok) {
            require_once BASE_PATH . '/app/models/NotificacionModel.php';
            (new NotificacionModel())->crear(
                (int)$idTurista,
                'reserva_cancelada',
                'Reserva cancelada',
                'Tu reserva #' . (int)$idReserva . ' fue cancelada exitosamente.',
                'bi-x-circle',
                'red',
                'turista/ver-reservas'
            );
            echo json_encode(['ok' => true]);
        } else {
            echo json_encode(['ok' => false, 'error' => 'No se pudo cancelar. Verifica que la reserva no sea de una fecha pasada.']);
        }
        exit;
    }
}
