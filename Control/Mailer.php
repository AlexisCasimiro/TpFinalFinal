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
    private $mail;
    private $nomberDestinatario;
    private $mailDestinatario;
    
    public function __construct($name,$mail){
        $this->mail = new PHPMailer(true);
        $this->mail->CharSet='utf-8';
        $this->mail->isHTML(true);                                  //Set email format to HTML
        $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $this->mail->isSMTP();                                            //Send using SMTP
        $this->mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $this->mail->Username   = 'exequielcasimiro@gmail.com';//'franinsua7@gmail.com';                     //SMTP username
        $this->mail->Password   = 'vljtfrdhcqnveytw';//'nwtrbloritlhvkxq';                               //SMTP password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            // tls  Enable implicit TLS encryption
        $this->mail->Port       = 587;     
        $this->nomberDestinatario=$name;
        $this->mailDestinatario=$mail;                               //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS
        $this->mail->setFrom('exequielcasimiro@gmail.com', 'JP WEB DESIGN');
        
    }// fin constructor 

    public function getNombre(){
        return $this->nomberDestinatario;
    }
    public function getMail(){
        return $this->mailDestinatario;
    }


    public function mandarMail(){

        $this->mail->addAddress($this->getMail(),$this->getNombre());
        //Content
        


        $this->mail->Subject = 'Probando envio de mail';
        $this->mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        
        try{
            $salida=$this->mail->send();
            echo 'Enviado Correctamente';
            return $salida;
        }
        catch (Exception $e){
            return $e;

        }
    }// fin function 



}// fin class