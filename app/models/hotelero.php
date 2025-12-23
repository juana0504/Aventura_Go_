<?php
// Incluye la configuración de la base de datos
require_once __DIR__ . '/../../config/database.php';

// Definición de la clase login
class Hotelero
{
    private $conexion; // Propiedad para almacenar la conexión a la base de datos

    // Constructor: se ejecuta automáticamente cuando se crea el objeto
    public function __construct()
    {
        $db = new conexion(); // Crea una nueva instancia de la clase conexion (config/database.php)
        $this->conexion = $db->getConexion(); // Obtiene la conexión PDO y la guarda en $this->conexion
    }

    // Función para verificar si un email ya existe en la base de datos
    // Verifica correo en la tabla USUARIO (representante)
    public function emailUsuarioExiste($email)
    {
        $sql = "SELECT id_usuario FROM usuario WHERE email = :email LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Verifica correo en la tabla PROVEEDOR_HOTELERO (empresa)
    public function emailHotelExiste($email)
    {
        $sql = "SELECT id_proveedor_hotelero 
            FROM proveedor_hotelero 
            WHERE email = :email LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Función para autenticar usuario (recibe el correo y la clave escrita por el usuario)
    public function registrar($data)
    {

        try {

            $insert_usuario = "INSERT INTO usuario(
                nombre,
                tipo_documento,
                identificacion,
                email,
                telefono,
                clave,
                rol,
                foto,
                estado
            ) VALUES (
                :nombre_representante,
                :tipo_documento,
                :identificacion_representante,
                :email_representante,
                :telefono_representante,
                :identificacion,
                'proveedor_hotelero',
                :foto_representante,
                'Activo'
            )";
            $usuario = $this->conexion->prepare($insert_usuario);
            $usuario->bindParam(':nombre_representante', $data['nombre_representante']);
            $usuario->bindParam(':tipo_documento', $data['tipo_documento']);
            $usuario->bindParam(':identificacion_representante', $data['identificacion_representante']);
            $usuario->bindParam(':email_representante', $data['email_representante']);
            $usuario->bindParam(':telefono_representante', $data['telefono_representante']);
            $usuario->bindParam(':identificacion', $data['identificacion']);
            $usuario->bindParam(':foto_representante', $data['foto_representante']);

            $usuario->execute();
            $id_usuario = $this->conexion->lastInsertId();

            $insertar = "INSERT INTO proveedor_hotelero(
                id_usuario,
                logo,
                nombre_establecimiento,
                email,
                telefono,
                tipo_establecimiento,
                nombre_representante,
                tipo_documento,
                identificacion_representante,
                foto_representante,
                email_representante,
                telefono_representante,
                departamento,
                id_ciudad,
                direccion,
                tipo_habitacion,
                max_huesped,
                servicio_incluido,
                nit_rut,
                camara_comercio,
                licencia,
                metodo_pago,
                estado
            ) VALUES (
                :id_usuario,
                :logo,
                :nombre_establecimiento,
                :email,
                :telefono,
                :tipo_establecimiento,
                :nombre_representante,
                :tipo_documento,
                :identificacion_representante,
                :foto_representante,
                :email_representante,
                :telefono_representante,
                :departamento,
                :id_ciudad,
                :direccion,
                :tipo_habitacion,
                :max_huesped,
                :servicio_incluido,
                :nit_rut,
                :camara_comercio,
                :licencia,
                :metodo_pago,
                'Activo'
            )";

            $resultado = $this->conexion->prepare($insertar);
            $resultado->bindParam(':id_usuario', $id_usuario);
            $resultado->bindParam(':logo', $data['logo']);
            $resultado->bindParam(':nombre_establecimiento', $data['nombre_establecimiento']);
            $resultado->bindParam(':email', $data['email']);
            $resultado->bindParam(':telefono', $data['telefono']);
            $resultado->bindParam(':tipo_establecimiento', $data['tipo_establecimiento']);
            $resultado->bindParam(':nombre_representante', $data['nombre_representante']);
            $resultado->bindParam(':tipo_documento', $data['tipo_documento']);
            $resultado->bindParam(':identificacion_representante', $data['identificacion_representante']);
            $resultado->bindParam(':foto_representante', $data['foto_representante']);
            $resultado->bindParam(':email_representante', $data['email_representante']);
            $resultado->bindParam(':telefono_representante', $data['telefono_representante']);
            $resultado->bindParam(':departamento', $data['departamento']);
            $resultado->bindParam(':id_ciudad', $data['id_ciudad']);
            $resultado->bindParam(':direccion', $data['direccion']);
            $resultado->bindParam(':tipo_habitacion', $data['tipo_habitacion']);
            $resultado->bindParam(':max_huesped', $data['max_huesped']);
            $resultado->bindParam(':servicio_incluido', $data['servicio_incluido']);
            $resultado->bindParam(':nit_rut', $data['nit_rut']);
            $resultado->bindParam(':camara_comercio', $data['camara_comercio']);
            $resultado->bindParam(':licencia', $data['licencia']);
            $resultado->bindParam(':metodo_pago', $data['metodo_pago']);

            return $resultado->execute();
        } catch (PDOException $e) {
            //AQUÍ VA TU CATCH PARA CORREO DUPLICADO
            if ($e->getCode() == 23000) {
                mostrarSweetAlert('error', 'Correo duplicado', 'Este correo ya existe en el sistema.');
                return false;
            }

            error_log("Error en proveedor::registrar->" . $e->getMessage());
            return false;
        }
    }

    public function listar()
    {
        try {
            // Variable que almacena laq sentencia de sql a ejecutar
            $consultar = "SELECT * FROM proveedor_hotelero WHERE id_proveedor_hotelero = id_proveedor_hotelero order BY id_proveedor_hotelero DESC";

            // Preparar lo necesario para ejecutar la función
            $resultado = $this->conexion->prepare($consultar);
            $resultado->execute();

            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en proveedor::listar->" . $e->getMessage());
            return [];
        }
    }

    public function listarHoteles($id)
    {
        try {

            $consultar = "SELECT * FROM proveedor_hotelero WHERE id_proveedor_hotelero = :id_proveedor_hotelero LIMIT 1";

            $resultado = $this->conexion->prepare($consultar);
            $resultado->bindParam(':id_proveedor_hotelero', $id);
            $resultado->execute();

            return $resultado->fetch();
        } catch (PDOexception $e) {
            error_log("Error en proveedor::listarHoteles->" . $e->getMessage());
            return;
        }
    }

    public function actualizar($data)
    {
        try {

            $act_usuario = "UPDATE usuario SET 
                nombre = :nombre_representante,
                tipo_documento = :tipo_documento,
                identificacion = :identificacion_representante,
                telefono = :telefono_representante,
                email = :email_representante
            WHERE id_usuario = :id_usuario";

            $usuario = $this->conexion->prepare($act_usuario);
            $usuario->bindParam(':id_usuario', $data['id_usuario']);
            $usuario->bindParam(':nombre_representante', $data['nombre_representante']);
            $usuario->bindParam(':tipo_documento', $data['tipo_documento']);
            $usuario->bindParam(':identificacion_representante', $data['identificacion_representante']);
            $usuario->bindParam(':telefono_representante', $data['telefono_representante']);
            $usuario->bindParam(':email_representante', $data['email_representante']);

            $usuario->execute();

            $actualizar = "UPDATE proveedor_hotelero SET
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
                metodo_pago = :metodo_pago
            WHERE id_proveedor_hotelero = :id_proveedor_hotelero";

            $resultado = $this->conexion->prepare($actualizar);

            $resultado->bindParam(':id_proveedor_hotelero', $data['id_proveedor_hotelero']);
            $resultado->bindParam(':nombre_establecimiento', $data['nombre_establecimiento']);
            $resultado->bindParam(':email', $data['email']);
            $resultado->bindParam(':telefono', $data['telefono']);
            $resultado->bindParam(':tipo_establecimiento', $data['tipo_establecimiento']);
            $resultado->bindParam(':nombre_representante', $data['nombre_representante']);
            $resultado->bindParam(':tipo_documento', $data['tipo_documento']);
            $resultado->bindParam(':identificacion_representante', $data['identificacion_representante']);
            $resultado->bindParam(':email_representante', $data['email_representante']);
            $resultado->bindParam(':telefono_representante', $data['telefono_representante']);
            $resultado->bindParam(':departamento', $data['departamento']);
            $resultado->bindParam(':id_ciudad', $data['id_ciudad']);
            $resultado->bindParam(':direccion', $data['direccion']);
            $resultado->bindParam(':tipo_habitacion', $data['tipo_habitacion']);
            $resultado->bindParam(':max_huesped', $data['max_huesped']);
            $resultado->bindParam(':servicio_incluido', $data['servicio_incluido']);
            $resultado->bindParam(':nit_rut', $data['nit_rut']);
            $resultado->bindParam(':camara_comercio', $data['camara_comercio']);
            $resultado->bindParam(':licencia', $data['licencia']);
            $resultado->bindParam(':metodo_pago', $data['metodo_pago']);

            return $resultado->execute();
        } catch (PDOException $e) {
            error_log("Error al actualizar proveedor::actualizar->" . $e->getMessage());
            return;
        }
    }

    public function eliminar($id)
    {
        try {
            $eliminar = "DELETE FROM proveedor_hotelero WHERE id_proveedor_hotelero = :id_proveedor_hotelero";

            $resultado = $this->conexion->prepare($eliminar);
            $resultado->bindParam(':id_proveedor_hotelero', $id);

            return $resultado->execute();
        } catch (PDOException $e) {
            error_log("Error al eliminar proveedor::eliminar->" . $e->getMessage());
            return;
        }
    }
}
