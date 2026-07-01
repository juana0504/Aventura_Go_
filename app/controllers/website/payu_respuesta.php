<?php
session_start();

// Validar sesión mínima
if (!isset($_SESSION['id_reserva']) || !isset($_SESSION['id_pago'])) {
    header('Location: ' . BASE_URL . 'descubre-tours');
    exit;
}

// Conexión BD
require_once BASE_PATH . '/config/database.php';

$db = new conexion();
$pdo = $db->getConexion();

// Simulamos respuesta PayU
$respuestaPayu = 'aprobado';

$idReserva = $_SESSION['id_reserva'];
$idPago    = $_SESSION['id_pago'];

if ($respuestaPayu === 'aprobado') {

    // Actualizar pago
    $stmtPago = $pdo->prepare("UPDATE pago SET estado = 'aprobado' WHERE id_pago = :id");
    $stmtPago->execute([':id' => $idPago]);

    // Actualizar reserva
    $stmtReserva = $pdo->prepare("UPDATE reserva SET estado = 'confirmada' WHERE id_reserva = :id");
    $stmtReserva->execute([':id' => $idReserva]);

    // Enviar email con ticket al turista
    try {
        $emailDest  = null;
        $nombreDest = $_SESSION['user']['nombre'] ?? ($_SESSION['pago_tmp']['cliente']['nombre'] ?? 'Turista');

        // Usar el email registrado en la plataforma
        if (!empty($_SESSION['user']['id_usuario'])) {
            $stmtU = $pdo->prepare("SELECT email FROM usuario WHERE id_usuario = ? LIMIT 1");
            $stmtU->execute([$_SESSION['user']['id_usuario']]);
            $row = $stmtU->fetch(PDO::FETCH_ASSOC);
            $emailDest = $row['email'] ?? null;
        }
        // Fallback: email ingresado en el checkout
        if (!$emailDest) {
            $emailDest = $_SESSION['pago_tmp']['cliente']['email'] ?? null;
        }

        if ($emailDest) {
            $reservaData = $_SESSION['reserva'] ?? [];
            $numTicket   = str_pad((int)$idReserva, 6, '0', STR_PAD_LEFT);
            $fechaFmt    = date('d/m/Y', strtotime($reservaData['fecha'] ?? date('Y-m-d')));
            $totalFmt    = '$' . number_format((float)($reservaData['total'] ?? 0), 0, ',', '.') . ' COP';
            $servicio    = htmlspecialchars($reservaData['nombre'] ?? 'Actividad turística');
            $personas    = (int)($reservaData['cantidad'] ?? 1);
            $nombre      = htmlspecialchars($nombreDest);

            require_once BASE_PATH . '/app/helpers/mailer_helper.php';

            $mail = mailer_init();
            $mail->setFrom('aventurago.contacto@gmail.com', 'AventuraGO');
            $mail->addAddress($emailDest, $nombreDest);
            $mail->Subject = '✅ ¡Pago confirmado! Tu reserva está lista — AventuraGO';
            $mail->Body = "
            <div style='font-family:sans-serif;max-width:560px;margin:auto;background:#fff;border-radius:12px;overflow:hidden;border:1px solid #e5e7eb'>
                <div style='background:#EA8217;padding:28px 24px;text-align:center'>
                    <h1 style='color:#fff;margin:0;font-size:22px'>¡Pago confirmado! ✅</h1>
                </div>
                <div style='padding:28px 24px'>
                    <p style='color:#374151;font-size:15px'>Hola <strong>$nombre</strong>,</p>
                    <p style='color:#374151;font-size:14px'>Tu pago fue procesado y tu reserva está <strong>confirmada</strong>. Adjuntamos tu ticket.</p>
                    <div style='background:#f9fafb;border-radius:8px;padding:16px;margin:20px 0'>
                        <p style='margin:6px 0;font-size:14px;color:#374151'><strong>🧭 Actividad:</strong> $servicio</p>
                        <p style='margin:6px 0;font-size:14px;color:#374151'><strong>📅 Fecha:</strong> $fechaFmt</p>
                        <p style='margin:6px 0;font-size:14px;color:#374151'><strong>👥 Personas:</strong> $personas</p>
                        <p style='margin:6px 0;font-size:14px;color:#374151'><strong>🎫 N° Reserva:</strong> #$numTicket</p>
                        <p style='margin:6px 0;font-size:14px;color:#EA8217;font-weight:700'><strong>💰 Total pagado:</strong> $totalFmt</p>
                    </div>
                    <p style='color:#6b7280;font-size:13px'>Si ves un archivo adjunto en este correo, es tu ticket descargable en PDF.</p>
                </div>
                <div style='background:#f3f4f6;padding:14px 24px;text-align:center'>
                    <p style='color:#9ca3af;font-size:12px;margin:0'>AventuraGO · aventurago.com.co</p>
                </div>
            </div>";

            // Intentar adjuntar PDF — si falla, el email igual se envía
            try {
                require_once BASE_PATH . '/app/helpers/ticket_pdf_helper.php';
                $pdf = generarTicketPDF([
                    'id_reserva'        => $idReserva,
                    'nombre_turista'    => $nombreDest,
                    'tipo'              => 'actividad',
                    'nombre_servicio'   => $reservaData['nombre'] ?? 'Actividad turística',
                    'proveedor'         => '—',
                    'fecha'             => $reservaData['fecha'] ?? date('Y-m-d'),
                    'cantidad_personas' => $personas,
                    'precio'            => $reservaData['total'] ?? 0,
                    'estado'            => 'confirmada',
                ]);
                $mail->addStringAttachment($pdf, 'ticket-reserva-' . $numTicket . '.pdf', 'base64', 'application/pdf');
            } catch (Throwable $ePdf) {
                error_log('Ticket PDF actividad: ' . $ePdf->getMessage());
            }

            $mail->send();
        }
    } catch (Throwable $e) {
        error_log('Email payu_respuesta: ' . $e->getMessage());
    }

    // Redirigir a confirmación
    header('Location: ' . BASE_URL . 'confirmacion');
    exit;
} else {

    // Si fuera rechazado
    $stmtPago = $pdo->prepare("UPDATE pago SET estado = 'rechazado' WHERE id_pago = :id");
    $stmtPago->execute([':id' => $idPago]);

    header('Location: ' . BASE_URL . 'checkout');
    exit;
}
