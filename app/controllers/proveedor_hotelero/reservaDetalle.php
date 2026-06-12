<?php
require_once __DIR__ . '/../../helpers/session_proveedor_hotelero.php';
require_once __DIR__ . '/../../models/proveedor_hotelero/ReservaHotelero.php';
require_once __DIR__ . '/../../models/proveedor_hotelero/Proveedor_hotelero.php';

header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');

$id_reserva = $_GET['id'] ?? '';

if (empty($id_reserva) || !is_numeric($id_reserva)) {
    echo json_encode(['success' => false, 'message' => 'ID de reserva no válido']);
    exit;
}

$reservaModel          = new ReservaHotelero();
$id_proveedor_hotelero = (new Proveedor())->obtenerIdProveedorPorUsuario($_SESSION['user']['id_usuario']);

if (!$reservaModel->verificarReservaDeProveedor($id_reserva, $id_proveedor_hotelero)) {
    echo json_encode(['success' => false, 'message' => 'Acceso denegado']);
    exit;
}

$d = $reservaModel->listarPorId($id_reserva);

if (!$d) {
    echo json_encode(['success' => false, 'message' => 'Reserva no encontrada']);
    exit;
}

echo json_encode([
    'success' => true,
    'data' => [
        'id_reserva'           => $d['id_reserva'],
        'fecha'                => $d['fecha'],
        'estado'               => $d['estado'],
        'cantidad_personas'    => $d['cantidad_personas'],
        'created_at'           => $d['created_at'],
        'nombre_hospedaje'     => $d['nombre_hospedaje'],
        'descripcion_hospedaje'=> $d['descripcion_hospedaje'],
        'ubicacion'            => $d['ubicacion'],
        'precio'               => $d['precio'],
        'capacidad'            => $d['capacidad'],
        'nombre_turista'       => $d['nombre_turista'],
        'email_turista'        => $d['email_turista'],
        'telefono_turista'     => $d['telefono_turista'],
        'nombre_empresa'       => $d['nombre_empresa'],
        'total'                => (float)$d['precio'] * (int)$d['cantidad_personas'],
    ]
]);
exit;
