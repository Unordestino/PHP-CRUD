<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

class send{

    public function __construct(string $email, string $assunto, string $corpo, int $repetir){
    $mail = new PHPMailer;
    $mail->isSMTP();
    //$mail->SMTPDebug = 2;
    $mail-> Host = 'mail.davisilveira.com.br';
    $mail->Port = 25;
    $mail-> SMTPAuth = true;
    $mail->Username = 'seu-email';
    $mail->Password = 'sua-senha';

    $mail->SMTPSecure = false;
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';

    $mail->setFrom('seu-email', 'Suporte');
    $mail->addAddress("$email");
    $mail->Subject = "$assunto";
    $mail->Body = "$corpo";

    for($i  = 1; $i <= $repetir; $i ++){

        if(!$mail->send())
            die('Falha ao enviar e-mail clique <a href="spam.php">aqui</a> para voltar');
    }
    
    if (headers_sent()) {
        die('E-mails enviados. Por favor, clique neste link: <a href="spam.php">voltar</a>');
    }
    else{
        exit(header("Location: enviado.php"));
    }
}


 

}



?>


<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        
    </body>
</html>
