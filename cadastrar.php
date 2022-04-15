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
    $senha =(string) $_POST['senha'];

    if(empty($nome)){
        $erro = "Preencha o nome";
    }

    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $erro = "Preencha o e-mail";
    }

    if(empty($senha)){
        $erro = "Senha não pode ser vazia";
    }else if(mb_strlen($senha) < 8 || mb_strlen($senha) > 20){
        $erro = "Preencha uma senha válida com até 8 caracteres";
    }else{
        $senha = password_hash($senha, PASSWORD_DEFAULT);
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

    if(isset($_FILES["arquivo"])){
        
    
        include("arquivos.php");

    }


    if($erro){
        echo "<p><b>ERRO: $erro</b></p>";
    }else{
        $sql_code = "INSERT INTO clientes (nome, foto, path, email, senha, telefone, nascimento, data) 
        VALUES ('$nome', '$nomeDoArquivo', '$path', '$email', '$senha' , '$telefone', '$nascimento', NOW())";
        $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
        if($deu_certo){
            session_start();

            if($_SESSION['usuario'])
                header("location: clientes.php");
            else
                header("location: index.php");
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
    <form method="POST" action="" enctype="multipart/form-data" >
        <p>
            <label>Nome</label>
            <input value="<?php if(isset($_POST['nome'])) echo $nome; ?>" name="nome" type="text"><br>
        </p>

        <p>
            <label>E-mail</label>
            <input value="<?php if(isset($_POST['email'])) echo $email; ?>" name="email" type="text"><br>
        </p>

        <p>
            <label>Senha</label>
            <input name="senha" type="text"><br>
        </p>
        
        <p>
            <label>Telefone</label>
            <input value="<?php if(isset($_POST['telefone'])) echo $telefone; ?>" placeholder="(11) 98888-4444" name="telefone" type="text"><br>
        </p>

        <p>
            <label>Data de Nascimento</label>
            <input value="<?php if(isset($_POST['nascimento'])) echo date("d/m/Y", strtotime($nascimento)); ?>" name="nascimento" type="text"><br>
        </p>

        <p>
            <label for="">Selecione uma imagem de perfil</label>
            <input name="arquivo" type="file">
            <hr>
        </p>

        <p>
            <button type="submit">Salvar Cliente</button>
            <button><a href="index.php">Login</a></button>
        </p>
    </form>

</body>

</html>