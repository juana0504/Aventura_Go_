<?php

class WebsiteController
{
    public function tourEscogido()
    {
        // Recibir el ID desde la URL
        $idActividad = $_GET['id'] ?? null;

        if (!$idActividad) {
            header('Location: ' . BASE_URL . '/website/descubre_tours');
            exit;
        }

        // Aquí luego consultarás el modelo (más adelante)
        // Por ahora solo cargamos la vista

        require_once BASE_PATH . '/app/views/website/tour_escogido.php';
    }
}
