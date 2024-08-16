<?php
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include_once "../Control/Mailer.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $para = $_POST['to'];

    //$mail = new PHPMailer(true);
    $mail = new Mailer();
    $mail->mandarMail($para);
}
?>
