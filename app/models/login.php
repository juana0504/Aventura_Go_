<?php
    require_once __DIR__ . '/../../config/database.php';

    class Login{
        private $conexion;

        public function __construct(){
            $db = new Conexion();
            $this->conexion = $db->getConexion();
        }

        public function autenticar($correo, $clave){
            try{
                $consultar = "SELECT * FROM usuario WHERE email = :correo AND estado = 'Activo' lIMIT 1";

                $resultado = $this->conexion->prepare($consultar);
                $resultado->bindParam(':correo', $correo);
                $resultado->execute();

                $user = $resultado->fetch();

                if(!$user){
                    return ['error' => 'Usuario no encontrado o inactivo'];
                }

                // Verifica la contraseña
                if(!password_verify($clave, $user['clave'])){
                    return['error' => 'Contraseña incorrecta'];
                }

                // Retornar los datos del usuario autenticado
                return[
                    'id_usuario' => $user['id_usuario'],
                    'rol' => $user['rol'],
                    'nombre' => $user['nombre'], 
                    'correo' => $user['email']
                ];
            }catch(PDOException $e){
                error_log("Error de autenticacion: " . $e->getMessage());
                return['error' => 'Error interno del servidor'];
            }
        }
    }
?>