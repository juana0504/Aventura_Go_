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
                        <body style="margin: 0; padding: 0; font-family: Lato, Arial, sans-serif; background-color: #ffffff;">
                            <div style="padding: 40px 20px;">
                                <div style="max-width: 500px; margin: auto;">
                                    
                                    <!-- ENCABEZADO CON LOGO -->
                                    <div style="background: linear-gradient(135deg, #2D4059 0%, #1f3045 100%); padding: 50px 30px; text-align: center; border-radius: 20px 20px 0 0;">
                                        <!-- Contenedor del logo con borde -->
                                        <div style="background: #FFFFFF; width: 220px; height: 180px; margin: 0 auto 25px; border-radius: 16px; padding: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.3); border: 8px solid #1a1a1a;">
                                            <img src="https://raw.githubusercontent.com/Albert-Gutierrez/Aventura-Go/refs/heads/main/assets/estilos_globales/img/LOGO-FINAL.png" alt="Aventura Go" style="width: 100%; height: 100%; object-fit: contain;">
                                        </div>
                                        
                                        <h1 style="color: #FFFFFF; margin: 0 0 8px; font-family: Raleway, Arial, sans-serif; font-size: 26px; font-weight: 800; letter-spacing: -0.5px;">
                                            Aventura Go
                                        </h1>
                                        <p style="color: rgba(255,255,255,0.8); margin: 0; font-size: 14px; letter-spacing: 0.5px;">
                                            Sistema de Gestión de Aventuras
                                        </p>
                                    </div>
                                    
                                    <!-- CONTENIDO PRINCIPAL -->
                                    <div style="background-color: #1a1a1a; padding: 0 30px 40px; color: #FFFFFF;">
                                        
                                        <!-- Título de bienvenida -->
                                        <div style="text-align: center; padding: 35px 0 25px;">
                                            <h2 style="color: #EA8217; margin: 0 0 10px; font-family: Raleway, Arial, sans-serif; font-size: 22px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                                                ¡Gracias por confiar en nosotros!
                                            </h2>
                                            <p style="color: rgba(255,255,255,0.7); margin: 0; font-size: 15px;">
                                                Buen día, estimado usuario
                                            </p>
                                        </div>
                                        
                                        <!-- Mensaje principal -->
                                        <p style="color: rgba(255,255,255,0.85); font-size: 15px; line-height: 1.8; text-align: center; margin: 0 0 35px;">
                                            Hemos recibido tu solicitud para restablecer la contraseña de tu cuenta en Aventura Go. Por tu seguridad, hemos generado una contraseña temporal que podrás usar para acceder nuevamente.
                                        </p>
                                        
                                        <!-- Caja de información -->
                                        <div style="background-color: #2a2a2a; border: 2px solid #3a3a3a; padding: 30px; border-radius: 12px; margin-bottom: 30px;">
                                           
                                            <p style="color: rgba(255,255,255,0.7); margin: 0 0 8px; font-size: 13px; text-align: center;">
                                                Nueva contraseña temporal:
                                            </p>
                                            
                                            <!-- Botón de contraseña -->
                                            <div style="text-align: center;">
                                                <div style="display: inline-block; background: linear-gradient(135deg, #EA8217 0%, #d97316 100%); color: #FFFFFF; padding: 16px 40px; border-radius: 50px; font-weight: 700; font-size: 20px; letter-spacing: 2px; box-shadow: 0 8px 25px rgba(234, 130, 23, 0.4); font-family: 'Courier New', monospace;">
                                                    $nuevaClave
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Alerta importante -->
                                        <div style="background-color: #2a2a2a; border-left: 4px solid #EA8217; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                                            <div style="display: flex; align-items: start;">
                                                <div style="flex-shrink: 0; margin-right: 12px;">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M12 9V13M12 17H12.01M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#EA8217" stroke-width="2" stroke-linecap="round"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p style="color: #EA8217; margin: 0 0 5px; font-weight: 700; font-size: 14px;">
                                                        Importante:
                                                    </p>
                                                    <p style="color: rgba(255,255,255,0.85); margin: 0; font-size: 13px; line-height: 1.6;">
                                                        Por tu seguridad, te recomendamos cambiar esta contraseña inmediatamente después de iniciar sesión desde tu perfil de usuario.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Instrucciones -->
                                        <p style="color: rgba(255,255,255,0.85); font-size: 14px; line-height: 1.7; text-align: center; margin: 0 0 25px;">
                                            Utiliza esta contraseña para ingresar al sistema y luego cámbiala desde tu perfil.
                                        </p>
                                        
                                        
                                        
                                        <!-- Nota de seguridad -->
                                        <p style="color: rgba(255,255,255,0.6); font-size: 12px; line-height: 1.6; text-align: center; margin: 25px 0 0;">
                                            Si tú no solicitaste este cambio, por favor ignora este mensaje o contacta con nuestro equipo de soporte inmediatamente. Tu cuenta permanecerá segura.
                                        </p>
                                        
                                    </div>
                                    
                                    <!-- PIE DE PÁGINA -->
                                    <div style="background-color: #0d0d0d; padding: 30px; text-align: center; border-radius: 0 0 20px 20px;">
                                        <p style="color: #EA8217; margin: 0 0 5px; font-size: 13px; font-weight: 700; letter-spacing: 0.5px;">
                                            Aventura Go
                                        </p>
                                        
                                        <p style="color: rgba(255,255,255,0.4); margin: 0; font-size: 11px; line-height: 1.6;">
                                            Con cariño, el equipo de Aventura Go
                                        </p>
                                        <div style="margin: 20px 0; height: 1px; background: rgba(255,255,255,0.1);"></div>
                                        <p style="color: rgba(255, 255, 255, 0.84); margin: 0; font-size: 11px; line-height: 1.5;">
                                            © 2024 Aventura Go. Todos los derechos reservados.<br>
                                            Este correo fue enviado porque solicitaste restablecer tu contraseña
                                        </p>
                                    </div>
                                    
                                </div>
                            </div>
                        </body>

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
