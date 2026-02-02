<?php

class WebsiteController
{
    public function tourEscogido()
    {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header('Location: ' . BASE_URL . '/website/descubre_tours');
            exit;
        }

        $idActividad = (int) $_GET['id'];

        require_once BASE_PATH . '/app/models/proveedor_turistico/ActividadTuristica.php';
        $actividadModel = new ActividadTuristica();

        // UNA sola actividad
        $actividad = $actividadModel->obtenerDetalleActividad($idActividad);

        if (!$actividad) {
            header('Location: ' . BASE_URL . '/website/descubre_tours');
            exit;
        }

        require_once BASE_PATH . '/app/views/website/tour_escogido.php';
    }
}
