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

        $idReserva = $reservaModel->crearReserva([
            ':id_turista'        => $idUsuario,
            ':id_actividad'      => $idActividad,
            ':fecha'             => date('Y-m-d'),
            ':cantidad_personas' => 1,
            ':precio'            => $actividad['precio'],
            ':estado'            => 'pendiente'
        ]);

        try {
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
        } catch (Throwable $e) { /* notificación opcional */ }

        // Enviar email con ticket PDF al turista
        try {
            if ($idReserva) {
                require_once BASE_PATH . '/config/database.php';
                $db    = (new conexion())->getConexion();
                $stmtU = $db->prepare("SELECT nombre, email FROM usuario WHERE id_usuario = ? LIMIT 1");
                $stmtU->execute([$idUsuario]);
                $turista = $stmtU->fetch(PDO::FETCH_ASSOC);

                if ($turista && !empty($turista['email'])) {
                    $detalle   = $reservaModel->obtenerDetallePorId($idReserva);
                    $nombre    = htmlspecialchars($turista['nombre']);
                    $servicio  = htmlspecialchars($detalle['nombre_actividad'] ?? $actividad['nombre']);
                    $numTicket = str_pad($idReserva, 6, '0', STR_PAD_LEFT);
                    $fechaFmt  = date('d/m/Y');

                    require_once BASE_PATH . '/app/helpers/mailer_helper.php';

                    $mail = mailer_init();
                    $mail->setFrom('aventurago.contacto@gmail.com', 'AventuraGO');
                    $mail->addAddress($turista['email'], $turista['nombre']);
                    $mail->Subject = '🎯 Tu reserva fue registrada — AventuraGO';
                    $mail->Body = "
                    <div style='font-family:sans-serif;max-width:560px;margin:auto;background:#fff;border-radius:12px;overflow:hidden;border:1px solid #e5e7eb'>
                        <div style='background:#EA8217;padding:28px 24px;text-align:center'>
                            <h1 style='color:#fff;margin:0;font-size:22px'>¡Reserva registrada! 🎉</h1>
                        </div>
                        <div style='padding:28px 24px'>
                            <p style='color:#374151;font-size:15px'>Hola <strong>$nombre</strong>,</p>
                            <p style='color:#374151;font-size:14px'>Tu reserva de actividad ha sido <strong>registrada</strong> exitosamente.</p>
                            <div style='background:#f9fafb;border-radius:8px;padding:16px;margin:20px 0'>
                                <p style='margin:6px 0;font-size:14px;color:#374151'><strong>🧭 Actividad:</strong> $servicio</p>
                                <p style='margin:6px 0;font-size:14px;color:#374151'><strong>📅 Fecha:</strong> $fechaFmt</p>
                                <p style='margin:6px 0;font-size:14px;color:#374151'><strong>🎫 N° Reserva:</strong> #$numTicket</p>
                                <p style='margin:6px 0;font-size:13px;color:#d97706'><strong>Estado:</strong> Pendiente de confirmación</p>
                            </div>
                            <p style='color:#6b7280;font-size:13px'>Si ves un archivo adjunto en este correo, es tu ticket descargable en PDF.</p>
                        </div>
                        <div style='background:#f3f4f6;padding:14px 24px;text-align:center'>
                            <p style='color:#9ca3af;font-size:12px;margin:0'>AventuraGO · aventurago.com.co</p>
                        </div>
                    </div>";

                    // Intentar adjuntar el PDF — si DOMPDF falla, el email igual se envía
                    try {
                        require_once BASE_PATH . '/app/helpers/ticket_pdf_helper.php';
                        $pdf = generarTicketPDF([
                            'id_reserva'        => $idReserva,
                            'nombre_turista'    => $turista['nombre'],
                            'tipo'              => 'actividad',
                            'nombre_servicio'   => $detalle['nombre_actividad'] ?? $actividad['nombre'],
                            'proveedor'         => $detalle['proveedor'] ?? '—',
                            'fecha'             => date('Y-m-d'),
                            'cantidad_personas' => 1,
                            'precio'            => $actividad['precio'],
                            'estado'            => 'pendiente',
                        ]);
                        $mail->addStringAttachment($pdf, 'ticket-reserva-' . $numTicket . '.pdf', 'base64', 'application/pdf');
                    } catch (Throwable $ePdf) {
                        error_log('Ticket PDF actividad (sin adjunto): ' . $ePdf->getMessage());
                    }

                    $mail->send();
                }
            }
        } catch (Throwable $e) {
            error_log('Ticket email actividad: ' . $e->getMessage());
        }

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

    public function descargarTicket()
    {
        require_once BASE_PATH . '/app/helpers/session_turista.php';
        require_once BASE_PATH . '/app/models/turista/ReservaTurista.php';
        require_once BASE_PATH . '/app/helpers/ticket_pdf_helper.php';

        $idReserva = (int) ($_GET['id'] ?? 0);
        $idUsuario = (int) $_SESSION['user']['id_usuario'];

        if (!$idReserva) {
            header('Location: ' . BASE_URL . 'turista/ver-reservas');
            exit;
        }

        $reservaModel = new ReservaTurista();
        $reserva      = $reservaModel->obtenerParaTicket($idReserva, $idUsuario);

        if (!$reserva) {
            header('Location: ' . BASE_URL . 'turista/ver-reservas');
            exit;
        }

        $nombreTurista = $_SESSION['user']['nombre'] ?? 'Turista';
        $numTicket     = str_pad($idReserva, 6, '0', STR_PAD_LEFT);

        try {
            $pdf = generarTicketPDF([
                'id_reserva'        => $reserva['id_reserva'],
                'nombre_turista'    => $nombreTurista,
                'tipo'              => $reserva['tipo_reserva'],
                'nombre_servicio'   => $reserva['nombre_servicio'],
                'proveedor'         => $reserva['proveedor'] ?: '—',
                'fecha'             => $reserva['fecha'],
                'cantidad_personas' => $reserva['cantidad_personas'],
                'precio'            => $reserva['precio'],
                'estado'            => $reserva['estado'],
            ]);
        } catch (Throwable $e) {
            error_log('descargarTicket PDF: ' . $e->getMessage());
            http_response_code(500);
            echo 'No fue posible generar el ticket PDF.';
            exit;
        }

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="ticket-reserva-' . $numTicket . '.pdf"');
        header('Content-Length: ' . strlen($pdf));
        header('Cache-Control: private, no-cache, no-store, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        echo $pdf;
        exit;
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
        require_once BASE_PATH . '/app/models/proveedor_turistico/actividadTuristica.php';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Método no permitido']);
            exit;
        }

        $idReserva = (int) ($_POST['id_reserva'] ?? 0);
        $idTurista = $_SESSION['user']['id_usuario'];

        $reservaModel   = new ReservaModel();

        $reserva = $reservaModel->obtenerPorId($idReserva, $idTurista);

        if (!$reserva || $reserva['estado'] !== 'pendiente') {
            echo json_encode(['error' => 'Reserva inválida']);
            exit;
        }

        // Validar cupos por fecha (sin decrementar cupos globales)
        $actividadModel = new ActividadTuristica();
        $hayDisponibilidad = $actividadModel->hayCuposDisponibles(
            $reserva['id_actividad'],
            $reserva['fecha'],
            $reserva['cantidad_personas']
        );

        if (!$hayDisponibilidad) {
            echo json_encode(['error' => 'No hay cupos disponibles para esa fecha']);
            exit;
        }

        // Confirmar reserva (los cupos se calculan contando reservas por fecha)
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
            try {
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
            } catch (Throwable $e) { /* notificación opcional */ }
            echo json_encode(['ok' => true]);
        } else {
            echo json_encode(['ok' => false, 'error' => 'No se pudo cancelar. Verifica que la reserva no sea de una fecha pasada.']);
        }
        exit;
    }
}
