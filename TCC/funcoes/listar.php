<?php
//conecta no banco e verifica sessao
include_once ('/conectar.php');
include_once ('autentica.php');
session_name ('localhost/tcc/Index');

//coleta todos os arquivos do banco
    $sql = "Select * from arquivo";
    $query = mysqli_query($con, $sql);

//define a pagina inicial
    @$pc=$_GET['pagina'];
    if (!$pc) {
        $pagina = "1";
    }
    else {
        $pagina = $pc;
    }

//define valores para paginação
    $total = mysqli_num_rows($query);
    $registros = 15; 
    $numPaginas = ceil($total/$registros); 
    $inicio = ($registros*$pagina)-$registros;
    $limite = "select * from arquivo limit $inicio,$registros";
    $arquivos = mysqli_query ($con, $limite);
    $total = mysqli_num_rows ($arquivos);

//Lista na tela os arquivos do banco
while($row = mysqli_fetch_array($arquivos))
{
//coleta os dados do arquivo  
    $id = $row["id"];      
    $arq = $row["nome"];
    $mascara = $row["titulo"];
    $caminho = $row["caminho"];
    $descricao = $row["descricao"];
    $tamanho = $row["tamanho"];
    $usuario = $row["nome_usuario"];
        echo ("
            <div class='col-sm-9' margin-top='10px'>
                <div class='card'>
                    <div class='d-flex justify-content-between'>
                        <h5 class='card-header'>$mascara</h5>
                        <div class='card-header'>
                            <div id='popup' class='popup'>
                                <p>Nome: $arq</p>
                                <p>Descrição: $descricao</p>
                                <p>Tamanho do Arquivo: $tamanho</p>
                                <p>Enviado por: $usuario</p>
                            </div>
                            <a onMouseOver='abrir();' onMouseLeave='fechar();'>
                                <img src='Imagens/info.png' class='imgInfo'>
                            </a>
                            <a href='funcoes/$caminho' class='btn btn-primary botaoverde'>Download</a>
                        </div>
                    </div>
                </div>
            </div>
            </br>");
}

for($i = 1; $i < $numPaginas + 1; $i++) { 
    echo "<a href='index.php?pagina=$i'>".$i."</a> "; 
} 
?>