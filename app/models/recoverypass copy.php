
// Incluye la configuración de la base de datos
// require_once __DIR__ . '/../../config/database.php';

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// require_once __DIR__ . '/../../vendor/PHPMailer/Exception.php';
// require_once __DIR__ . '/../../vendor/PHPMailer/PHPMailer.php';
// require_once __DIR__ . '/../../vendor/PHPMailer/SMTP.php';



class Recoverypass
{
    private $conexion; // Propiedad para almacenar la conexión a la base de datos

    // Constructor: se ejecuta automáticamente cuando se crea el objeto
    public function __construct()
    {
        $db = new conexion(); // Crea una nueva instancia de la clase conexion (config/database.php)
        $this->conexion = $db->getConexion(); // Obtiene la conexión PDO y la guarda en $this->conexion
    }

    public function recuperarClave($email, $asunto, $mensaje)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'aventurago.contacto@gmail.com';                     //SMTP username
            $mail->Password   = 'wewjiourqboyxypu';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`


            
            // Imagen del logo
            $mail->addEmbeddedImage(__DIR__ . '/../../public/assets/estilos_globales/img/LOGO-POSITIVO.png', 'logocid');

            //Recipients
            // emison y nombre de la persona o rol 
            $mail->setFrom('aventurago.contacto@gmail.com', 'Soporte Switch Studio');
            // receptor, a quien quiero que llegue el correo
            $mail->addAddress('rodriguezjuana212@gmail.com', 'Juana User');     //Add a recipient
            // $mail->addAddress('ellen@example.com');    mation');
            // $mail->addCC('cc@example.com');           //Name is optional
            // $mail->addReplyTo('info@example.com', 'Infor
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);
            $mail->CharSet = "UTF-8";                            //Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body    = <<<HTML
<div style="font-family: Lato, Arial, sans-serif; background-color: #F8F9FA; padding: 40px;">
    <div style="max-width: 650px; margin: auto; background: #FFFFFF; border-radius: 10px; overflow: hidden; border: 1px solid #E0E0E0;">

        <!-- ENCABEZADO CON COLOR PRIMARIO -->
        <div style="background-color: #2D4059; padding: 25px; text-align: center;">
            <img src="cid:logocid" alt="Aventura Go" style="width: 160px; margin-bottom: 10px;">

            <h2 style="color: #FFFFFF; margin: 0; font-weight: 700; font-family: Raleway, Arial, sans-serif;">
                Nuevo mensaje de contacto
            </h2>
        </div>

        <!-- CONTENIDO -->
        <div style="padding: 30px; color: #2B2B2B; font-size: 16px;">

            <p style="margin-bottom: 15px;">
                <strong style="color: #2D4059;">Email del remitente:</strong><br>
                $email
            </p>

            <p style="margin-bottom: 15px;">
                <strong style="color: #2D4059;">Asunto:</strong><br>
                $asunto
            </p>

            <p style="margin-bottom: 10px;">
                <strong style="color: #2D4059;">Mensaje:</strong>
            </p>

            <div style="background: #F8F9FA; padding: 15px; border-left: 5px solid #EA8217; border-radius: 5px; white-space: pre-line;">
                $mensaje
            </div>

            <!-- BOTÓN DE RESPUESTA -->
            <div style="text-align: center; margin-top: 30px;">
                <a href="mailto:$email"
                    style="background-color: #EA8217; color: #FFFFFF; padding: 12px 24px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 16px;">
                    Responder mensaje
                </a>
            </div>

        </div>

        <!-- PIE DE PÁGINA -->
        <div style="background-color: #2D4059; color: #FFFFFF; padding: 15px; text-align: center; font-size: 13px;">
            Mensaje enviado desde el formulario de contacto de <strong>Aventura Go</strong>.
        </div>

    </div>
</div>
HTML;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
