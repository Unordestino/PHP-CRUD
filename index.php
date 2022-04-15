<?php

if (isset($_POST['email'])) {
    require 'conexao.php';
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql_code = "SELECT * FROM clientes WHERE email = '$email'";
    $sql_exec = $mysqli->query($sql_code) or die($mysqli->error);

    $usuario = $sql_exec->fetch_assoc();
    if (isset($usuario['senha'])) {


        if (password_verify($senha, $usuario['senha'])) {
            if (!isset($_SESSION)) {
                session_start();

                $_SESSION['usuario'] = $usuario['id'];
                header("location: clientes.php");
            }
        } else {
            echo "Senha inválida...";
        }
    } else {
        echo "E-mail inválido...";
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

    <form action=""  method="POST">
        <p>
            <label for="">E-mail</label>
            <input type="text" name="email">
        </p>

        <p>
            <label for="">Senha</label>
            <input type="text" name="senha">
        </p>
        <button type="submit">LOGAR</button>
        <button type="submit"><a href="cadastrar.php">CADASTRAR</a></button>

    </form>

</body>

</html>