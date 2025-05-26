<?php
    session_name('localhost/tcc/Index');
    session_start();
    include_once("../conectar.php");

$sessao = $_SESSION["id"];
$sessaoNome = $_SESSION["nome"];
$sessaoApelido = $_SESSION["apelido"];
$sessaoEmail = $_SESSION["email"];
$sessaoSenha = $_SESSION["senha"];

    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);

    $query_inserir = "INSERT INTO pastas (NOME, FK_USUARIO) VALUES ('$nome','$sessao')";
    $inserir = mysqli_query ($con, $query_inserir);
    
    if ($inserir){
        echo"<script language='javascript' type='text/javascript'>
            alert('pasta criada');
            window.location.href='../index.php';
            </script>";
    } else{
                echo"<script language='javascript' type='text/javascript'>
            alert('deu ruim :/');
            window.location.href='../index.php';
            </script>";
    }


