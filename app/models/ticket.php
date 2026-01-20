<?php

class Ticket {
    private $db;

    public function __construct() {
        // Conexión manual única para evitar errores de constantes
        $host = 'localhost';
        $db_name = 'aventura_go';
        $user = 'root';
        $pass = '';

        try {
            $this->db = new PDO("mysql:host=$host;dbname=$db_name", $user, $pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->exec("set names utf8");
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function crear($id_usuario, $asunto, $categoria, $descripcion) {
        try {
            $sql = "INSERT INTO ticket_reporte (id_usuario, asunto, categoria, descripcion, estado) 
                    VALUES (?, ?, ?, ?, 'ABIERTO')";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id_usuario, $asunto, $categoria, $descripcion]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function listarTodo() {
        try {
            // Cambiamos a LEFT JOIN para que el ticket aparezca aunque haya problemas con el usuario
            $sql = "SELECT t.*, u.nombre as nombre_usuario 
                    FROM ticket_reporte t 
                    LEFT JOIN usuario u ON t.id_usuario = u.id_usuario 
                    ORDER BY t.fecha_creacion DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}