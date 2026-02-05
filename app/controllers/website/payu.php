<?php
session_start();

// 1. Validar que existan los datos mínimos
if (!isset($_SESSION['id_reserva']) || !isset($_SESSION['id_pago'])) {
    header('Location: ' . BASE_URL . '/descubre-tours');
    exit;
}

// 2. Conectar a la base de datos
require_once BASE_PATH . '/config/database.php';

$db = new conexion();
$pdo = $db->getConexion();

// 3. SIMULAMOS respuesta de PayU
// En producción esto vendría del gateway (aprobado / rechazado / pendiente)
$respuestaPayu = 'aprobado'; // <-- por ahora fijo

$idReserva = $_SESSION['id_reserva'];
$idPago    = $_SESSION['id_pago'];

if ($respuestaPayu === 'aprobado') {

    // 4. Actualizar pago a APROBADO
    $sqlPago = "UPDATE pago SET estado = 'aprobado' WHERE id_pago = :id_pago";
    $stmtPago = $pdo->prepare($sqlPago);
    $stmtPago->execute([
        ':id_pago' => $idPago
    ]);

    // 5. Actualizar reserva a CONFIRMADA
    $sqlReserva = "UPDATE reserva SET estado = 'confirmada' WHERE id_reserva = :id_reserva";
    $stmtReserva = $pdo->prepare($sqlReserva);
    $stmtReserva->execute([
        ':id_reserva' => $idReserva
    ]);

    // 6. Redirigir a una página de confirmación (por ahora puede ser simple)
    header('Location: ' . BASE_URL . '/confirmacion');
    exit;
} else {

    // Si fuera rechazado (por ahora no lo usamos, pero dejamos listo)
    $sqlPago = "UPDATE pago SET estado = 'rechazado' WHERE id_pago = :id_pago";
    $stmtPago = $pdo->prepare($sqlPago);
    $stmtPago->execute([
        ':id_pago' => $idPago
    ]);

    header('Location: ' . BASE_URL . '/checkout');
    exit;
}
