<?php
require_once __DIR__ . '/../../helpers/session_proveedor_hotelero.php';
require_once __DIR__ . '/../../models/proveedor_hotelero/Proveedor_hotelero.php';
require_once __DIR__ . '/../../models/proveedor_hotelero/ProveedorModel.php';
require_once __DIR__ . '/../../models/proveedor_hotelero/hospedaje.php';
require_once __DIR__ . '/../../models/proveedor_hotelero/ReservaHotelero.php';

$id_usuario            = $_SESSION['user']['id_usuario'];
$proveedorHotelero     = new Proveedor();
$id_proveedor_hotelero = $proveedorHotelero->obtenerIdProveedorPorUsuario($id_usuario);

$proveedorInfo         = (new ProveedorModel())->obtenerPorUsuario($id_usuario);
$estado                = $proveedorInfo['estado'] ?? 'PENDIENTE';

$hospedajeModel        = new Hospedaje();
$totalServicios        = $id_proveedor_hotelero ? $hospedajeModel->contarPorProveedor((int)$id_proveedor_hotelero) : 0;

$reservaModel          = new ReservaHotelero();
$stats                 = $id_proveedor_hotelero ? $reservaModel->obtenerEstadisticas($id_proveedor_hotelero) : [];
$totalReservas         = (int)($stats['total'] ?? 0);
$ingresosPotenciales   = (float)($stats['ingresos_potenciales'] ?? 0);

$reservasRecientes     = $id_proveedor_hotelero ? $reservaModel->obtenerRecentesParaDashboard($id_proveedor_hotelero, 10) : [];

require BASE_PATH . '/app/views/dashboard/proveedor_hotelero/dashboard.php';
