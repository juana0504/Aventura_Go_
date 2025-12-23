<?php
require_once __DIR__ . '/../../config/database.php';

class Departamento
{
    private $conexion;

    public function __construct()
    {
        $db = new conexion();
        $this->conexion = $db->getConexion();
    }

    public function obtenerDepartamentosActivos()
    {
        $sql = "SELECT id_departamento, nombre
                FROM departamentos
                WHERE estado = 1
                ORDER BY nombre";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
