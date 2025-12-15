<?php
// Incluye la configuración de la base de datos
require_once __DIR__ . '/../../config/database.php';

// Definición de la clase login
class Turista
{
    private $conexion; // Propiedad para almacenar la conexión a la base de datos

    // Constructor: se ejecuta automáticamente cuando se crea el objeto
    public function __construct()
    {
        $db = new conexion(); // Crea una nueva instancia de la clase conexion (config/database.php)
        $this->conexion = $db->getConexion(); // Obtiene la conexión PDO y la guarda en $this->conexion
    }

    // Verifica correo en la tabla USUARIO (representante)
    public function emailUsuarioExiste($email)
    {
        $sql = "SELECT id_usuario FROM usuario WHERE email = :email LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Función para autenticar usuario (recibe el correo y la clave escrita por el usuario)
    public function registrar($data)
    {

        try {
            $insertar = "INSERT INTO usuario(
            nombre,
            genero,
            telefono,
            email,
            clave,
            rol,
            foto,
            estado
        ) VALUES (
            :nombre,
            :genero,
            :telefono,
            :email,
            :clave,
            'turista',
            :foto,
            'activo'
            )";

            $resultado = $this->conexion->prepare($insertar);
            $resultado->bindParam(':nombre', $data['nombre']);
            $resultado->bindParam(':genero', $data['genero']);
            $resultado->bindParam(':telefono', $data['telefono']);
            $resultado->bindParam(':email', $data['email']);
            $resultado->bindParam(':clave', $data['clave']);
            $resultado->bindParam(':foto', $data['foto']);

            return $resultado->execute();
        } catch (PDOException $e) {
            error_log("Error en turista::registrar->" . $e->getMessage());
            return false;
        }
    }

    public function listar()
    {
        try {
            // Variable que almacena laq sentencia de sql a ejecutar
            $consultar = "SELECT * FROM usuario WHERE rol = 'turista' ORDER BY id_usuario DESC";

            // Preparar lo necesario para ejecutar la función
            $resultado = $this->conexion->prepare($consultar);
            $resultado->execute();

            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en turista::listar->" . $e->getMessage());
            return [];
        }
    }

    public function listarTurista($id)
    {
        try {

            $consultar = "SELECT * FROM usuario WHERE id_usuario = :id_usuario LIMIT 1";

            $resultado = $this->conexion->prepare($consultar);
            $resultado->bindParam(':id_usuario', $id);
            $resultado->execute();

            return $resultado->fetch();
        } catch (PDOexception $e) {
            error_log("Error en turista::listarTurista->" . $e->getMessage());
            return;
        }
    }

    public function actualizar($data)
    {
        try {
            $actualizar = "UPDATE usuario SET
                nombre = :nombre,
                genero = :genero,
                telefono = :telefono,
                email = :email
            WHERE id_usuario = :id_usuario";

            $resultado = $this->conexion->prepare($actualizar);
            $resultado->bindParam(':id_usuario', $data['id_usuario']);
            $resultado->bindParam(':nombre', $data['nombre']);
            $resultado->bindParam(':genero', $data['genero']);
            $resultado->bindParam(':telefono', $data['telefono']);
            $resultado->bindParam(':email', $data['email']);


            return $resultado->execute();
        } catch (PDOException $e) {
            error_log("Error al actualizar turista::actualizar->" . $e->getMessage());
            return;
        }
    }

    public function eliminar($id)
    {
        try {
            $eliminar = "DELETE FROM usuario WHERE id_usuario = :id_usuario";

            $resultado = $this->conexion->prepare($eliminar);
            $resultado->bindParam(':id_usuario', $id);

            return $resultado->execute();
        } catch (PDOException $e) {
            error_log("Error al eliminar turista::eliminar->" . $e->getMessage());
            return;
        }
    }

    //comentario de verificacion
}
