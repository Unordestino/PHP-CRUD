<?php
include 'conexao.php';


if(!isset($_SESSION))
    session_start();

if(!isset($_SESSION['admin'])){
    die('Você não está logado. <a href="index.php">Clique aqui</a> para logar.');
}


if(count($_POST) > 0 ){

    $email =  $_POST['email'];
    $assunto =  $_POST['assunto'];
    $mensagem =  $_POST['mensagem'];
    $repeticao =  intval($_POST['repeticao']);
    
    require 'send.php';
    $enviar = new send($email, $assunto, $mensagem, $repeticao);


}



?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Enviar spam</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="estilo.css">
    </head>
    <body>

        <form method="POST" action="" >
            <br>
            <p>
                <label>E-mail</label>
                <input value="<?php if(isset($_POST['email'])) echo $email; ?>" name="email" type="text"><br>
            </p>
            
            <p>
                <label>Assunto</label>
                <input value="<?php if(isset($_POST['assunto'])) echo $assunto; ?>" name="assunto" type="text"><br>
            </p>

            <p>
                <label>Repetição</label>
                <input value="<?php if(isset($_POST['repeticao'])) echo $repeticao; ?>" name="repeticao" type="text"><br>
            </p>

            <p>
                <label>Mensagem</label>
                <br>
                <textarea rows="10" cols="40" maxlength="500" name="mensagem" type="text"><?php if(isset($_POST['mensagem'])) echo $mensagem; ?></textarea><br>
            </p>

            <p>
                <button type="submit">Enviar Spam</button>
                <button><a href="index.php">Voltar</a></button>
            </p>
        </form>
        
    </body>
</html>