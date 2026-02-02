<?php
require_once __DIR__ . '/../../models/Ticket.php';
require_once __DIR__ . '/../../helpers/alert_helper.php';
// CAMBIO: Usar la sesión de turista
require_once __DIR__ . '/../../helpers/session_turista.php';

class TicketTuristaController // NOMBRE NUEVO
{
    private $ticketModel;

    public function __construct()
    {
        $this->ticketModel = new Ticket();
    }

    public function listar()
    {
        $id_usuario = $_SESSION['user']['id'];
        $tickets = $this->ticketModel->listarPorUsuario($id_usuario);

        // CAMBIO: Ruta a la carpeta de turista
        require_once __DIR__ . '/../../views/dashboard/turista/listar.php';
    }

    public function crear()
    {
        require_once __DIR__ . '/../../views/dashboard/turista/crear_ticket.php';
    }

    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/turista/tickets');
            exit();
        }

        $id_usuario = $_SESSION['user']['id_usuario'];
        $asunto = trim($_POST['asunto']);
        $descripcion = trim($_POST['descripcion']);

        // CAMBIO: Al guardar, redirigir a rutas de turista
        $this->ticketModel->crear($id_usuario, $asunto, $descripcion);

        mostrarSweetAlert(
            'success',
            'Ticket enviado',
            'Tu ticket fue creado correctamente',
            BASE_URL . '/turista/tickets'
        );
    }
}
