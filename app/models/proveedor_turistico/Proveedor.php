<?php

require_once __DIR__ . '/../../../config/database.php';

class Proveedor
{
    private $conexion;

    public function __construct()
    {
        $db = new conexion();
        $this->conexion = $db->getConexion();
    }

    public function obtenerIdProveedorPorUsuario($id_usuario)
    {
        $sql = "SELECT id_proveedor FROM proveedor WHERE id_usuario = :id_usuario LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['id_proveedor'] : null;
    }
}
