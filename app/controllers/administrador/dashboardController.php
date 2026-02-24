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

        // lista completa de reservas recientes para la tabla
        $reservasRecientes = $this->model->getReservasRecientes(10);

        // obtener próximos pagos desde la base de datos
        $proximosPagos = $this->model->getProximosPagos();
        // el arreglo puede quedar vacío si no se encuentran pagos pendientes
        // la vista se encargará de mostrar el mensaje correspondiente.
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