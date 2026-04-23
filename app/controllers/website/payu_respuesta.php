<?php
session_start();

// Validar sesión mínima
if (!isset($_SESSION['id_reserva']) || !isset($_SESSION['id_pago'])) {
    header('Location: ' . BASE_URL . '/descubre-tours');
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

    // Redirigir a confirmación
    header('Location: ' . BASE_URL . '/confirmacion');
    exit;
} else {

    // Si fuera rechazado
    $stmtPago = $pdo->prepare("UPDATE pago SET estado = 'rechazado' WHERE id_pago = :id");
    $stmtPago->execute([':id' => $idPago]);

    header('Location: ' . BASE_URL . '/checkout');
    exit;
}
