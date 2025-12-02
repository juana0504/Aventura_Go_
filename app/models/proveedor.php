<?php
// Incluye la configuración de la base de datos
require_once __DIR__ . '/../../config/database.php';

// Definición de la clase login
class Proveedor
{
    private $conexion; // Propiedad para almacenar la conexión a la base de datos

    // Constructor: se ejecuta automáticamente cuando se crea el objeto
    public function __construct()
    {
        $db = new conexion(); // Crea una nueva instancia de la clase conexion (config/database.php)
        $this->conexion = $db->getConexion(); // Obtiene la conexión PDO y la guarda en $this->conexion
    }

    // Función para autenticar usuario (recibe el correo y la clave escrita por el usuario)
    public function registrar($data)
    {

        try {
            // Registro a la tabla Usuario

            $insert_usuario = "INSERT INTO usuario (
                nombre,
                identificacion,
                telefono,
                email,
                clave,
                rol,
                foto,
                estado
            )   VALUES(
                :nombre_representante,
                :identificacion_representante,
                :telefono_representante,
                :email_representante,
                :identificacion,
                'proveedor-turistico',
                :foto_representante,
                'Activo'
            )";

            $usuario = $this->conexion->prepare($insert_usuario);
            $usuario->bindParam(':nombre_representante', $data['nombre_representante']);
            $usuario->bindParam(':identificacion_representante', $data['identificacion_representante']);
            $usuario->bindParam(':email_representante', $data['email_representante']);
            $usuario->bindParam(':telefono_representante', $data['telefono_representante']);
            $usuario->bindParam(':identificacion', $data['identificacion']);
            $usuario->bindParam(':foto_representante', $data['foto_representante']);

            $usuario->execute();
            $id_usuario = $this->conexion->lastInsertId();


            $insertar = "INSERT INTO proveedor(
            id_usuario,
            nombre_empresa,
            logo,
            email,
            telefono,
            nit_rut,
            nombre_representante,
            identificacion_representante,
            foto_representante,
            email_representante,
            telefono_representante,
            actividades,
            foto_actividades,
            descripcion,
            departamento,
            ciudad,
            direccion,
            validado
        ) VALUES (
            :id_usuario,
            :nombre_empresa,
            :logo,
            :email,
            :telefono,
            :nit_rut,
            :nombre_representante,
            :identificacion_representante,
            :foto_representante,
            :email_representante,
            :telefono_representante,
            :actividades,
            :foto_actividades,
            :descripcion,
            :departamento,
            :ciudad,
            :direccion,
            'activo'
            )";

            $resultado = $this->conexion->prepare($insertar);
            $resultado->bindParam(':id_usuario', $id_usuario);
            $resultado->bindParam(':nombre_empresa', $data['nombre_empresa']);
            $resultado->bindParam(':logo', $data['logo']);
            $resultado->bindParam(':email', $data['email']);
            $resultado->bindParam(':telefono', $data['telefono']);
            $resultado->bindParam(':nit_rut', $data['nit_rut']);
            $resultado->bindParam(':nombre_representante', $data['nombre_representante']);
            $resultado->bindParam(':identificacion_representante', $data['identificacion_representante']);
            $resultado->bindParam(':foto_representante', $data['foto_representante']);
            $resultado->bindParam(':email_representante', $data['email_representante']);
            $resultado->bindParam(':telefono_representante', $data['telefono_representante']);
            $resultado->bindParam(':actividades', $data['actividades']);
            $resultado->bindParam(':foto_actividades', $data['foto_actividades']);
            $resultado->bindParam(':descripcion', $data['descripcion']);
            $resultado->bindParam(':departamento', $data['departamento']);
            $resultado->bindParam(':ciudad', $data['ciudad']);
            $resultado->bindParam(':direccion', $data['direccion']);


            return $resultado->execute();
        } catch (PDOException $e) {
            error_log("Error en proveedor::registrar->" . $e->getMessage());
            return false;
        }
    }

    public function listar()
    {
        try {
            // Variable que almacena laq sentencia de sql a ejecutar
            $consultar = "SELECT * FROM proveedor WHERE id_proveedor = id_proveedor order BY id_proveedor DESC";

            // Preparar lo necesario para ejecutar la función
            $resultado = $this->conexion->prepare($consultar);
            $resultado->execute();

            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en proveedor::listar->" . $e->getMessage());
            return [];
        }
    }

    public function listarProveedor($id)
    {
        try {

            $consultar = "SELECT * FROM proveedor WHERE id_proveedor = :id_proveedor LIMIT 1";

            $resultado = $this->conexion->prepare($consultar);
            $resultado->bindParam(':id_proveedor', $id);
            $resultado->execute();

            return $resultado->fetch();
        } catch (PDOexception $e) {
            error_log("Error en proveedor::listarProveedor->" . $e->getMessage());
            return;
        }
    }

    public function actualizar($data)
    {
        try {
            $actualizar = "UPDATE proveedor SET
                nombre_empresa = :nombre_empresa,
                nit_rut = :nit_rut,
                nombre_representante = :nombre_representante,
                email = :email,
                telefono = :telefono,
                actividades = :actividades,
                descripcion = :descripcion,
                departamento = :departamento,
                ciudad = :ciudad,
                direccion = :direccion
            WHERE id_proveedor = :id_proveedor";

            $resultado = $this->conexion->prepare($actualizar);
            $resultado->bindParam(':id_proveedor', $data['id_proveedor']);
            $resultado->bindParam(':nombre_empresa', $data['nombre_empresa']);
            $resultado->bindParam(':nit_rut', $data['nit_rut']);
            $resultado->bindParam(':nombre_representante', $data['nombre_representante']);
            $resultado->bindParam(':email', $data['email']);
            $resultado->bindParam(':telefono', $data['telefono']);
            $resultado->bindParam(':actividades', $data['actividades']);
            $resultado->bindParam(':descripcion', $data['descripcion']);
            $resultado->bindParam(':departamento', $data['departamento']);
            $resultado->bindParam(':ciudad', $data['ciudad']);
            $resultado->bindParam(':direccion', $data['direccion']);

            return $resultado->execute();
        } catch (PDOException $e) {
            error_log("Error al actualizar proveedor::actualizar->" . $e->getMessage());
            return;
        }
    }

    public function eliminar($id)
    {
        try {
            $eliminar = "DELETE FROM proveedor WHERE id_proveedor = :id_proveedor";

            $resultado = $this->conexion->prepare($eliminar);
            $resultado->bindParam(':id_proveedor', $id);

            return $resultado->execute();
        } catch (PDOException $e) {
            error_log("Error al eliminar proveedor::eliminar->" . $e->getMessage());
            return;
        }
    }
}
