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

    // public function obtenerIdProveedorPorUsuario($id_usuario)
    // {
    //     $sql = "SELECT id_proveedor_hotelero FROM proveedor_hotelero WHERE id_usuario = :id_usuario LIMIT 1";
    //     $stmt = $this->conexion->prepare($sql);
    //     $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    //     $stmt->execute();

    //     $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //     return $row ? $row['id_proveedor_hotelero'] : null;
    // }

    public function obtenerIdProveedorPorUsuario($id_usuario)
    {
        $sql = "SELECT * FROM proveedor_hotelero WHERE id_usuario = :id_usuario";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //var_dump($row);
        //exit;

        return $row ? $row['id_proveedor_hotelero'] : null;
    }
}
