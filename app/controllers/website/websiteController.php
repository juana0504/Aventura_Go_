<?php

require_once __DIR__ . '/../../models/proveedor_turistico/ActividadTuristica.php';

class WebsiteController
{
    // Página pública: /descubre-tours
    public function descubreTours()
    {
        $actividadModel = new ActividadTuristica();
        $actividades = $actividadModel->listarActividadesPublicas();

        require BASE_PATH . '/app/views/website/descubre_tours.php';
    }

    // Página pública: /tour-escogido?id=XX
    public function tourEscogido()
    {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header('Location: ' . BASE_URL . '/descubre-tours');
            exit;
        }

        $idActividad = (int) $_GET['id'];

        $actividadModel = new ActividadTuristica();
        $actividad = $actividadModel->obtenerActividadPorId($idActividad);

        if (!$actividad) {
            header('Location: ' . BASE_URL . '/descubre-tours');
            exit;
        }

        require BASE_PATH . '/app/views/website/tour_escogido.php';
    }

    // Página pública: /formulario-reserva
    // public function formularioReserva()
    // {
    //     if (
    //         !isset($_POST['id_actividad']) ||
    //         !isset($_POST['cantidad_personas']) ||
    //         !isset($_POST['fecha'])
    //     ) {
    //         header('Location: ' . BASE_URL . '/descubre-tours');
    //         exit;
    //     }

    //     $idActividad = (int) $_POST['id_actividad'];
    //     $cantidad = (int) $_POST['cantidad_personas'];
    //     $fecha = $_POST['fecha'];

    //     $actividadModel = new ActividadTuristica();
    //     $actividad = $actividadModel->obtenerActividadPorId($idActividad);

    //     if (!$actividad) {
    //         header('Location: ' . BASE_URL . '/descubre-tours');
    //         exit;
    //     }

    //     require BASE_PATH . '/app/views/website/formulario_reserva.php';
    // }
    public function formularioReserva()
    {
        session_start();

        // Validar POST mínimo
        if (
            !isset($_POST['id_actividad']) ||
            !isset($_POST['cantidad_personas']) ||
            !isset($_POST['fecha'])
        ) {
            header('Location: ' . BASE_URL . '/descubre-tours');
            exit;
        }

        $idActividad = (int) $_POST['id_actividad'];
        $cantidad    = (int) $_POST['cantidad_personas'];
        $fecha       = $_POST['fecha'];

        // Usar el MISMO modelo que ya vienes usando para actividades públicas
        require_once __DIR__ . '/../../models/proveedor_turistico/ActividadTuristica.php';
        $actividadModel = new ActividadTuristica();
        $actividad = $actividadModel->obtenerActividadPorId($idActividad);

        if (!$actividad || $actividad['estado'] !== 'ACTIVO') {
            header('Location: ' . BASE_URL . '/descubre-tours');
            exit;
        }

        $precioUnitario = (float) $actividad['precio'];
        $total = $precioUnitario * $cantidad;

        // Guardar reserva temporal para checkout
        $_SESSION['reserva_tmp'] = [
            'id_actividad' => $idActividad,
            'nombre'       => $actividad['nombre'],
            'imagen'       => $actividad['imagen'],
            'cantidad'     => $cantidad,
            'fecha'        => $fecha,
            'precio'       => $precioUnitario,
            'total'        => $total
        ];

        // Variables que usará la vista
        // $actividad, $cantidad, $fecha, $precioUnitario, $total

        require BASE_PATH . '/app/views/website/formulario_reserva.php';
    }
}
