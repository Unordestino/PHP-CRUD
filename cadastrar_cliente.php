<?php 



function limpar_texto($str){
    return preg_replace("/[^0-9]/", "", $str);
}

if(count($_POST) > 0 ){
    include "conexao.php";
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
        $sql_code = "INSERT INTO clientes (nome, email, telefone, nascimento, data) 
        VALUES ('$nome', '$email', '$telefone', '$nascimento', NOW())";
        $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
        if($deu_certo){
            echo "<p><b>Cliente cadastrado com sucesso!!</b></p>";
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
            <input value="<?php if(isset($_POST['nome'])) echo $nome; ?>" name="nome" type="text"><br>
        </p>

        <p>
            <label>E-mail</label>
            <input value="<?php if(isset($_POST['email'])) echo $email; ?>" name="email" type="text"><br>
        </p>
        
        <p>
            <label>Telefone</label>
            <input value="<?php if(isset($_POST['telefone'])) echo $telefone; ?>" placeholder="(11) 98888-4444" name="telefone" type="text"><br>
        </p>

        <p>
            <label>Data de Nascimento</label>
            <input value="<?php if(isset($_POST['nascimento'])) echo $nascimento; ?>" name="nascimento" type="text"><br>
        </p>

        <p>
            <button type="submit">Salvar Cliente</button>
        </p>
    </form>

</body>

</html>