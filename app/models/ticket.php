<?php
class Ticket {
    private $db;

    public function __construct() {
        // Asumiendo que tienes una clase de conexión global
        $this->db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    }

    public function crear($id_usuario, $asunto, $categoria, $descripcion) {
        $sql = "INSERT INTO ticket_reporte (id_usuario, asunto, categoria, descripcion) VALUES (?, ?, ?, ?)";
        return $this->db->prepare($sql)->execute([$id_usuario, $asunto, $categoria, $descripcion]);
    }

    public function listarPorUsuario($id_usuario) {
        $sql = "SELECT * FROM ticket_reporte WHERE id_usuario = ? ORDER BY fecha_creacion DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function listarTodo() {
        $sql = "SELECT * FROM ticket_reporte ORDER BY fecha_creacion DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}