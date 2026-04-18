<?php

require_once __DIR__ . '/../../helpers/alert_helper.php';
require_once __DIR__ . '/../../models/proveedor_turistico/ActividadTuristica.php';

class WebsiteController
{
    // Página pública: /descubre-tours
    public function descubreTours()
    {
        $actividadModel = new ActividadTuristica();

        $ciudad = $_GET['ciudad'] ?? null;

        if ($ciudad) {
            $actividades = $actividadModel->obtenerPorCiudad($ciudad);
        } else {
            $actividades = $actividadModel->listarActividadesPublicas();
        }
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

        // 🔥 Obtener fechas que ya están llenas
        $fechasLlenas = $actividadModel->obtenerFechasLlenas($idActividad);

        require BASE_PATH . '/app/views/website/tour_escogido.php';
    }

    // Página pública: /formulario-reserva
    public function formularioReserva()
    {
        session_start();

        // 🔥 CASO 1: viene del TOUR (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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

            $actividadModel = new ActividadTuristica();
            $actividad = $actividadModel->obtenerActividadPorId($idActividad);

            if (!$actividad || $actividad['estado'] !== 'ACTIVO') {
                header('Location: ' . BASE_URL . '/descubre-tours');
                exit;
            }

            // 🔥 VALIDAR CUPOS ANTES DE PASAR AL FORMULARIO
            if (!$actividadModel->hayCuposDisponibles($idActividad, $fecha, $cantidad)) {

                mostrarSweetAlert(
                    "error",
                    "Sin cupos disponibles",
                    "Lo sentimos, no hay cupos suficientes para la fecha seleccionada.",
                    BASE_URL . "/tour-escogido?id=" . $idActividad
                );

                exit;
            }

            $precioUnitario = (float) $actividad['precio'];
            $total = $precioUnitario * $cantidad;

            $_SESSION['reserva_tmp'] = [
                'id_actividad' => $idActividad,
                'nombre'       => $actividad['nombre'],
                'imagen'       => $actividad['imagen'],
                'cantidad'     => $cantidad,
                'fecha'        => $fecha,
                'precio'       => $precioUnitario,
                'total'        => $total
            ];
        }

        // 🔥 CASO 2: viene del LOGIN (GET)
        if (!isset($_SESSION['reserva_tmp'])) {
            header('Location: ' . BASE_URL . '/descubre-tours');
            exit;
        }

        $reserva = $_SESSION['reserva_tmp'];

        $idActividad    = $reserva['id_actividad'];
        $cantidad       = $reserva['cantidad'];
        $fecha          = $reserva['fecha'];
        $precioUnitario = $reserva['precio'];
        $total          = $reserva['total'];

        $actividadModel = new ActividadTuristica();
        $actividad = $actividadModel->obtenerActividadPorId($idActividad);

        require BASE_PATH . '/app/views/website/formulario_reserva.php';
    }
}
