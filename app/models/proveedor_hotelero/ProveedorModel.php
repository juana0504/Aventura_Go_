<?php

require_once __DIR__ . '/../../../config/database.php';

// ======================================================
// MODELO PROVEEDOR HOTELERO
// ======================================================

class ProveedorModel
{
    private $conexion;

    // =========================================
    // CONEXIÓN
    // =========================================
    public function __construct()
    {
        $db = new conexion();
        $this->conexion = $db->getConexion();
    }

    // =========================================
    // OBTENER PROVEEDOR POR USUARIO
    // =========================================
    public function obtenerPorUsuario($idUsuario)
    {

        $sql = "SELECT
            p.*,
            u.nombre,
            u.email,
            u.telefono,
            u.identificacion
        FROM proveedor_hotelero p
        JOIN usuario u
            ON p.id_usuario = u.id_usuario
        WHERE p.id_usuario = :id
        LIMIT 1";

        $stmt = $this->conexion->prepare($sql);

        $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // =========================================
    // OBTENER ARCHIVOS ACTUALES
    // =========================================
    public function obtenerArchivosActuales($idUsuario)
    {

        $sql = "SELECT 
                    logo,
                    foto_representante,
                    camara_comercio,
                    licencia
                FROM proveedor_hotelero
                WHERE id_usuario = :id
                LIMIT 1";

        $stmt = $this->conexion->prepare($sql);

        $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // =========================================
    // ACTUALIZAR PROVEEDOR HOTELERO
    // =========================================
    public function actualizarProveedor($data)
    {

        $sql = "UPDATE proveedor_hotelero SET

            nombre_establecimiento = :nombre_establecimiento,
            nit_rut = :nit_rut,
            departamento = :departamento,
            direccion = :direccion,

            email = :email,
            telefono = :telefono,

            nombre_representante = :nombre_representante,
            identificacion_representante = :identificacion_representante,
            telefono_representante = :telefono_representante,

            id_ciudad = :id_ciudad,

            tipo_documento = :tipo_documento,
            tipo_establecimiento = :tipo_establecimiento,
            tipo_habitacion = :tipo_habitacion,

            max_huesped = :max_huesped,

            metodo_pago = :metodo_pago,
            servicio_incluido = :servicio_incluido,

            camara_comercio = :camara_comercio,
            licencia = :licencia,

            logo = :logo,
            foto_representante = :foto_representante,

            estado = 'EN_REVISION'

        WHERE id_usuario = :id_usuario";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute($data);
    }
}