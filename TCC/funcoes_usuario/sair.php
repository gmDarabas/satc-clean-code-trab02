<?php
//sair
@session_name('localhost/tcc/Index');
require_once("/funcoes/autentica.php");

$logado = false;
session_destroy();
	echo ('<script>
           		alert("Deslogado"); 
                location.href="index.php?";
            </script>');

?>