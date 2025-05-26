<?php require_once("funcoes/autentica.php");?>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style_index.css">
    <title>ShareTorrent</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>
<script>
    jQuery(document).ready(function() {

        jQuery("#subirTopo").hide();

        jQuery('a#subirTopo').click(function() {
            jQuery('body,html').animate({
                scrollTop: 0
            }, 200);
            return false;
        });

        jQuery(window).scroll(function() {
            if (jQuery(this).scrollTop() > 0) {
                jQuery('#subirTopo').fadeIn();
            } else {
                jQuery('#subirTopo').fadeOut();
            }
        });
});
</script>

<script type="text/javascript"> 
function abrir(){
    document.getElementById('popup').style.display = 'block';
}
function fechar(){
    document.getElementById('popup').style.display = 'none';
}
</script>
</head>

<body>
    <!-- Navbar Principal -->
    <?php include_once("Formularios/Menu.php") ?>
    <br>

    <!--Incluir novas abas dentro da pagina principal-->
    <div class="container" id="conteudo" align="center">
        <?php
            if (!isset($_GET['id'])) {
                include("funcoes/listar.php");
            } else {
                $id = $_GET['id'];
                include("$id.php");
            }
        ?>
    </div>


    <!--Botão para upload de arquivos-->
    <a class="btEnvio" href="index.php?id=Formularios/Envio">
        <img src="Imagens/Upload.jpg" class="imgEnvio">
    </a>

    <!--Botão "subir ao topo"-->
    <a id="subirTopo">
        <img src="Imagens/topo.png" class="imgSubir">
    </a>



</body>
<script src="https://code.jquery.com/jquery-3.3.1.full.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>