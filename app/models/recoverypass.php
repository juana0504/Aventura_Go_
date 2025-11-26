<?php
// Incluye la configuración de la base de datos
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../helpers/mailer_helper.php';

class Recoverypass
{
    private $conexion; // Propiedad para almacenar la conexión a la base de datos

    // Constructor: se ejecuta automáticamente cuando se crea el objeto
    public function __construct()
    {
        $db = new conexion(); // Crea una nueva instancia de la clase conexion (config/database.php)
        $this->conexion = $db->getConexion(); // Obtiene la conexión PDO y la guarda en $this->conexion
    }

    public function recuperarClave($email)
    {
        try {
            $consultar = "SELECT * FROM usuario WHERE email = :correo AND estado = 'activo' LIMIT 1";
            $resultado = $this->conexion->prepare($consultar);
            $resultado->bindParam(':correo', $email);
            $resultado->execute();
            $user = $resultado->fetch();

            if ($user) {
                // generamos la nueva contraseña a partir de una base de caracteres y un random
                $base = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

                // mezclamos la cadena de caracteres
                $random = str_shuffle($base);

                // sustraemos una cantidad definida de este random
                $nuevaClave = substr($random, 0, 6); //el cero es la posicion inicial y el 6 la cantidad de caracteres

                $claveHash = password_hash($nuevaClave, PASSWORD_BCRYPT);
            
                // Actualizamos la contraseña en la base de datos
                $actualizar = "UPDATE usuario SET clave = :nuevaClave WHERE id_usuario = :id";
                $stmtActualizar = $this->conexion->prepare($actualizar);
                $stmtActualizar->bindParam(':nuevaClave', ($claveHash));
                $stmtActualizar->bindParam(':id', $user['id_usuario']);
                $stmtActualizar->execute();

                $mail = mailer_init();

                $mail->setFrom('aventurago.contacto@gmail.com', 'Soporte Aventura_go');
                $mail->addAddress($user['email'], $user['nombre']);

                $mail->Subject = "Aventura_go - Nueva clave generada";                            //Set email format to HTML
                    $mail->Body    = $mail->Body    = <<<HTML
                        <div style="font-family: Lato, Arial, sans-serif; background-color: #F8F9FA; padding: 40px;">
                            <div style="max-width: 650px; margin: auto; background: #FFFFFF; border-radius: 10px; overflow: hidden; border: 1px solid #E0E0E0;">

                                <!-- ENCABEZADO CON COLOR PRIMARIO -->
                                <div style="background-color: #2D4059; padding: 25px; text-align: center;">
                                    <img src="https://raw.githubusercontent.com/Albert-Gutierrez/Aventura-Go/refs/heads/main/assets/estilos_globales/img/LOGO-POSITIVO.png" alt="Aventura Go" style="width: 160px; margin-bottom: 10px;">
                                </div>

                                <!-- CONTENIDO -->
                                <div style="padding: 30px; color: #2B2B2B; font-size: 16px;">

                                    <h2 style="color: #000000; margin: 0; font-family: Raleway, Arial, sans-serif; text-align: center; font-size: 15px;">
                                        Señor usuario, Se ha generado una nueva contraseña para tu cuenta. <br> 
                                        Por motivos de seguridad, te recomendamos cambiarla inmediatamente después de iniciar sesión.
                                    </h2>
    
                                    <p style="margin-bottom: 15px; text-align: center; font-size: 25px; ">
                                        <strong style="color: #EA8217;">Nueva contraseña generada:</strong><br>
                                        $nuevaClave
                                    </p>

                                    <p style="margin-bottom: 10px;  text-align: center; font-size: 13px; ">
                                        Si no solicitaste este cambio, por favor contacta a nuestro equipo de soporte inmediatamente.
                                    </p>

                                </div>

                                <!-- PIE DE PÁGINA -->
                                <div style="background-color: #2D4059; color: #FFFFFF; padding: 15px; text-align: center; font-size: 13px;">
                                    Mensaje enviado desde el formulario de recuperacion de contraseña de <strong>Aventura Go</strong>.
                                </div>

                            </div>
                        </div>
                    HTML;
                $mail->send();

                return true;

            } else {
                return ['error' => 'Usuario no encontrado o inactivo'];
            }
        } catch (PDOException $e) {
            // Si hay un error en base de datos, lo registra en el log del servidor
            error_log("Error en recuperar clave:-> " . $e->getMessage());

            // Retorna un mensaje genérico al usuario para no revelar detalles internos
            return ['Error' => 'Error interno del servidor'];
        }
    }
}
