<?php

$host = "201.49.40.252";
$db = "davisilv_clientes";
$user = "davisilv_souza";
$pass = "FvyIbw)~}M.+";

$mysqli = new mysqli($host, $user, $pass, $db);

if($mysqli->connect_errno){
    die("Falha na conexão com o banco de dados");
}

function formatar_data($data){
    return implode('/', array_reverse(explode('-', $data)));
}

function formatar_telefone($telefone){
        $ddd = substr($telefone, 0, 2);
        $part1 = substr($telefone, 2, 5);
        $part2 = substr($telefone, 7);
        return "($ddd) $part1-$part2";
}