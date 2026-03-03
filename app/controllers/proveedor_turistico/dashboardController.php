<?php

require_once BASE_PATH . '/app/helpers/session_proveedor.php';
require_once BASE_PATH . '/app/models/proveedor_turistico/Reserva.php';
require_once BASE_PATH . '/app/models/proveedor_turistico/actividadTuristica.php';
require_once BASE_PATH . '/app/models/proveedor_turistico/Proveedor.php';

class DashboardProveedorController
{
    private $reservaModel;
    private $actividadModel;
    private $proveedorModel;

    public function __construct()
    {
        $this->reservaModel = new Reserva();
        $this->actividadModel = new actividadTuristica();
        $this->proveedorModel = new Proveedor();
    }

    public function index()
    {
        // obtener id de proveedor a partir del usuario en sesión
        $usuarioId = $_SESSION['user']['id_usuario'];
        $idProveedor = $this->proveedorModel->obtenerIdProveedorPorUsuario($usuarioId);

        // estadísticas generales
        $totalServicios = $this->actividadModel->contarPorProveedor($idProveedor);
        $stats = $this->reservaModel->obtenerEstadisticas($idProveedor);
        $totalReservas = $stats['total_reservas'] ?? 0;
        $ingresosPotenciales = $stats['ingresos_potenciales'] ?? 0;

        // lista de reservas recientes para tabla
        $reservasRecientes = $this->reservaModel->listarPorProveedor($idProveedor);

        // estado del proveedor (activo/inactivo)
        $estado = 'Activo'; // podría consultarse si se desea

        require BASE_PATH . '/app/views/dashboard/proveedor_turistico/dashboard.php';
    }

    public function data()
    {
        header('Content-Type: application/json');
        $usuarioId = $_SESSION['user']['id_usuario'];
        $idProveedor = $this->proveedorModel->obtenerIdProveedorPorUsuario($usuarioId);

        $tipo = $_GET['tipo'] ?? 'dias';
        $graficoReservas = [];
        switch ($tipo) {
            case 'anio':
                if (isset($_GET['anio']) && is_numeric($_GET['anio'])) {
                    $graficoReservas = $this->reservaModel->getReservasPorAniosProveedor($idProveedor, (int)$_GET['anio']);
                } else {
                    $graficoReservas = $this->reservaModel->getReservasPorAniosProveedor($idProveedor);
                }
                break;
            case 'mes':
                if (isset($_GET['anio']) && is_numeric($_GET['anio'])) {
                    $anio = (int)$_GET['anio'];
                    $graficoReservas = $this->reservaModel->getReservasPorMesProveedor($idProveedor, $anio);
                } else {
                    $graficoReservas = $this->reservaModel->getReservasPorMesGlobalProveedor($idProveedor);
                }
                break;
            default:
                $dias = isset($_GET['dias']) && is_numeric($_GET['dias']) ? (int)$_GET['dias'] : 7;
                $graficoReservas = $this->reservaModel->getReservasPorDiaProveedor($idProveedor, $dias);
                break;
        }

        echo json_encode(['graficoReservas' => $graficoReservas]);
        exit;
    }

    public function filtrarReservas()
    {
        header('Content-Type: application/json');
        $usuarioId = $_SESSION['user']['id_usuario'];
        $idProveedor = $this->proveedorModel->obtenerIdProveedorPorUsuario($usuarioId);

        $tipo = $_GET['tipo'] ?? 'anio';
        $anio = isset($_GET['anio']) ? (int)$_GET['anio'] : null;
        $mes = isset($_GET['mes']) ? (int)$_GET['mes'] : null;

        // Obtener todas las reservas del proveedor
        $reservas = $this->reservaModel->listarPorProveedor($idProveedor);

        // Filtrar por año y mes en PHP
        $reservasFiltradas = [];
        foreach ($reservas as $r) {
            $fecha = strtotime($r['fecha']);
            $anioReserva = date('Y', $fecha);
            $mesReserva = date('m', $fecha);

            $cumpleAno = ($anio === null || $anioReserva == $anio);
            $cumpleMes = ($mes === null || $mesReserva == str_pad($mes, 2, '0', STR_PAD_LEFT));

            if ($cumpleAno && $cumpleMes) {
                $reservasFiltradas[] = $r;
            }
        }

        echo json_encode(['reservas' => $reservasFiltradas]);
        exit;
    }
}
