<?php 
    //Conecta no Banco
    include_once("../conectar.php");
// variáveis recebem os dados
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$senha = md5($_POST['senha']);
$entrar = $_POST['entrar'];

    if (isset($entrar)) {  
        $query_verifica = "SELECT * FROM `usuario` WHERE `email` = '$email' AND `senha` = '$senha'";
        $verifica = mysqli_query ($con, $query_verifica) or die("erro ao selecionar");

            if (mysqli_num_rows($verifica)<=0){
                echo"<script language='javascript' type='text/javascript'>
                     alert('email e/ou senha incorretos');
                     window.location.href='../index.php?id=Formularios/Login'
                     </script>";
            }
            else{      
                $resultados = mysqli_fetch_array ($verifica);
                session_name('localhost/tcc/Index');
                session_start();
                $_SESSION['id'] = $resultados['id'];
                $_SESSION['email'] = $email;
                $_SESSION['apelido'] = $resultados['apelido'];
                $_SESSION['nome'] = $resultados['nome'];
                $_SESSION['senha'] = $resultados['senha'];
                
                echo"<script language='javascript' type='text/javascript'>
                     alert('Bem-Vindo!');
                     window.location.href='../index.php?id=Formularios/Perfil';
                     </script>";
                    
            }
  }
?>