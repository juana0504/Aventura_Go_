<?php

require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/models/administrador/AdminDashboardModel.php';

class DashboardAdminController
{
    private $model;

    public function __construct()
    {
        $this->model = new AdminDashboardModel();
    }

    /**
     * Muestra la página principal del dashboard de administrador con estadísticas.
     */
    public function index()
    {
        // recolectar datos estadísticos para mostrar en las tarjetas y tablas
        $totalReservas = $this->model->getTotalReservas();
        $reservasDiarias = $this->model->getReservasDiarias();
        $experienciasActivas = $this->model->getExperienciasActivas();
        $ingresosDisponibles = $this->model->getIngresosDisponibles();
        $ultimaReserva = $this->model->getUltimaReserva();
        $inversionPublicidad = $this->model->getInversionPublicidad();

        // datos de ejemplo para el panel de "próximos pagos" (puede reemplasarse con consulta real)
        $proximosPagos = [
            ['texto'=>'Pago Experiencia','cantidad'=>2852.21,'color'=>'green_r'],
            ['texto'=>'Pago a Operador','cantidad'=>910.00,'color'=>'blue_r'],
            ['texto'=>'Pago de Reserva','cantidad'=>420.30,'color'=>'red_r'],
        ];

        require BASE_PATH . '/app/views/dashboard/administrador/administrador.php';
    }

    /**
     * Devuelve JSON con datos usados para gráficos (reservas y gastos).
     * Esto permite que el JavaScript los solicite en tiempo de ejecución
     * y mantiene el view limpio de lógica.
     */
    public function data()
    {
        header('Content-Type: application/json');
        $respuesta = [
            'graficoReservas' => $this->model->getReservasPorDia(7),
            'gastosChartData' => $this->model->getGastosPorCategoria()
        ];
        echo json_encode($respuesta);
        exit;
    }
}