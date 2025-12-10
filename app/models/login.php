<?php
require_once __DIR__ . '/../../config/database.php';

class login
{
    private $conexion;

    public function __construct()
    {
        $db = new conexion();
        $this->conexion = $db->getConexion();
    }

    public function autenticar($correo, $clave)
    {
        try {
            $sql = "SELECT * FROM usuario WHERE email = :correo AND estado = 'activo' LIMIT 1";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':correo', $correo);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return ['error' => 'Usuario no encontrado o inactivo'];
            }

            // 🔒 Verificar si está bloqueado
            if ($user['bloqueado_hasta'] && strtotime($user['bloqueado_hasta']) > time()) {
                return ['error' => 'Cuenta bloqueada temporalmente. Intenta más tarde'];
            }

            // ❌ Contraseña incorrecta
            if (!password_verify($clave, $user['clave'])) {

                $intentosActuales = $user['intentos_fallidos'] + 1;
                $intentosMaximos = 5;
                $intentosRestantes = $intentosMaximos - $intentosActuales;

                $this->registrarIntento($user['id_usuario'], $correo, 0);
                $this->incrementarIntentos($user);

                if ($intentosRestantes <= 0) {
                    return ['error' => 'Cuenta bloqueada por 5 minutos debido a múltiples intentos fallidos'];
                }

                return [
                    'error' => 'Ingreso fallido. Te quedan ' . $intentosRestantes . ' intentos'
                ];
            }


            // ✅ LOGIN EXITOSO
            $this->registrarIntento($user['id_usuario'], $correo, 1);
            $this->limpiarIntentos($user['id_usuario']);

            return [
                'id_usuario' => $user['id_usuario'],
                'rol' => $user['rol'],
                'nombre' => $user['nombre'],
                'correo' => $user['email']
            ];
        } catch (PDOException $e) {
            error_log("Error en login: " . $e->getMessage());
            return ['error' => 'Error interno del servidor'];
        }
    }

    // 🔢 Aumentar intentos y bloquear si llega a 5
    private function incrementarIntentos($user)
    {
        $intentos = $user['intentos_fallidos'] + 1;
        $bloqueado_hasta = null;

        if ($intentos >= 5) {
            $bloqueado_hasta = date('Y-m-d H:i:s', strtotime('+5 minutes'));
        }

        $sql = "
            UPDATE usuario 
            SET intentos_fallidos = :intentos, bloqueado_hasta = :bloqueado
            WHERE id_usuario = :id
        ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':intentos', $intentos);
        $stmt->bindParam(':bloqueado', $bloqueado_hasta);
        $stmt->bindParam(':id', $user['id_usuario']);
        $stmt->execute();
    }

    // 🧹 Limpiar intentos al login exitoso
    private function limpiarIntentos($id_usuario)
    {
        $sql = "
            UPDATE usuario 
            SET intentos_fallidos = 0, bloqueado_hasta = NULL
            WHERE id_usuario = :id
        ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id_usuario);
        $stmt->execute();
    }

    // 📝 Registrar cada intento
    private function registrarIntento($id_usuario, $correo, $exito)
    {
        $sql = "
            INSERT INTO login_intentos (id_usuario, email, exito)
            VALUES (:id, :email, :exito)
        ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id_usuario);
        $stmt->bindParam(':email', $correo);
        $stmt->bindParam(':exito', $exito, PDO::PARAM_INT);
        $stmt->execute();
    }

    // ✅ Método que ya tenías
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
