<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

class sendWelcome{

    public function __construct(string $email){
    $mail = new PHPMailer;
    $mail->isSMTP();
   // $mail->SMTPDebug = 1;
    $mail-> Host = 'mail.davisilveira.com.br';
    $mail->Port = 25;
    $mail-> SMTPAuth = true;
    $mail->Username = 'seu-email';
    $mail->Password = 'sua-senha';

    $mail->SMTPSecure = false;
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';

    $mail->setFrom('suporte@davisilveira.com.br', 'Suporte');
    $mail->addAddress("$email");
    $mail->Subject = "Bem vindo";
    $mail->Body = "<h1>Bem vindo ao sistema Biotec</h1>";

    $mail->send();

    header("location: index.php");

}

}



