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
                // Generación de la nueva contraseña
                $base = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
                $random = str_shuffle($base);
                $nuevaClave = substr($random, 0, 6); // 6 caracteres

                $claveHash = password_hash($nuevaClave, PASSWORD_BCRYPT);

                // Actualizamos la contraseña en la base de datos
                $actualizar = "UPDATE usuario SET clave = :nuevaClave WHERE id_usuario = :id";
                $stmtActualizar = $this->conexion->prepare($actualizar);
                $stmtActualizar->bindParam(':nuevaClave', ($claveHash));
                $stmtActualizar->bindParam(':id', $user['id_usuario']);
                $stmtActualizar->execute();

                // Inicialización y configuración del correo electrónico
                $mail = mailer_init();

                $mail->setFrom('aventurago.contacto@gmail.com', 'Soporte Aventura_go');
                $mail->addAddress($user['email'], $user['nombre']);

                $mail->Subject = "🔒 Tu Nueva Contraseña Temporal para Aventura GO";
                $mail->isHTML(true);

                // INICIO DEL BLOQUE HTML MEJORADO (Heredoc Corregido)
                $mail->Body = <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Contraseña | Aventura GO</title>
</head>
<body style="margin: 0; padding: 0;">
    <div style="font-family: Arial, sans-serif; background-color: #1A1A1A; padding: 40px 10px;">
        <div style="max-width: 600px; margin: auto; background: #2B2B2B; border-radius: 10px; overflow: hidden;">

            <div style="background-color: #2D4059; padding: 30px; text-align: center;">
                <img src="https://raw.githubusercontent.com/Albert-Gutierrez/Aventura-Go/refs/heads/main/assets/estilos_globales/img/LOGO-POSITIVO.png" alt="Aventura Go" style="width: 150px; margin-bottom: 5px;">
                <!-- <h1 style="color: #FFFFFF; font-size: 24px; margin: 5px 0 0; font-weight: bold;">Aventura GO</h1> -->
                <p style="color: #A9A9A9; font-size: 14px; margin: 0;">Tu compañero de aventuras</p>
            </div>

            <div style="padding: 30px; color: #CCCCCC; font-size: 16px; line-height: 1.5;">

                <h2 style="color: #FFFFFF; margin: 0 0 20px; text-align: center; font-size: 18px; font-weight: bold;">
                    ¡SOLICITUD DE RESTABLECIMIENTO RECIBIDA!
                </h2>
                
                <p style="margin-bottom: 20px; text-align: center;">
                    Hemos generado una **clave temporal** que te permitirá acceder de forma segura a tu cuenta.
                </p>

                <div style="background-color: #383838; padding: 25px; border-radius: 8px; text-align: center; margin-bottom: 25px;">
                    <p style="margin: 0 0 10px; color: #FF9900; font-size: 14px; font-weight: bold;">
                        TU NUEVA CONTRASEÑA TEMPORAL:
                    </p>
                    <p style="margin: 0; color: #FFFFFF; font-size: 32px; font-weight: bold; font-family: 'Courier New', Courier, monospace; letter-spacing: 2px;">
                        $nuevaClave
                    </p>
                </div>

                <div style="background-color: #404000; border: 1px solid #707000; padding: 15px; border-radius: 6px; margin-bottom: 25px;">
                    <p style="margin: 0; color: #FFD700; font-size: 15px; line-height: 22px;">
                        <span style="font-weight: bold;">⚠️ Seguridad Obligatoria:</span> Por tu protección, esta clave es de un solo uso. Debes cambiarla **inmediatamente** después de iniciar sesión en tu perfil.
                    </p>
                </div>

                <!-- <div style="text-align: center; margin-bottom: 30px;">
                    <a href="aventura_go/login" target="_blank" style="background-color: #FF9900; color: #2D4059; padding: 15px 30px; border-radius: 6px; font-size: 18px; font-weight: bold; text-decoration: none; display: inline-block;">
                        INICIAR SESIÓN AHORA
                    </a>
                </div> -->

                <p style="margin-bottom: 0; text-align: center; font-size: 14px; color: #A9A9A9;">
                    Si no solicitaste este cambio, por favor contacta a nuestro equipo de soporte inmediatamente.
                </p>
            </div>

            <div style="background-color: #101010; color: #777777; padding: 15px; text-align: center; font-size: 12px;">
                <p style="margin: 0 0 5px;">Este correo fue enviado desde el formulario de recuperación de contraseña de **Aventura GO**.</p>
                <p style="margin: 0;">© 2025 Aventura GO. Todos los derechos reservados.</p>
            </div>

        </div>
    </div>
</body>
</html>
HTML; // <-- ¡Este identificador debe estar pegado al margen izquierdo!
                // FIN DEL BLOQUE HTML

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
