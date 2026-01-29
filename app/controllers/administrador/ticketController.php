<?php
require_once __DIR__ . '/../../models/Ticket.php';
require_once __DIR__ . '/../../helpers/alert_helper.php';
require_once __DIR__ . '/../../helpers/session_admin.php';

class TicketAdminController
{
    private $ticketModel;

    public function __construct()
    {
        $this->ticketModel = new Ticket();
    }

    // 📋 LISTAR TODOS LOS TICKETS
    public function listar()
    {
        $tickets = $this->ticketModel->listarTodos();
        require BASE_PATH . '/app/views/dashboard/administrador/tickets/listar.php';
    }

    // ✍️ FORMULARIO RESPONDER
    public function responderForm($id_ticket)
    {
        $ticket = $this->ticketModel->buscarPorId($id_ticket);

        if (!$ticket) {
            mostrarSweetAlert(
                'error',
                'Ticket no encontrado',
                'El ticket no existe',
                BASE_URL . '/administrador/tickets'
            );
            exit();
        }

        require BASE_PATH . '/app/views/dashboard/administrador/tickets/responder.php';
    }

    public function buscarPorId($id_ticket)
    {
        $sql = "
            SELECT t.*, u.nombre
            FROM tickets t
            INNER JOIN usuario u ON u.id_usuario = t.id_usuario
            WHERE t.id_ticket = :id
            LIMIT 1
        ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id_ticket, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // 💾 GUARDAR RESPUESTA
    public function responder()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Método no permitido');
        }

        $id_ticket = $_POST['id_ticket'] ?? null;
        $respuesta = trim($_POST['respuesta'] ?? '');

        if (empty($id_ticket) || empty($respuesta)) {
            mostrarSweetAlert(
                'error',
                'Campos obligatorios',
                'La respuesta no puede estar vacía',
                BASE_URL . '/administrador/tickets'
            );
            exit();
        }

        $this->ticketModel->responder($id_ticket, $respuesta);

        mostrarSweetAlert(
            'success',
            'Ticket respondido',
            'La respuesta fue enviada correctamente',
            BASE_URL . '/administrador/tickets'
        );
    }

    // ❌ CERRAR TICKET
    public function cerrar()
    {
        $id_ticket = $_GET['id'] ?? null;

        if (!$id_ticket) {
            mostrarSweetAlert(
                'error',
                'Error',
                'ID inválido',
                BASE_URL . '/administrador/tickets'
            );
            exit();
        }

        $this->ticketModel->cerrar($id_ticket);

        mostrarSweetAlert(
            'success',
            'Ticket cerrado',
            'El ticket fue cerrado correctamente',
            BASE_URL . '/administrador/tickets'
        );
    }
}
