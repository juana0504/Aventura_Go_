<?php

require_once __DIR__ . '/../../config/database.php';

class PasswordChange
{
    private $conexion;


    public function __construct()
    {
        $db = new conexion();
        $this->conexion = $db->getConexion();
    }

    // Obtener la contraseña actual del usuario
    public function obtenerClaveActual($id_usuario)
    {
        try {
            $sql = "SELECT clave FROM usuario WHERE id_usuario = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error obtenerClaveActual: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar contraseña
    public function actualizarClave($id_usuario, $nuevaClaveHash)
    {
        try {
            $sql = "UPDATE usuario SET clave = :clave WHERE id_usuario = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':clave', $nuevaClaveHash);
            $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error actualizarClave: " . $e->getMessage());
            return false;
        }
    }
}