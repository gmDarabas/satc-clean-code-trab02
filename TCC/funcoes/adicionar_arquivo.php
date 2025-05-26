<?php
    include_once ('/conectar.php');
    include_once ('autentica.php');
    session_name ('localhost/tcc/Index');
    
    //Coleta qual pasta foi escolhida
    $pasta = $_POST ('$id_pasta');
    
