<?php
require_once __DIR__ . '/../../models/Ticket.php';
require_once __DIR__ . '/../../helpers/alert_helper.php';
require_once __DIR__ . '/../../helpers/session_proveedor.php';

class TicketProveedorController
{
    private $ticketModel;

    public function __construct()
    {
        $this->ticketModel = new Ticket();
    }

    // 📋 LISTAR tickets del proveedor
    public function listar()
    {
        session_start();
        $id_usuario = $_SESSION['user']['id'];

        $tickets = $this->ticketModel->listarPorUsuario($id_usuario);

        require_once __DIR__ . '/../../views/dashboard/proveedor_turistico/listar.php';
    }


    // 👁 VER DETALLE DEL TICKET (con respuesta)
    public function ver($id_ticket)
    {
        session_start();
        $id_usuario = $_SESSION['user']['id'];

        $ticket = $this->ticketModel->buscarPorId($id_ticket);

        // Seguridad: que el ticket sea del proveedor
        if (!$ticket || $ticket['id_usuario'] != $id_usuario) {
            mostrarSweetAlert(
                'error',
                'Acceso denegado',
                'No puedes ver este ticket',
                BASE_URL . '/proveedor_turistico/listar'
            );
            exit();
        }

        require BASE_PATH . '/app/views/dashboard/proveedor_turistico/ver_ticket.php';
    }


    // 📝 MOSTRAR formulario crear ticket
    public function crear()
    {
        require_once __DIR__ . '/../../views/dashboard/proveedor_turistico/crear_ticket.php';
    }

    // 💾 GUARDAR ticket
    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Método no permitido');
        }

        session_start();
        $id_usuario = $_SESSION['user']['id'];

        $asunto = trim($_POST['asunto'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');

        if (empty($asunto) || empty($descripcion)) {
            mostrarSweetAlert(
                'error',
                'Campos obligatorios',
                'Debes completar todos los campos',
                BASE_URL . '/proveedor_turistico/crear_ticket'
            );
            exit();
        }

        $ok = $this->ticketModel->crear($id_usuario, $asunto, $descripcion);

        if ($ok) {
            mostrarSweetAlert(
                'success',
                'Ticket enviado',
                'Tu reporte fue enviado correctamente',
                BASE_URL . '/proveedor_turistico/listar'
            );
        } else {
            mostrarSweetAlert(
                'error',
                'Error',
                'No se pudo enviar el ticket',
                BASE_URL . '/proveedor_turistico/crear_ticket'
            );
        }
    }
}
