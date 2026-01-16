<?php

require_once __DIR__ . '/../../../config/database.php';

class EditarPerfilProveedor
{
    private $conexion;

    public function __construct()
    {
        $db = new conexion();
        $this->conexion = $db->getConexion();
    }

    public function actualizar($data)
    {
        try {
            $sql = "UPDATE usuario SET
                        nombre   = :nombre,
                        telefono = :telefono,
                        email    = :email,
                        foto     = :foto,
                        identificacion = :identificacion
                    WHERE id_usuario = :id_usuario";

            $stmt = $this->conexion->prepare($sql);

            $stmt->bindParam(':nombre', $data['nombre']);
            $stmt->bindParam(':telefono', $data['telefono']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':foto', $data['foto']);
            $stmt->bindParam(':identificacion', $data['identificacion']);
            $stmt->bindParam(':id_usuario', $data['id_usuario']);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en EditarPerfilProveedor::actualizar -> " . $e->getMessage());
            return false;
        }
    }
}
