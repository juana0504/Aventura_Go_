<?php
require_once __DIR__ . '/../../models/Ticket.php';
require_once __DIR__ . '/../../helpers/alert_helper.php';

session_start();

// 🔐 Seguridad básica: validar sesión y rol
if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] !== 'proveedor-turistico') {
    header('Location: /aventura_go/login');
    exit();
}

$ticketModel = new Ticket();

// 📌 Detectar acción por GET o POST
$accion = $_GET['accion'] ?? 'listar';

switch ($accion) {

    // 📝 Crear ticket (FORMULARIO)
    case 'crear':
        require_once __DIR__ . '/../../views/dashboard/proveedor_turistico/crear_ticket.php';
        break;

    // 💾 Guardar ticket (POST)
    case 'guardar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $asunto = trim($_POST['asunto'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $id_usuario = $_SESSION['user']['id'];

            if (empty($asunto) || empty($descripcion)) {
                mostrarSweetAlert(
                    'error',
                    'Campos incompletos',
                    'Debes completar todos los campos'
                );
                exit();
            }

            $resultado = $ticketModel->crear($id_usuario, $asunto, $descripcion);

            if ($resultado) {
                mostrarSweetAlert(
                    'success',
                    'Ticket creado',
                    'Tu reporte fue enviado correctamente',
                    '/aventura_go/proveedor_turistico/tickets'
                );
            } else {
                mostrarSweetAlert(
                    'error',
                    'Error',
                    'No se pudo crear el ticket'
                );
            }
        }
        break;

    // 📋 Listar tickets del proveedor
    default:
        $id_usuario = $_SESSION['user']['id'];
        $tickets = $ticketModel->listarPorUsuario($id_usuario);
        require_once __DIR__ . '/../../views/dashboard/proveedor_turistico/listar.php';
        break;
}
