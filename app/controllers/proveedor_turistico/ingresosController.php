<?php

require_once BASE_PATH . '/app/helpers/session_proveedor.php';
require_once BASE_PATH . '/app/models/proveedor_turistico/Reserva.php';
require_once BASE_PATH . '/app/models/proveedor_turistico/Proveedor.php';

class IngresosProveedorController
{
    private $reservaModel;
    private $proveedorModel;

    public function __construct()
    {
        $this->reservaModel = new Reserva();
        $this->proveedorModel = new Proveedor();
    }

    public function index()
    {
        $usuarioId = $_SESSION['user']['id_usuario'];
        $idProveedor = $this->proveedorModel->obtenerIdProveedorPorUsuario($usuarioId);

        $ingresos = [];
        if ($idProveedor) {
            $ingresos = $this->reservaModel->listarIngresosPorProveedor($idProveedor);
        }

        require BASE_PATH . '/app/views/dashboard/proveedor_turistico/ingresos.php';
    }
}
