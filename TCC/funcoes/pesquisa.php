<?php
include_once ('/conectar.php');
include_once ('autentica.php');
session_name ('localhost/tcc/Index');

  $con;
	// Pegamos a palavra
	$palavra = trim($_POST['pesquisar']);
 
	// Verificamos no banco de dados produtos equivalente a palavra digitada
	$sql =  ("SELECT * FROM arquivo WHERE titulo LIKE '%".$palavra."%' ORDER BY titulo");
  $arquivos = mysqli_query ($con, $sql);
  $numRegistros = mysqli_num_rows($arquivos);
  //
  $sqlusuario = ("SELECT * FROM usuario WHERE apelido LIKE '%".$palavra."%' ORDER BY apelido");
  $usuarios = mysqli_query ($con, $sqlusuario);
  $numUsuarios = mysqli_num_rows($usuarios);
  echo ("<div class='row'>
  <div class='col-12'>
      <ul class='nav nav-tabs mb-4' id='myTab' role='tablist'>
          <li class='nav-item'>
              <a class='nav-link active fonte' id='basicInfo-tab' data-toggle='tab' href='#basicInfo' role='tab' aria-controls='basicInfo' aria-selected='true'>Informações</a>
          </li>
          <li class='nav-item'>
              <a class='nav-link fonte' id='connectedServices-tab' data-toggle='tab' href='#connectedServices' role='tab' aria-controls='connectedServices' aria-selected='false'>Alterar Informações</a>
          </li>
      </ul>
      <div class='tab-content ml-1' id='myTabContent'>
          <div class='tab-pane fade show active' id='basicInfo' role='tabpanel' aria-labelledby='basicInfo-tab'>
");
	// Se houver pelo menos um registro, exibe-o
	if ($numRegistros != 0) {

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
            </br>
");
}}  
else {
  echo "Nenhum arquivo foi encontrado com a palavra ".$palavra." ";
}
echo ("</div><div class='tab-pane fade' id='connectedServices' role='tabpanel' aria-labelledby='ConnectedServices-tab'>");
if ($numUsuarios != 0) {
  while($n = mysqli_fetch_array($usuarios)){

  $idUsuario = $n ["id"];   
  $nomeUsuario = $n ["nome"];
  $apelidoUsuario = $n ["apelido"];

  echo ("
  <div class='col-sm-9' margin-top='10px'>
  <div class='card'>
      <div class='d-flex justify-content-between'>
          <h5 class='card-header'>$apelidoUsuario</h5>
              <a href='funcoes/' class='btn btn-primary botaoverde'>Visualizar</a>
          </div>
      </div>
  </div>

</br>
");
}}else {
		echo "Nenhum usuario foi encontrado com a palavra ".$palavra." </div>
  
    </div>
    </div>
  </div>
  </div>";
  }
echo ("</div>")
?>