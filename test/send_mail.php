<?php
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $para = $_POST['to'];

    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor
        $mail->SMTPDebug = 0;                                       // Habilitar salida de depuración detallada
        $mail->isSMTP();                                            // Configurar el mailer para usar SMTP
        $mail->Host       = 'smtp.gmail.com';                       // Servidor SMTP
        $mail->SMTPAuth   = true;                                   // Habilitar autenticación SMTP
        $mail->Username   = 'exequielcasimiro@gmail.com';                   // Tu usuario de SMTP
        $mail->Password   = 'vljtfrdhcqnveytw';                        // Tu contraseña SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Habilitar TLS
        $mail->Port       = 587;                                    // Puerto TCP al que se conecta

        // Destinatarios
        $mail->setFrom('exequielcasimiro@gmail.com', 'Mailer');
        $mail->addAddress($para);                                   // Añadir un destinatario

        // Contenido
        $mail->isHTML(true);                                        // Configurar el formato del email como HTML
        $mail->Subject = 'El título';
        $mail->Body    = 'Hola';

        $mail->send();
        echo 'El mensaje ha sido enviado';
    } catch (Exception $e) {
        echo "No se pudo enviar el mensaje. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
