<?php
session_start();

require_once BASE_PATH . '/app/models/proveedor_hotelero/hospedaje.php';
require_once BASE_PATH . '/app/models/proveedor_hotelero/ReservaHotelero.php';
require_once BASE_PATH . '/app/helpers/alert_helper.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'descubre-hospedaje');
    exit;
}

if (!isset($_SESSION['user'])) {
    $id_hosp = (int)($_POST['id_hospedaje'] ?? 0);
    $_SESSION['redirect_after_login'] = BASE_URL . 'hospedaje-escogido?id=' . $id_hosp;
    header('Location: ' . BASE_URL . 'login');
    exit;
}

if (($_SESSION['user']['rol'] ?? '') !== 'turista') {
    mostrarSweetAlert('error', 'Acceso denegado', 'Solo los turistas pueden hacer reservas.', BASE_URL . 'descubre-hospedaje');
    exit;
}

$id_hospedaje      = (int)($_POST['id_hospedaje'] ?? 0);
$fecha             = trim($_POST['fecha'] ?? '');
$cantidad_personas = (int)($_POST['cantidad_personas'] ?? 0);
$id_turista        = (int)$_SESSION['user']['id_usuario'];

if (!$id_hospedaje || !$fecha || $cantidad_personas < 1) {
    mostrarSweetAlert('error', 'Datos incompletos', 'Completa todos los campos para reservar.', BASE_URL . 'hospedaje-escogido?id=' . $id_hospedaje);
    exit;
}

if (strtotime($fecha) < strtotime(date('Y-m-d'))) {
    mostrarSweetAlert('error', 'Fecha inválida', 'La fecha de llegada no puede ser anterior a hoy.', BASE_URL . 'hospedaje-escogido?id=' . $id_hospedaje);
    exit;
}

$hospedajeModel = new Hospedaje();
$hospedaje      = $hospedajeModel->obtenerPublico($id_hospedaje);

if (!$hospedaje) {
    mostrarSweetAlert('error', 'Hospedaje no disponible', 'El hospedaje no está disponible.', BASE_URL . 'descubre-hospedaje');
    exit;
}

if ($cantidad_personas > (int)$hospedaje['capacidad']) {
    mostrarSweetAlert('error', 'Sin capacidad', 'La cantidad de personas supera la capacidad de esta acomodación (' . $hospedaje['capacidad'] . ' personas).', BASE_URL . 'hospedaje-escogido?id=' . $id_hospedaje);
    exit;
}

// Verificar disponibilidad específica para la fecha solicitada
if (!$hospedajeModel->haycapacidadDisponibles($id_hospedaje, $fecha, $cantidad_personas)) {
    mostrarSweetAlert(
        'error',
        'Fecha no disponible',
        'Esta acomodación ya está completa para el ' . date('d/m/Y', strtotime($fecha)) . '. Por favor elige otra fecha.',
        BASE_URL . 'hospedaje-escogido?id=' . $id_hospedaje
    );
    exit;
}

$reservaModel = new ReservaHotelero();
$id_reserva   = $reservaModel->crear([
    'id_hospedaje'      => $id_hospedaje,
    'id_turista'        => $id_turista,
    'fecha'             => $fecha,
    'cantidad_personas' => $cantidad_personas,
    'precio'            => $hospedaje['precio'] ?? 0,
]);

if ($id_reserva) {
    try {
        require_once BASE_PATH . '/app/models/NotificacionModel.php';
        (new NotificacionModel())->crear(
            $id_turista,
            'reserva_hospedaje',
            '¡Reserva de hospedaje registrada!',
            'Tu reserva en "' . $hospedaje['nombre'] . '" para el ' . date('d/m/Y', strtotime($fecha)) . ' fue registrada. El proveedor la confirmará pronto.',
            'bi-building-check',
            'blue',
            'turista/ver-reservas-hotel',
            $id_reserva
        );
    } catch (Throwable $e) { /* notificación opcional */ }

    // Enviar email con ticket PDF al turista
    try {
        require_once BASE_PATH . '/config/database.php';
        $db    = (new conexion())->getConexion();
        $stmtU = $db->prepare("SELECT nombre, email FROM usuario WHERE id_usuario = ? LIMIT 1");
        $stmtU->execute([$id_turista]);
        $turista = $stmtU->fetch(PDO::FETCH_ASSOC);

        if ($turista && !empty($turista['email'])) {
            $fechaFmt  = date('d/m/Y', strtotime($fecha));
            $nombre    = htmlspecialchars($turista['nombre']);
            $servicio  = htmlspecialchars($hospedaje['nombre']);
            $numTicket = str_pad($id_reserva, 6, '0', STR_PAD_LEFT);

            require_once BASE_PATH . '/app/helpers/mailer_helper.php';

            $mail = mailer_init();
            $mail->setFrom('aventurago.contacto@gmail.com', 'AventuraGO');
            $mail->addAddress($turista['email'], $turista['nombre']);
            $mail->Subject = '🏨 Tu reserva de hospedaje fue registrada — AventuraGO';
            $mail->Body = "
            <div style='font-family:sans-serif;max-width:560px;margin:auto;background:#fff;border-radius:12px;overflow:hidden;border:1px solid #e5e7eb'>
                <div style='background:#EA8217;padding:28px 24px;text-align:center'>
                    <h1 style='color:#fff;margin:0;font-size:22px'>¡Reserva de hospedaje registrada! 🏨</h1>
                </div>
                <div style='padding:28px 24px'>
                    <p style='color:#374151;font-size:15px'>Hola <strong>$nombre</strong>,</p>
                    <p style='color:#374151;font-size:14px'>Tu reserva de hospedaje ha sido <strong>registrada</strong> exitosamente.</p>
                    <div style='background:#f9fafb;border-radius:8px;padding:16px;margin:20px 0'>
                        <p style='margin:6px 0;font-size:14px;color:#374151'><strong>🏨 Hospedaje:</strong> $servicio</p>
                        <p style='margin:6px 0;font-size:14px;color:#374151'><strong>📅 Fecha de llegada:</strong> $fechaFmt</p>
                        <p style='margin:6px 0;font-size:14px;color:#374151'><strong>👥 Personas:</strong> $cantidad_personas</p>
                        <p style='margin:6px 0;font-size:14px;color:#374151'><strong>🎫 N° Reserva:</strong> #$numTicket</p>
                        <p style='margin:6px 0;font-size:13px;color:#3b82f6'><strong>Estado:</strong> Pendiente — el proveedor la confirmará pronto.</p>
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
                    'id_reserva'        => $id_reserva,
                    'nombre_turista'    => $turista['nombre'],
                    'tipo'              => 'hospedaje',
                    'nombre_servicio'   => $hospedaje['nombre'],
                    'proveedor'         => $hospedaje['nombre_establecimiento'] ?? '—',
                    'fecha'             => $fecha,
                    'cantidad_personas' => $cantidad_personas,
                    'precio'            => $hospedaje['precio'] ?? 0,
                    'estado'            => 'pendiente',
                ]);
                $mail->addStringAttachment($pdf, 'ticket-reserva-' . $numTicket . '.pdf', 'base64', 'application/pdf');
            } catch (Throwable $ePdf) {
                error_log('Ticket PDF hospedaje (sin adjunto): ' . $ePdf->getMessage());
            }

            $mail->send();
        }
    } catch (Throwable $e) {
        error_log('Ticket email hospedaje: ' . $e->getMessage());
    }

    mostrarSweetAlert(
        'success',
        '¡Reserva realizada!',
        'Tu reserva en "' . htmlspecialchars($hospedaje['nombre']) . '" fue registrada. El proveedor la confirmará pronto.',
        BASE_URL . 'turista/dashboard'
    );
} else {
    mostrarSweetAlert('error', 'Error al reservar', 'No se pudo completar la reserva. Intenta de nuevo.', BASE_URL . 'hospedaje-escogido?id=' . $id_hospedaje);
}
