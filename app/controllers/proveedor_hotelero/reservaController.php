<?php
require_once __DIR__ . '/../../helpers/session_proveedor_hotelero.php';
require_once __DIR__ . '/../../helpers/alert_helper.php';
require_once __DIR__ . '/../../helpers/mailer_helper.php';
require_once __DIR__ . '/../../models/proveedor_hotelero/ReservaHotelero.php';
require_once __DIR__ . '/../../models/proveedor_hotelero/Proveedor_hotelero.php';

$reservaModel          = new ReservaHotelero();
$id_proveedor_hotelero = (new Proveedor())->obtenerIdProveedorPorUsuario($_SESSION['user']['id_usuario']);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $accion = $_GET['accion'] ?? '';
    $id     = $_GET['id'] ?? '';

    if ($accion === 'confirmar' && $id) {
        if ($reservaModel->verificarReservaDeProveedor($id, $id_proveedor_hotelero)) {
            if ($reservaModel->confirmarReserva($id)) {
                // Enviar email de notificación al turista
                try {
                    $detalle = $reservaModel->listarPorId($id);
                    if ($detalle && !empty($detalle['email_turista'])) {
                        $mail = mailer_init();
                        $mail->setFrom('aventurago.contacto@gmail.com', 'AventuraGO');
                        $mail->addAddress($detalle['email_turista'], $detalle['nombre_turista'] ?? '');
                        $mail->Subject = '✅ Tu reserva de hospedaje fue confirmada — AventuraGO';
                        $fechaFmt = date('d/m/Y', strtotime($detalle['fecha']));
                        $mail->Body = "
                        <div style='font-family:sans-serif;max-width:560px;margin:auto;background:#fff;border-radius:12px;overflow:hidden;border:1px solid #e5e7eb'>
                            <div style='background:#EA8217;padding:28px 24px;text-align:center'>
                                <h1 style='color:#fff;margin:0;font-size:22px'>¡Reserva confirmada! 🎉</h1>
                            </div>
                            <div style='padding:28px 24px'>
                                <p style='color:#374151;font-size:15px'>Hola <strong>" . htmlspecialchars($detalle['nombre_turista'] ?? '') . "</strong>,</p>
                                <p style='color:#374151;font-size:14px'>Tu reserva de hospedaje ha sido <strong>confirmada</strong> por el establecimiento.</p>
                                <div style='background:#f9fafb;border-radius:8px;padding:16px;margin:20px 0'>
                                    <p style='margin:6px 0;font-size:14px;color:#374151'><strong>🏨 Hospedaje:</strong> " . htmlspecialchars($detalle['nombre_hospedaje'] ?? '') . "</p>
                                    <p style='margin:6px 0;font-size:14px;color:#374151'><strong>🏢 Establecimiento:</strong> " . htmlspecialchars($detalle['nombre_empresa'] ?? '') . "</p>
                                    <p style='margin:6px 0;font-size:14px;color:#374151'><strong>📅 Fecha de llegada:</strong> $fechaFmt</p>
                                    <p style='margin:6px 0;font-size:14px;color:#374151'><strong>👥 Personas:</strong> " . (int)$detalle['cantidad_personas'] . "</p>
                                    <p style='margin:6px 0;font-size:14px;color:#EA8217;font-weight:700'><strong>💰 Precio total:</strong> $" . number_format(($detalle['precio'] ?? 0), 0, ',', '.') . " COP</p>
                                </div>
                                <p style='color:#6b7280;font-size:13px'>Puedes consultar el estado de todas tus reservas desde tu panel de turista en AventuraGO.</p>
                            </div>
                            <div style='background:#f3f4f6;padding:14px 24px;text-align:center'>
                                <p style='color:#9ca3af;font-size:12px;margin:0'>AventuraGO · aventurago.com.co</p>
                            </div>
                        </div>";
                        $mail->send();
                    }
                } catch (\Exception $e) {
                    error_log('Email confirmar reserva hotelera: ' . $e->getMessage());
                }
                mostrarSweetAlert('success', 'Reserva confirmada', 'La reserva ha sido marcada como confirmada');
            } else {
                mostrarSweetAlert('error', 'Error', 'No se pudo confirmar la reserva');
            }
        } else {
            mostrarSweetAlert('error', 'Acceso denegado', 'Esta reserva no pertenece a su establecimiento');
        }
        header('Location: ' . BASE_URL . 'proveedor_hotelero/consultar-reservas');
        exit;
    }

    if ($accion === 'cancelar' && $id) {
        if ($reservaModel->verificarReservaDeProveedor($id, $id_proveedor_hotelero)) {
            if ($reservaModel->cancelarReserva($id)) {
                mostrarSweetAlert('info', 'Reserva cancelada', 'La reserva ha sido cancelada');
            } else {
                mostrarSweetAlert('error', 'Error', 'No se pudo cancelar la reserva');
            }
        } else {
            mostrarSweetAlert('error', 'Acceso denegado', 'Esta reserva no pertenece a su establecimiento');
        }
        header('Location: ' . BASE_URL . 'proveedor_hotelero/consultar-reservas');
        exit;
    }
}

$filtro       = $_GET['filtro'] ?? '';
$reservas     = $id_proveedor_hotelero ? $reservaModel->listarPorProveedor($id_proveedor_hotelero, $filtro) : [];
$estadisticas = $id_proveedor_hotelero ? $reservaModel->obtenerEstadisticas($id_proveedor_hotelero) : [];

require_once __DIR__ . '/../../views/dashboard/proveedor_hotelero/consultar_reservas.php';
