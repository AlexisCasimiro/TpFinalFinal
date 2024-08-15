<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

//Create an instance; passing true enables exceptions

class Mailer{


    public function mandarMail($para){

        try {
            $mail = new PHPMailer(true);
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
    }// fin function 



}// fin class