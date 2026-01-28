<?php
// Incluye la configuración de la base de datos
require_once __DIR__ . '/../../../config/database.php';

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

    // Verifica correo en la tabla PROVEEDOR_Turistico (empresa)
    public function emailproveedorExiste($email)
    {
        $sql = "SELECT id_proveedor 
            FROM proveedor
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
            // 🔒 INICIAR TRANSACCIÓN
            $this->conexion->beginTransaction();

            // 1️⃣ INSERT USUARIO
            $insert_usuario = "INSERT INTO usuario (
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
            'proveedor',
            :foto_representante,
            'Activo'
        )";

            $usuario = $this->conexion->prepare($insert_usuario);
            $usuario->execute([
                ':nombre_representante'        => $data['nombre_representante'],
                ':tipo_documento'              => $data['tipo_documento'],
                ':identificacion_representante' => $data['identificacion_representante'],
                ':email_representante'         => $data['email_representante'],
                ':telefono_representante'      => $data['telefono_representante'],
                ':identificacion'              => $data['identificacion'],
                ':foto_representante'          => $data['foto_representante']
            ]);

            $id_usuario = $this->conexion->lastInsertId();

            // 2️⃣ INSERT PROVEEDOR
            $insert_proveedor = "INSERT INTO proveedor (
            id_usuario,
            nombre_empresa,
            logo,
            email,
            telefono,
            nit_rut,
            nombre_representante,
            tipo_documento,
            identificacion_representante,
            foto_representante,
            email_representante,
            telefono_representante,
            actividades,
            departamento,
            id_ciudad,
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
            :tipo_documento,
            :identificacion_representante,
            :foto_representante,
            :email_representante,
            :telefono_representante,
            :actividades,
            :departamento,
            :id_ciudad,
            :direccion,
            'activo'
        )";

            $proveedor = $this->conexion->prepare($insert_proveedor);
            $proveedor->execute([
                ':id_usuario'                  => $id_usuario,
                ':nombre_empresa'              => $data['nombre_empresa'],
                ':logo'                        => $data['logo'],
                ':email'                       => $data['email'],
                ':telefono'                    => $data['telefono'],
                ':nit_rut'                     => $data['nit_rut'],
                ':nombre_representante'        => $data['nombre_representante'],
                ':tipo_documento'              => $data['tipo_documento'],
                ':identificacion_representante' => $data['identificacion_representante'],
                ':foto_representante'          => $data['foto_representante'],
                ':email_representante'         => $data['email_representante'],
                ':telefono_representante'      => $data['telefono_representante'],
                ':actividades'                 => $data['actividades'],
                ':departamento'                => $data['departamento'],
                ':id_ciudad'                   => $data['id_ciudad'],
                ':direccion'                   => $data['direccion']
            ]);

            // ✅ TODO BIEN → CONFIRMAR
            $this->conexion->commit();
            return true;
        } catch (PDOException $e) {
            // ❌ ALGO FALLÓ → DESHACER TODO
            $this->conexion->rollBack();
            return false;
        }
    }


    public function listar()
    {
        try {
            // Variable que almacena la sentencia de sql a ejecutar
            // $consultar = "SELECT * FROM proveedor WHERE id_proveedor = id_proveedor order BY id_proveedor DESC";

            $consultar = " SELECT p.*, c.nombre AS nombre_ciudad FROM proveedor p LEFT JOIN ciudades c ON p.id_ciudad = c.id_ciudad ORDER BY p.id_proveedor DESC
";

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

            $consultar = "
            SELECT 
                p.*,
                c.nombre AS ciudad,
                d.nombre AS departamento
            FROM proveedor p
            LEFT JOIN ciudades c ON p.id_ciudad = c.id_ciudad
            LEFT JOIN departamentos d ON c.id_departamento = d.id_departamento
            WHERE p.id_proveedor = :id
            LIMIT 1
        ";

            $resultado = $this->conexion->prepare($consultar);
            $resultado->bindParam(':id', $id, PDO::PARAM_INT);
            $resultado->execute();

            return $resultado->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error en proveedor::listarProveedor -> ' . $e->getMessage());
            return null;
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

            $actualizar = "UPDATE proveedor SET
                nombre_empresa = :nombre_empresa,
                nit_rut = :nit_rut,
                email = :email,
                telefono = :telefono,
                nombre_representante = :nombre_representante,
                tipo_documento = :tipo_documento,
                identificacion_representante = :identificacion_representante,
                email_representante = :email_representante,
                telefono_representante = :telefono_representante,
                actividades = :actividades,
                departamento = :departamento,
                id_ciudad = :id_ciudad,
                direccion = :direccion
            WHERE id_proveedor = :id_proveedor";

            $resultado = $this->conexion->prepare($actualizar);
            $resultado->bindParam(':id_proveedor', $data['id_proveedor']);
            $resultado->bindParam(':nombre_empresa', $data['nombre_empresa']);
            $resultado->bindParam(':nit_rut', $data['nit_rut']);
            $resultado->bindParam(':email', $data['email']);
            $resultado->bindParam(':telefono', $data['telefono']);
            $resultado->bindParam(':nombre_representante', $data['nombre_representante']);
            $resultado->bindParam(':tipo_documento', $data['tipo_documento']);
            $resultado->bindParam(':identificacion_representante', $data['identificacion_representante']);
            $resultado->bindParam(':email_representante', $data['email_representante']);
            $resultado->bindParam(':telefono_representante', $data['telefono_representante']);
            $resultado->bindParam(':actividades', $data['actividades']);
            $resultado->bindParam(':departamento', $data['departamento']);
            $resultado->bindParam(':id_ciudad', $data['id_ciudad']);
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

    public function cambiarEstado($id, $estado)
    {
        try {
            $actualizarEstado = "UPDATE proveedor SET estado = :estado WHERE id_proveedor = :id_proveedor";
            $resultado = $this->conexion->prepare($actualizarEstado);
            $resultado->execute([':estado' => $estado, ':id_proveedor' => $id]);

            return ['success' => true];
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function activarProveedor($id)
    {
        try {
            $activarEstado = "UPDATE proveedor SET estado= 'ACTIVO' WHERE id_proveedor = :id_proveedor";

            $resultado = $this->conexion->prepare($activarEstado);
            $resultado->bindParam(':id_proveedor', $id);

            return $resultado->execute();
        } catch (PDOException $e) {
            error_log("Error al activarEstado proveedor::activarEstado->" . $e->getMessage());
            return;
        }
    }
    public function desactivarProveedor($id)
    {
        try {
            $desactivarEstado = "UPDATE proveedor SET estado= 'INACTIVO' WHERE id_proveedor = :id_proveedor";

            $resultado = $this->conexion->prepare($desactivarEstado);
            $resultado->bindParam(':id_proveedor', $id);

            return $resultado->execute();
        } catch (PDOException $e) {
            error_log("Error al desactivarEstado proveedor::desactivarEstado->" . $e->getMessage());
            return;
        }
    }
}
