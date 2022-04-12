<?php 

include "conexao.php";

if(!isset($_SESSION))
    session_start();

if(!isset($_SESSION['usuario'])){
    die('Você não está logado. <a href="index.php">Clique aqui</a> para logar.');
}

$id = intval($_GET['id']);
$sql_cliente = "SELECT * FROM clientes WHERE id = '$id'";
$query_cliente = $mysqli->query($sql_cliente) or die($mysqli->error);

if($query_cliente->num_rows == 0){ // impedi de o usuario alterar a url para deletar
    die("<p>Erro ao editar usuário</p>");
}

$cliente = $query_cliente->fetch_assoc();

function limpar_texto($str){
    return preg_replace("/[^0-9]/", "", $str);
}

if(count($_POST) > 0 ){

    $erro = false;

    $nome =  $_POST['nome'];
    $email =  $_POST['email'];
    $telefone =  $_POST['telefone'];
    $nascimento =  $_POST['nascimento'];

    if(empty($nome)){
        $erro = "Preencha o nome";
    }

    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $erro = "Preencha o e-mail";
    }

    if(!empty($nascimento)){
        $pedacoes = array_reverse(explode('/', $nascimento));
        if(count($pedacoes) == 3){
            $nascimento = implode("-", $pedacoes);         
        }else{
            $erro = "A data de nascimento deve seguir o padrão dia/mes/ano";
        }
    } else{
        $erro = "A data de nascimento deve seguir o padrão dia/mes/ano";
    }

    if(!empty($telefone)){
        $telefone = limpar_texto($telefone);
        if(strlen($telefone) != 11){
            $erro = "O telefone deve ser preenchido no padrão (11) 98888-4444";
        }
    }


    if($erro){
        echo "<p><b>ERRO: $erro</b></p>";
    }else{
        $sql_code = "UPDATE clientes SET nome = '$nome', email = '$email', telefone = '$telefone', nascimento = '$nascimento'
        WHERE id = $id";
        $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
        if($deu_certo){
            echo "<p><b>Alteração feita com sucesso!!</b></p>";
            unset($_POST);
        }
    }

}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente</title>
</head>

<body>
    <a href="clientes.php">Voltar para a lista</a>
    <form method="POST" action="">
        <p>
            <label>Nome</label>
            <input value="<?php echo$cliente['nome']; ?>" name="nome" type="text"><br>
        </p>

        <p>
            <label>E-mail</label>
            <input value="<?php echo $cliente['email']; ?>" name="email" type="text"><br>
        </p>
        
        <p>
            <label>Telefone</label>
            <input value="<?php if(!empty($cliente['telefone'])) echo formatar_telefone($cliente['telefone']); ?>" placeholder="(11) 98888-4444" name="telefone" type="text"><br>
        </p>

        <p>
            <label>Data de Nascimento</label>
            <input value="<?php if(!empty($cliente['nascimento'])) 
            echo date("d/m/Y", strtotime($cliente['nascimento'])); ?>"name="nascimento" type="text"><br>
        </p>

        <p>
            <button type="submit">Editar Cliente</button>
        </p>
    </form>

</body>

</html>