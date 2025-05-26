<?php 
    session_name('localhost/tcc/Index');
    session_start();
    include_once("../conectar.php");

$sessao = $_SESSION["id"];
$sessaoNome = $_SESSION["nome"];
$sessaoApelido = $_SESSION["apelido"];
$sessaoEmail = $_SESSION["email"];
$sessaoSenha = $_SESSION["senha"];
$senha = md5 ($_POST['senha']);
    
    //Verifica se o campo nome foi preenchido
    if (empty($_POST['nome'])){
        $nome = $sessaoNome;
    } 
    else {
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    }
    
    //Verifica se o campo email foi preenchido
    if (empty($_POST['email'])){
        $email = $sessaoEmail;
    } 
    else {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    }
    
    //Verifica se o campo apelido foi preenchido
    if (empty($_POST['apelido'])){
        $apelido = $sessaoApelido;
    } 
    else {
        $apelido = filter_input(INPUT_POST, 'apelido', FILTER_SANITIZE_STRING);
    }
    



    
    if ($senha == $sessaoSenha) {  
        $query_alterar = "UPDATE usuario SET nome = '$nome', apelido = '$apelido', email = '$email' WHERE `id` = '$sessao' AND `senha` = '$senha'";
        $altera = mysqli_query ($con, $query_alterar) or die ('Erro ao alterar, tente novamente');
        
        $query_verifica = "SELECT * FROM `usuario` WHERE `email` = '$email' AND `senha` = '$senha'";
        $verifica = mysqli_query ($con, $query_verifica) or die( 'Erro ao atualizar');

            
            if ($altera){
                $resultados = mysqli_fetch_array ($verifica);
                $_SESSION['id'] = $resultados['id'];
                $_SESSION['email'] = $resultados['email'];
                $_SESSION['apelido'] = $resultados['apelido'];
                $_SESSION['nome'] = $resultados['nome'];
                $_SESSION['senha'] = $resultados['senha'];
                
                echo"<script language='javascript' type='text/javascript'>
                     alert('Seus dados foram alterados com sucesso!');
                     window.location.href='../index.php?id=Formularios/Perfil'
                     </script>";
            }
            else{      

                echo"<script language='javascript' type='text/javascript'>
                     alert('Ocorreu um erro :/');
                     window.location.href='../index.php?id=Formularios/Perfil';
                     </script>";
                    
            }
  }
?>