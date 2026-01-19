<?php
require_once BASE_PATH . '/app/models/Ticket.php';

class TicketController {
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            session_start(); // Asegúrate de tener la sesión iniciada para obtener el ID
            $ticket = new Ticket();
            
            // Obtenemos el ID del administrador de la sesión
            $id_usuario = $_SESSION['id_usuario']; 
            
            $res = $ticket->crear(
                $id_usuario, 
                $_POST['asunto'], 
                $_POST['categoria'], 
                $_POST['descripcion']
            );
            
            if ($res) {
                // Redirigir al dashboard con un mensaje de éxito
                header("Location: /aventura_go/administrador/dashboard?status=ticket_enviado");
            } else {
                echo "Error al guardar el ticket.";
            }
        }
    }



    public function consultar() {
        $ticketModel = new Ticket();
        // Obtenemos todos los tickets (puedes filtrar por usuario si no es admin)
        $listadoTickets = $ticketModel->listarTodo(); 
        
        // Aquí cargarías la vista pasando la variable $listadoTickets
        require BASE_PATH . '/app/views/dashboard/administrador/consultar_tickets.php';
    }
}