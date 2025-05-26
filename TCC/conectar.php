<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$dbname = "sharetorrent";

//Criar a conexao
$con = mysqli_connect($servidor, $usuario, $senha, $dbname) or die ("Sem acesso ao bd");
?>