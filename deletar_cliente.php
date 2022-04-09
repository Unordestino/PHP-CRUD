<?php 
include 'conexao.php';
if(isset($_POST['confirmar'])){
    $id = intval($_GET['id']);
    $sql_code = "DELETE FROM clientes where id = $id";
    $sql_query = $mysqli->query($sql_code) or die($mysqli->error); 

    if($sql_code){ ?>
        <h1>Cliente deletado com sucesso!</h1>
        <p><a href="clientes.php">Clique aqui</a> para voltar para a lista de clientes.</p>
        <?php
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Deletar Cliente</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <h1>Tem certeza que deseja deletar este cliente?</h1>
        <form action="" method="post">
            <a style="margin-right:40px;" href="clientes.php">Não</a>
            <button name="confirmar" value="1" Type="submit">Sim</button>
        </form>
    </body>
</html>