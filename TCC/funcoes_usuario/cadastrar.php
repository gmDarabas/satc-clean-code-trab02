<?php
//Conecta no Banco
include_once ('../conectar.php');

//Recolhe valores do formulário
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$apelido = filter_input(INPUT_POST, 'apelido', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
$senha = MD5($_POST['senha']);
    
//Recolhe emails cadastrados no BD
$query_select = ("SELECT email FROM usuario WHERE email = '$email'");
$select = mysqli_query ($con, $query_select);
$array = mysqli_fetch_array ($select);
$arrayemail = $array ['email'];
    
    //testa se o campo email esta vazio
    if($email == "" || $email == null){
        echo"<script language='javascript' type='text/javascript'>
             alert('O campo login deve ser preenchido');
             window.location.href='../index.php?id=Formularios/Cadastrar';
             </script>";
    }
    //testa se o email ja está cadastrado
    else{
        if($arrayemail == $email){
            echo"<script language='javascript' type='text/javascript'>
            alert('Esse login já existe');
            window.location.href='../index.php?id=Formularios/Cadastrar';
            </script>";
        die();
    }
    //insere o usuario na tabela
    else{
        $query_insert =  "INSERT INTO usuario (nome, apelido, email, senha, criado) VALUES ('$nome', '$apelido', '$email', '$senha', NOW())";
        $insert = mysqli_query($con, $query_insert) or die (mysqli_error($con));
        
        //testa se o usuario foi cadastrado
        if($insert){
            echo"<script language='javascript' type='text/javascript'>
                 alert('Usuário cadastrado com sucesso!');
                 window.location.href='../index.php?'
                 </script>";
        }
        else{
            echo"<script language='javascript' type='text/javascript'>
                 alert('Não foi possível cadastrar esse usuário');
                 </script>";
        }
      }
    }
?>
