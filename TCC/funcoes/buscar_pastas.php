<?php   
    require_once("autentica.php");
    session_name('localhost/tcc/Index');
    include_once("/conectar.php");
    if ($logado == "true"){
    $sessao = $_SESSION["id"];

    $buscar_pastas = " SELECT * FROM pastas WHERE fk_usuario = '$sessao'";
    $buscar = mysqli_query ($con, $buscar_pastas);
    
    while ($row = mysqli_fetch_array($buscar)){
        $id_pasta = $row ['id'];
        $pasta = $row ['nome'];
    
    if ($buscar){
        echo "<li class='nav-item active'> <a class='nav-link' href='index.php'>$pasta</a>";
    }else{
        echo "<li class='nav-item active'> <a class='nav-link' href='index.php'>Você não possui pastas :/</a>";
    }}}
?>