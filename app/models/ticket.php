<?php
require_once __DIR__ . '/../../config/database.php';

class Ticket
{
    private $conexion;

    public function __construct()
    {
        $db = new conexion();
        $this->conexion = $db->getConexion();
    }

    // 🎫 Crear ticket (Proveedor turístico)
    public function crear($id_usuario, $asunto, $descripcion)
    {
        $sql = "
            INSERT INTO tickets (id_usuario, asunto, descripcion, estado, fecha_creacion)
            VALUES (:id_usuario, :asunto, :descripcion, 'abierto', NOW())
        ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':asunto', $asunto);
        $stmt->bindParam(':descripcion', $descripcion);

        return $stmt->execute();
    }

    // 📋 Listar tickets del proveedor
    public function listarPorUsuario($id_usuario)
    {
        $sql = "
            SELECT *
            FROM tickets
            WHERE id_usuario = :id
            ORDER BY fecha_creacion DESC
        ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 👑 Listar todos los tickets (Administrador)
    public function listarTodos()
    {
        $sql = "
            SELECT t.*, u.nombre
            FROM tickets t
            INNER JOIN usuario u ON u.id_usuario = t.id_usuario
            ORDER BY t.fecha_creacion DESC
        ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔍 Buscar ticket por ID
    public function buscarPorId($id_ticket)
    {
        $sql = "SELECT * FROM tickets WHERE id_ticket = :id LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id_ticket, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✍️ Responder ticket (Administrador)
    public function responder($id_ticket, $respuesta)
    {
        $sql = "
            UPDATE tickets
            SET respuesta = :respuesta,
                estado = 'respondido',
                fecha_respuesta = NOW()
            WHERE id_ticket = :id
        ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':respuesta', $respuesta);
        $stmt->bindParam(':id', $id_ticket, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // ❌ Cerrar ticket (opcional pero recomendado)
    public function cerrar($id_ticket)
    {
        $sql = "UPDATE tickets SET estado = 'cerrado' WHERE id_ticket = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id_ticket, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
