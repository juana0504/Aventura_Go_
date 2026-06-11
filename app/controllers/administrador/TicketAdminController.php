<?php

require_once BASE_PATH . '/app/models/ticket.php';
require_once BASE_PATH . '/app/helpers/alert_helper.php';
require_once BASE_PATH . '/app/helpers/session_administrador.php';

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
        if (!$id_ticket) {
            header('Location: ' . BASE_URL . 'administrador/tickets');
            exit();
        }

        $ticket = $this->ticketModel->buscarPorId($id_ticket);

        if (!$ticket) {
            mostrarSweetAlert(
                'error',
                'Ticket no encontrado',
                'El ticket no existe',
                BASE_URL . 'administrador/tickets'
            );
            exit();
        }

        require BASE_PATH . '/app/views/dashboard/administrador/tickets/responder.php';
    }


    // 💾 GUARDAR RESPUESTA
    public function responder()
    {
        $id_ticket = $_POST['id_ticket'] ?? null;
        $respuesta = trim($_POST['respuesta'] ?? '');

        if (!$id_ticket || !$respuesta) {
            mostrarSweetAlert(
                'error',
                'Error',
                'Respuesta vacía',
                BASE_URL . 'administrador/tickets'
            );
            exit();
        }

        $this->ticketModel->responder($id_ticket, $respuesta);

        mostrarSweetAlert(
            'success',
            'Respuesta enviada',
            'El ticket fue respondido correctamente',
            BASE_URL . 'administrador/tickets'
        );
    }

    // ❌ CERRAR TICKET
    public function cerrar()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: ' . BASE_URL . 'administrador/tickets');
            exit();
        }

        $this->ticketModel->cerrar($id);

        mostrarSweetAlert(
            'success',
            'Ticket cerrado',
            'El ticket fue cerrado',
            BASE_URL . 'administrador/tickets'
        );
    }
}
