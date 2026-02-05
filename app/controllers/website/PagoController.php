<?php
session_start();

/* 1. Validar que venga desde el checkout (POST)*/
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/checkout');
    exit;
}



/*| 2. Validar que exista la reserva temporal*/
if (!isset($_SESSION['reserva_tmp'])) {
    header('Location: ' . BASE_URL . '/descubre-tours');
    exit;
}



/*| 3. Validar datos obligatorios del formulario*/
$required = ['nombre', 'email', 'telefono', 'metodo_pago', 'reference', 'total'];

foreach ($required as $field) {
    if (empty($_POST[$field])) {
        header('Location: ' . BASE_URL . '/checkout');
        exit;
    }
}



/*| 4. Limpiar y capturar datos*/
$datosPago = [
    'reference'     => $_POST['reference'],
    'total'         => $_POST['total'],
    'currency'      => $_POST['currency'] ?? 'COP',
    'descripcion'   => $_POST['descripcion'] ?? 'Reserva Aventura Go',
    'metodo_pago'   => $_POST['metodo_pago'],

    'cliente' => [
        'nombre'   => trim($_POST['nombre']),
        'email'    => trim($_POST['email']),
        'telefono' => trim($_POST['telefono']),
    ]
];



/* 5. Guardar datos de pago en sesión (TEMPORAL)
|  OJO: aún NO es pago real */
$_SESSION['pago_tmp'] = $datosPago;

require_once BASE_PATH . '/config/database.php';

$db = new conexion();
$pdo = $db->getConexion();

// Datos desde la sesión de reserva temporal
$reservaTmp = $_SESSION['reserva_tmp'];

// Si el usuario está logueado como turista, tomamos su ID, si no, null
$idTurista = $_SESSION['user']['id_usuario'] ?? null;

// Insertar reserva en estado PENDIENTE
$sql = "INSERT INTO reserva 
    (id_turista, id_actividad, fecha, estado, tipo_reserva, cantidad_personas, precio)
    VALUES 
    (:id_turista, :id_actividad, :fecha, :estado, :tipo_reserva, :cantidad_personas, :precio)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':id_turista'        => $idTurista,
    ':id_actividad'      => $reservaTmp['id_actividad'],
    ':fecha'             => $reservaTmp['fecha'],
    ':estado'            => 'pendiente',
    ':tipo_reserva'      => 'actividad',
    ':cantidad_personas' => $reservaTmp['cantidad'],
    ':precio'            => $reservaTmp['total'],
]);

// Obtener el ID de la reserva recién creada
$idReserva = $pdo->lastInsertId();

// Guardar en sesión para usarlo luego en el pago
$_SESSION['id_reserva'] = $idReserva;





// 6: Crear registro en tabla pago (PENDIENTE)

// Datos del pago desde sesión
$pagoTmp = $_SESSION['pago_tmp'];

// Si hay usuario logueado, usamos su id, si no, null
$idUsuario = $_SESSION['user']['id_usuario'] ?? null;

// Insertar pago en estado PENDIENTE
$sqlPago = "INSERT INTO pago 
    (id_reserva, id_usuario, monto, metodo_pago, referencia_pago, fecha, estado)
    VALUES
    (:id_reserva, :id_usuario, :monto, :metodo_pago, :referencia_pago, :fecha, :estado)";

$stmtPago = $pdo->prepare($sqlPago);
$stmtPago->execute([
    ':id_reserva'      => $_SESSION['id_reserva'],
    ':id_usuario'      => $idUsuario,
    ':monto'           => $pagoTmp['total'],
    ':metodo_pago'     => $pagoTmp['metodo_pago'],
    ':referencia_pago' => $pagoTmp['reference'],
    ':fecha'           => date('Y-m-d'),
    ':estado'          => 'pendiente',
]);

// (Opcional por ahora) Guardar el id del pago si luego lo necesitas
$_SESSION['id_pago'] = $pdo->lastInsertId();







/*| 7. Redirigir según el método de pago*/
switch ($datosPago['metodo_pago']) {

    case 'payu':
        header('Location: ' . BASE_URL . '/pago/payu');
        exit;

    case 'mercadopago':
        header('Location: ' . BASE_URL . '/pago/mercadopago');
        exit;

    default:
        // Método no válido
        header('Location: ' . BASE_URL . '/checkout');
        exit;
}
