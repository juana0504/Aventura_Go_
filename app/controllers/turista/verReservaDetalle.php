<?php
require_once __DIR__ . '/../../helpers/session_turista.php';
require_once __DIR__ . '/../../models/turista/ReservaTurista.php';

// Configurar headers para respuesta JSON
header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');

// Obtener ID de la reserva desde la URL
$id_reserva = $_GET['id'] ?? '';

// Validar que se proporcionó un ID
if (empty($id_reserva) || !is_numeric($id_reserva)) {
    echo json_encode([
        'success' => false, 
        'message' => 'ID de reserva no válido o no proporcionado'
    ]);
    exit;
}

// Inicializar modelo
$reservaModel = new ReservaTurista();
$id_turista = $_SESSION['user']['id'];

try {
    // Verificar seguridad: la reserva debe pertenecer al turista actual
    if (!$reservaModel->verificarReservaDeTurista($id_reserva, $id_turista)) {
        echo json_encode([
            'success' => false, 
            'message' => 'Acceso denegado: esta reserva no pertenece a su cuenta'
        ]);
        exit;
    }
    
    // Obtener detalles completos de la reserva
    $detalles = $reservaModel->listarPorId($id_reserva, $id_turista);
    
    if ($detalles) {
        // Formatear datos para el frontend
        $response = [
            'success' => true,
            'data' => [
                'id_reserva' => $detalles['id_reserva'],
                'fecha' => $detalles['fecha'],
                'estado' => $detalles['estado'],
                'cantidad_personas' => $detalles['cantidad_personas'],
                'created_at' => $detalles['created_at'],
                'nombre_actividad' => $detalles['nombre_actividad'],
                'descripcion_actividad' => $detalles['descripcion_actividad'],
                'ubicacion' => $detalles['ubicacion'],
                'precio' => $detalles['precio'],
                'cupos' => $detalles['cupos'],
                'imagen' => $detalles['imagen'],
                'nombre_empresa' => $detalles['nombre_empresa'],
                'email_representante' => $detalles['email_representante'],
                'telefono_representante' => $detalles['telefono_representante'],
                'direccion' => $detalles['direccion'],
                'nombre_ciudad' => $detalles['nombre_ciudad'],
                'nombre_departamento' => $detalles['nombre_departamento'],
                'total' => $detalles['precio'] * $detalles['cantidad_personas']
            ]
        ];
        
        echo json_encode($response);
        
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'Reserva no encontrada en la base de datos'
        ]);
    }
    
} catch (Exception $e) {
    // Log del error para depuración
    error_log("Error en verReservaDetalle.php: " . $e->getMessage());
    
    echo json_encode([
        'success' => false, 
        'message' => 'Error interno del servidor al obtener detalles de la reserva'
    ]);
}
?>