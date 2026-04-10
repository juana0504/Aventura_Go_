<?php

require_once __DIR__ . '/../../../config/database.php';

class RegistrarInformacionModel
{

    private $conexion;

    public function __construct()
    {

        $db = new conexion();
        $this->conexion = $db->getConexion();
    }

    /* =====================================
       OBTENER PROVEEDOR
    ===================================== */

    public function obtenerProveedorActual($idUsuario)
    {

        $sql = "SELECT p.*, u.email AS email_login
                FROM proveedor_hotelero p
                JOIN usuario u ON p.id_usuario = u.id_usuario
                WHERE p.id_usuario = :id
                LIMIT 1";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* =====================================
       ACTUALIZAR PROVEEDOR
    ===================================== */

    public function actualizarProveedorHotelero($idUsuario, $datos, $files)
    {

        /* =========================
           OBTENER DATOS ACTUALES
        ========================= */

        $sqlActual = "SELECT logo, foto_representante
                      FROM proveedor_hotelero
                      WHERE id_usuario = :id
                      LIMIT 1";

        $stmt = $this->conexion->prepare($sqlActual);
        $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();

        $proveedorActual = $stmt->fetch(PDO::FETCH_ASSOC);

        $nombreLogo = $proveedorActual['logo'];
        $nombreFoto = $proveedorActual['foto_representante'];

        $permitidas = ['jpg', 'jpeg', 'png'];

        /* =========================
           LOGO
        ========================= */

        if (!empty($files['logo']['name'])) {

            $ext = strtolower(pathinfo($files['logo']['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $permitidas)) {
                die("Formato de logo no permitido");
            }

            $nombreLogo = uniqid('logo_') . '.' . $ext;

            move_uploaded_file(
                $files['logo']['tmp_name'],
                __DIR__ . '/../../../public/uploads/proveedores/' . $nombreLogo
            );
        }

        /* =========================
           FOTO REPRESENTANTE
        ========================= */

        if (!empty($files['foto_representante']['name'])) {

            $ext = strtolower(pathinfo($files['foto_representante']['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $permitidas)) {
                die("Formato de foto no permitido");
            }

            $nombreFoto = uniqid('repre_') . '.' . $ext;

            move_uploaded_file(
                $files['foto_representante']['tmp_name'],
                __DIR__ . '/../../../public/uploads/proveedores/' . $nombreFoto
            );
        }

        /* =========================
           UPDATE
        ========================= */

        $sql = "UPDATE proveedor_hotelero SET

            nombre_establecimiento = :nombre_establecimiento,
            email = :email,
            telefono = :telefono,
            tipo_establecimiento = :tipo_establecimiento,
            nombre_representante = :nombre_representante,
            tipo_documento = :tipo_documento,
            identificacion_representante = :identificacion_representante,
            email_representante = :email_representante,
            telefono_representante = :telefono_representante,
            departamento = :departamento,
            id_ciudad = :id_ciudad,
            direccion = :direccion,
            tipo_habitacion = :tipo_habitacion,
            max_huesped = :max_huesped,
            servicio_incluido = :servicio_incluido,
            nit_rut = :nit_rut,
            camara_comercio = :camara_comercio,
            licencia = :licencia,
            metodo_pago = :metodo_pago,
            logo = :logo,
            foto_representante = :foto_representante,
            estado = 'EN_REVISION'

        WHERE id_usuario = :id_usuario";

        $stmt = $this->conexion->prepare($sql);

        $stmt->bindParam(':nombre_establecimiento', $datos['nombre_establecimiento']);
        $stmt->bindParam(':email', $datos['email']);
        $stmt->bindParam(':telefono', $datos['telefono']);
        $stmt->bindParam(':tipo_establecimiento', $datos['tipo_establecimiento']);
        $stmt->bindParam(':nombre_representante', $datos['nombre_representante']);
        $stmt->bindParam(':tipo_documento', $datos['tipo_documento']);
        $stmt->bindParam(':identificacion_representante', $datos['identificacion_representante']);
        $stmt->bindParam(':email_representante', $datos['email_representante']);
        $stmt->bindParam(':telefono_representante', $datos['telefono_representante']);
        $stmt->bindParam(':departamento', $datos['departamento']);
        $stmt->bindParam(':id_ciudad', $datos['id_ciudad']);
        $stmt->bindParam(':direccion', $datos['direccion']);
        $stmt->bindParam(':tipo_habitacion', $datos['tipo_habitacion']);
        $stmt->bindParam(':max_huesped', $datos['max_huesped']);
        $stmt->bindParam(':servicio_incluido', $datos['servicio_incluido']);
        $stmt->bindParam(':nit_rut', $datos['nit_rut']);
        $stmt->bindParam(':camara_comercio', $datos['camara_comercio']);
        $stmt->bindParam(':licencia', $datos['licencia']);
        $stmt->bindParam(':metodo_pago', $datos['metodo_pago']);
        $stmt->bindParam(':logo', $nombreLogo);
        $stmt->bindParam(':foto_representante', $nombreFoto);
        $stmt->bindParam(':id_usuario', $idUsuario);

        return $stmt->execute();
    }
}
