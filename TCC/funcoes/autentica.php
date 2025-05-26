<?php

@session_name('localhost/tcc/Index');
@session_start();
@include_once("/conectar.php");

$logado = false;

@$sessaoId = $_SESSION["id"];

//Consulta usuario logado
if($sessaoId){
    $sql = "SELECT * FROM usuario WHERE id = " . $sessaoId;
    $res = mysqli_query($con, $sql);

    if($res){
        $usuario = mysqli_fetch_all($res, MYSQLI_ASSOC);
        $logado = true;
    } else {
        @session_destroy();
    }
}

?>