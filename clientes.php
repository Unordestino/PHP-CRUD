<?php 
require_once 'conexao.php';

if(!isset($_SESSION))
    session_start();

if(!isset($_SESSION['usuario'])){
    die('Você não está logado. <a href="index.php">Clique aqui</a> para logar.');
}

$id = $_SESSION['usuario'];

$sql_query = $mysqli->query("SELECT * FROM clientes WHERE id = '$id'") or die($mysqli->error);
$usuario = $sql_query->fetch_assoc();


$sql_clientes = "SELECT * FROM clientes";
$query_clientes = $mysqli->query($sql_clientes) or die($mysqli->error);
$num_clientes = $query_clientes->num_rows;


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Lista de Clientes</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="estilo.css">
    <style>
        table tr td{
            padding: 10px;  
        }  
        img{
         
            max-width:320px;
            width: 70px;
            height: 70px;
            border-radius: 50%;
        }
        
    </style>
</head>
<body>

    <p>
        <img height="100px" src="<?php   echo $usuario['path'] ?>" alt="">
        Bem-vindo, <?php echo strtoupper($usuario['nome']) ?>!!! Este são os clientes cadastrados no seu sistema
    </p>

    <h1>Lista de Clientes</h1>

    <table border="1" cellspacing="10">
        <thread>
            <th>ID</th>
            <th>Imagem</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>Nascimento</th>
            <th>Data de Cadastro</th>
            <th>Ações</th>
        </thread>
        <tbody>
            <?php if($num_clientes == 0){ ?>
                <tr>
                    <td colspan="7">Nenhum cliente foi cadastrado</td>
                </tr>
            <?php 
            } else { 
                while($cliente = $query_clientes->fetch_assoc()){    
                
                    $telefone = "Não informado";
                if(!empty($cliente['telefone'])){
                    $telefone = formatar_telefone($cliente['telefone']);
                }
                
                $nascimento = "Não informada";
                if(!empty($cliente['nascimento'])){
                    $nascimento = formatar_data($cliente['nascimento']);
                }
                $data_cadastro = strtotime($cliente['data']);
                $data_cadastro = date("m/d/Y H:i", $data_cadastro);
                ?>
                <tr>
                    <td><?php echo $cliente['id']; ?></td>
                    <td><img src="<?php echo $cliente['path']; ?>" alt=""></td>
                    <td><?php echo $cliente['id'] == $usuario['id'] ?  '<div style="color: red;">' . $cliente['nome']   . "</div> ": $cliente['nome']; ?></td>
                    <td><?php echo $cliente['email']; ?></td>
                    <td><?php echo $telefone; ?></td>
                    <td><?php echo $nascimento; ?></td>
                    <td><?php echo $data_cadastro; ?></td>
                    <td>
                        <a href="editar_cliente.php?id=<?php echo $cliente['id']; ?>">Editar</a>
                        <a href="deletar_cliente.php?id=<?php echo $cliente['id']; ?>">Deletar</a>
                    </td>
                </tr>
            <?php }
            } ?>
        </tbody>
    </table>
    <p> <button><a href="cadastrar.php">Cadastrar</a></button> 
    <button><a href="logout.php">Logout</a></button>
    </p>
    <div class="sistem">
        <p><h3>Sistema para envio de spam: <a href="spam.php">Clique</a></h3></p>   
        <p><h3>Sistema para pesquisar veículos: <a href="buscar.php">Clique</a></h3></p>   
    </div>

</body>
</html>