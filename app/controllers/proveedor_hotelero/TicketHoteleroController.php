<?php
require_once __DIR__ . '/../../helpers/session_proveedor_hotelero.php';
require_once __DIR__ . '/../../helpers/alert_helper.php';
require_once __DIR__ . '/../../models/ticket.php';

class TicketHoteleroController
{
    private $ticketModel;

    public function __construct()
    {
        $this->ticketModel = new Ticket();
    }

    public function listar()
    {
        $id_usuario = $_SESSION['user']['id_usuario'];
        $tickets    = $this->ticketModel->listarPorUsuario($id_usuario);
        require_once BASE_PATH . '/app/views/dashboard/proveedor_hotelero/listar_tickets.php';
    }

    public function crear()
    {
        require_once BASE_PATH . '/app/views/dashboard/proveedor_hotelero/crear_ticket.php';
    }

    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'proveedor_hotelero/tickets');
            exit;
        }

        $id_usuario  = $_SESSION['user']['id_usuario'];
        $asunto      = trim($_POST['asunto'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');

        if (empty($asunto) || empty($descripcion)) {
            mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completa todos los campos');
            exit;
        }

        $this->ticketModel->crear($id_usuario, $asunto, $descripcion);

        mostrarSweetAlert('success', 'Ticket enviado', 'Tu ticket fue creado correctamente', BASE_URL . 'proveedor_hotelero/tickets');
    }
}
