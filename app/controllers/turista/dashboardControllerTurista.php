<?php

require_once __DIR__ . '/../../helpers/session_turista.php';
require_once __DIR__ . '/../../helpers/alert_helper.php';
// modelo propio del turista
require_once __DIR__ . '/../../models/turista/TuristaModel.php';
// modelo de actividades del proveedor (se usa para reservar/ver detalles)
require_once __DIR__ . '/../../models/proveedor_turistico/ActividadTuristica.php'; // ruta correcta según estructura

// DATOS PARA VISTAS (GET)
// el modelo y el id del usuario estarán disponibles para las funciones
$turistaModel = new TuristaModel();
$id_usuario = $_SESSION['user']['id_usuario'];  // ID del usuario logueado

// MÉTODO HTTP
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // POST → REGISTRAR / RESERVAR ACTIVIDAD
    case 'POST':
        $accion = $_POST['accion'] ?? '';

        if ($accion === 'reservar') {
            reservarActividad(); // Llamar la función para reservar actividad
        }
        break;

    // GET → CARGAR VISTAS / LISTAR ACTIVIDADES / VER DETALLES
    case 'GET':
        $accion = $_GET['accion'] ?? '';

        if ($accion === 'reservar') {
            reservarActividad(); // Llamar a la función para reservar actividad
        }

        if (isset($_GET['id_actividad'])) {
            // Mostrar detalles de la actividad seleccionada
            verActividad($_GET['id_actividad']);
        } else {
            // Mostrar lista de actividades y lugares visitados
            listarActividades();
        }
        break;

    default:
        http_response_code(405);
        echo "❌ Método no permitido";
        break;
}

// FUNCIONES

// Función para listar las actividades turísticas disponibles para el turista
function listarActividades() {
    global $turistaModel;
    $id_usuario = $_SESSION['user']['id_usuario'];  // Obtener el id del usuario de la sesión

    // Obtenemos los datos del turista
    $datos_turista = $turistaModel->getDashboardDataByUserId($id_usuario);

    if (!$datos_turista) {
        // si no hay fila, puede ser un usuario sin perfil de turista.
        error_log("[DashboardTurista] usuario $id_usuario sin perfil de turista");
        $datos_turista = [
            'nombre' => '',
            'preferencias' => '',
            'actividades' => [],
            'lugares_visitados' => []
        ];
    }

    // aseguramos que siempre haya un nombre; caemos en la sesión si no existe
    if (empty($datos_turista['nombre']) && !empty($_SESSION['user']['nombre'])) {
        $datos_turista['nombre'] = $_SESSION['user']['nombre'];
    }

    // Cargar la vista con los datos (pueden ser vacíos)
    require_once BASE_PATH . '/app/views/dashboard/turista/dashboardTurista.php';
}

// Función para ver los detalles de una actividad seleccionada
function verActividad($id_actividad) {
    global $actividadModel;

    // Obtenemos los detalles de la actividad seleccionada
    $actividadModel = new ActividadTuristica();
    $actividad = $actividadModel->obtenerActividadPorId($id_actividad);

    if (!$actividad) {
        mostrarSweetAlert('error', 'Actividad no encontrada', 'No se encontraron detalles para esta actividad.');
        exit;
    }

    // Cargar la vista de detalles de la actividad
    require_once BASE_PATH . '/app/views/dashboard/turista/tour_escogido.php';
}

// Función para realizar una reserva
function reservarActividad() {
    global $actividadModel;

    $id_actividad = $_POST['id_actividad'] ?? null;
    $cantidad = $_POST['cantidad'] ?? 1;

    if (!$id_actividad) {
        mostrarSweetAlert('error', 'Actividad no seleccionada', 'No seleccionaste ninguna actividad para reservar.');
        exit;
    }

    // Verificamos si la actividad existe y si tiene cupos disponibles
    $actividad = $actividadModel->obtenerActividadPorId($id_actividad);

    if (!$actividad || $actividad['cupos'] <= 0) {
        mostrarSweetAlert('error', 'Cupos insuficientes', 'No hay suficientes cupos para esta actividad.');
        exit;
    }

    // Descontamos los cupos
    $actividadModel->descontarCupos($id_actividad, $cantidad);

    mostrarSweetAlert('success', 'Reserva exitosa', 'Has reservado la actividad correctamente.', '/aventura_go/turista/dashboard');

    
}
