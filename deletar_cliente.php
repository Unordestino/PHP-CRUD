<?php 
include 'conexao.php';

if(!isset($_SESSION))
    session_start();

if(!isset($_SESSION['usuario'])){
    die('Você não está logado. <a href="index.php">Clique aqui</a> para logar.');
}


if(isset($_POST['confirmar'])){
    $id = intval($_GET['id']);
    
    if($id == $_SESSION['usuario'])
        die('<p>Não é permitido deletar seu próprio usuário... <a href="clientes.php">Clique aqui</a> para voltar.</p>');


        $dele_img = $mysqli->query("SELECT * FROM clientes WHERE id = '$id'") or die($mysqli->error);
        $arquivo = $dele_img->fetch_assoc();

        $adm = $mysqli->query("SELECT * FROM clientes WHERE email = 'hzpck17@gmail.com'") or die($mysqli->error);
        $result = $adm->fetch_assoc();

        if($result['id'] == $id){
            die("Não é possível deletar uma conta de administrador");
        }
        
        if(unlink($arquivo['path'])){ // verifica se a imagem existe para deletar do banco e do sistema
            $sql_code = "DELETE FROM clientes where id = $id";
            $sql_query = $mysqli->query($sql_code) or die($mysqli->error); 
         }



    ?>
        <h1>Cliente deletado com sucesso!</h1>
        <p><a href="clientes.php">Clique aqui</a> para voltar para a lista de clientes.</p>
        <?php
        die();
    
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Deletar Cliente</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="estilo.css">
    </head>
    <body>
        <h1>Tem certeza que deseja deletar este cliente?</h1>
        <form action="" method="post">
            <a style="margin-right:40px;" href="clientes.php">Não</a>
            <button name="confirmar" value="1" Type="submit">Sim</button>
        </form>
    </body>
</html>