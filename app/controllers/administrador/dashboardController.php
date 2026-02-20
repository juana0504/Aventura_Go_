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
        // recolectar datos estadísticos
        $totalReservas = $this->model->getTotalReservas();
        $reservasDiarias = $this->model->getReservasDiarias();
        $experienciasActivas = $this->model->getExperienciasActivas();
        $ingresosDisponibles = $this->model->getIngresosDisponibles();
        $ultimaReserva = $this->model->getUltimaReserva();

        // datos para los gráficos (ejemplos simples)
        $graficoReservas = $this->model->getReservasPorDia(7); // últimos 7 días
        $graficoGastos = $this->model->getGastosPorCategoria();
        // datos de ejemplo para el panel de "próximos pagos" (puede reemplazarse con consulta real)
        $proximosPagos = [
            ['texto'=>'Pago Experiencia','cantidad'=>2852.21,'color'=>'green_r'],
            ['texto'=>'Pago a Operador','cantidad'=>910.00,'color'=>'blue_r'],
            ['texto'=>'Pago de Reserva','cantidad'=>420.30,'color'=>'red_r'],
        ];
        // gastos por categoría (ejemplo que podría usarse en gráfico)
        $gastosChartData = $graficoGastos;

        require BASE_PATH . '/app/views/dashboard/administrador/administrador.php';
    }
}