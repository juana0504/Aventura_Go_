<?php
// Incluye la configuración de la base de datos
require_once __DIR__ . '/../../config/database.php';

// Definición de la clase login
class login
{
    private $conexion; // Propiedad para almacenar la conexión a la base de datos

    // Constructor: se ejecuta automáticamente cuando se crea el objeto
    public function __construct()
    {
        $db = new conexion(); // Crea una nueva instancia de la clase conexion (config/database.php)
        $this->conexion = $db->getConexion(); // Obtiene la conexión PDO y la guarda en $this->conexion
    }

    // Función para autenticar usuario (recibe el correo y la clave escrita por el usuario)
    public function autenticar($correo, $clave)
    {
        try {
            // Consulta SQL para buscar al usuario activo con ese correo
            // LIMIT 1 asegura que solo regrese 1 registro
            $consultar = "SELECT * FROM usuario WHERE email = :correo AND estado = 'activo' LIMIT 1";

            // Preparamos la consulta para evitar inyección SQL
            $resultado = $this->conexion->prepare($consultar);

            // Enlazamos el valor recibido a la variable SQL :correo (protección de seguridad)
            $resultado->bindParam(':correo', $correo);

            // Ejecutamos la consulta
            $resultado->execute();

            // Obtenemos los datos del usuario como un arreglo asociativo
            $user = $resultado->fetch();

            // Si no trae datos, significa que el usuario no existe o está inactivo
            if (!$user) {
                return ['error' => 'Usuario no encontrado o inactivo'];
            }

            // Verificamos la contraseña usando password_verify (compara la clave escrita con la encriptada)
            if (!password_verify($clave, $user['clave'])) {
                return ['error' => 'Contraseña incorrecta'];
            }

            // Si todo está bien, retornamos un arreglo con datos del usuario
            return [
                'id_usuario' => $user['id_usuario'],
                'rol' => $user['rol'],
                'nombre' => $user['nombre'],
                'correo' => $user['email']
            ];
        } catch (PDOException $e) {
            // Si hay un error en base de datos, lo registra en el log del servidor
            error_log("Error en el modelo login: " . $e->getMessage());

            // Retorna un mensaje genérico al usuario para no revelar detalles internos
            return ['Error' => 'Error interno del servidor'];
        }
    }

    public function buscarPorId($id)
    {
        try {
            $sql = "SELECT * FROM usuario WHERE id_usuario = :id LIMIT 1";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en buscarPorId: " . $e->getMessage());
            return false;
        }
    }
}
