<?php



    $arquivo = $_FILES['arquivo'];

    if($arquivo['error'])
        die("Falha ao enviar arquivo");

    if($arquivo['size'] > 5242880)
        die("Arquivo muito grande!! Max: 5MB");

    $pasta = "arquivos/";
    $nomeDoArquivo = $arquivo['name'];
    $novoNomeDoArquivo = uniqid(); //Função que me retorta um if aleatorio unico que não se repete
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

    if($extensao != "jpg" && $extensao != 'png' && $extensao  != 'jpeg')
        die('Tipo de arquivo não aceito');

    $path = $pasta . $novoNomeDoArquivo . '.' . $extensao;

    $deu_certo = move_uploaded_file($arquivo['tmp_name'], $path);

   