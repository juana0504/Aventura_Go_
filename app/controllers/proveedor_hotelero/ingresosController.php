<?php
require_once BASE_PATH . '/app/helpers/session_proveedor_hotelero.php';
require_once BASE_PATH . '/app/models/proveedor_hotelero/ReservaHotelero.php';
require_once BASE_PATH . '/app/models/proveedor_hotelero/Proveedor_hotelero.php';

$id_proveedor_hotelero = (new Proveedor())->obtenerIdProveedorPorUsuario($_SESSION['user']['id_usuario']);

$ingresos = [];
if ($id_proveedor_hotelero) {
    $ingresos = (new ReservaHotelero())->listarIngresosPorProveedor($id_proveedor_hotelero);
}

require BASE_PATH . '/app/views/dashboard/proveedor_hotelero/ingresos.php';
