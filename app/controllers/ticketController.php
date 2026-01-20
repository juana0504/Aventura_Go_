<?php

class TicketController {
    
    // Función para MOSTRAR la lista de tickets
    public function consultar() {
        require_once BASE_PATH . '/app/models/Ticket.php';
        $ticketModel = new Ticket();

        // Obtenemos los datos desde el modelo (que ya tiene el LEFT JOIN)
        $listadoTickets = $ticketModel->listarTodo();

        // Cargamos la vista de la tabla
        require_once BASE_PATH . '/app/views/dashboard/administrador/consultar_tickets.php';
    }

    // Tu función actual para GUARDAR (la que ya funciona)
    public function guardar() {
        require_once BASE_PATH . '/app/models/Ticket.php';
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if (!isset($_SESSION['user']['id'])) {
                die("Error: No se encontró una sesión activa.");
            }

            $ticket = new Ticket();
            $id_usuario = $_SESSION['user']['id'];
            
            $asunto = $_POST['asunto'] ?? '';
            $categoria = $_POST['categoria'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';

            $res = $ticket->crear($id_usuario, $asunto, $categoria, $descripcion);
            
            if ($res) {
                header("Location: " . BASE_URL . "/administrador/consultar-tickets?status=success");
                exit();
            } else {
                echo "Error al guardar el ticket.";
            }
        }
    }
}