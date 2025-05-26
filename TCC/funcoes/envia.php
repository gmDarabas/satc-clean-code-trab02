<?php
//inicia sessão e conecta ao banco de dados
    include_once ("../conectar.php");
    include_once ("autentica.php");
    $sessaoApelido = $_SESSION["apelido"];

//Função para conversão de bytes (php.net)
function formatBytes($bytes, $precision = 2) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 

     $bytes /= pow(1024, $pow);

    return round($bytes, $precision) . ' ' . $units[$pow]; 
} 

//recolhe os dados do formulário
    $arquivo = $_FILES ["arquivo"]['name'];
    $mascara = filter_input (INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
//recolhe extensão do arquivo
    $extensao = pathinfo ($arquivo);
    $extensao = $extensao ['extension'];
//recolhe tamanho do arquivo
    $tamanho = $_FILES["arquivo"]["size"];
    $tamanhoKbytes = formatBytes ($tamanho);

//formatar o nome do arquivo
    $nome = str_replace(" ","_",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($mascara))));

//salvar alguns dados no banco de dados
if ($extensao == "torrent" || $extensao == "TORRENT"){
    $query_insert = "INSERT INTO arquivo (titulo, descricao, tamanho, nome_usuario, criado) VALUES ('$mascara', '$descricao', '$tamanhoKbytes', '$sessaoApelido', NOW())";
    $insert = mysqli_query ($con, $query_insert);

//seleciona os dados salvos para pegar a id
    $query_select = "SELECT * FROM `arquivo` WHERE `titulo` = '$mascara' AND `descricao` = '$descricao' AND `tamanho` = '$tamanhoKbytes' AND `nome_usuario` = '$sessaoApelido' ";
    $select = mysqli_query ($con, $query_select);
    
    $resultado = mysqli_fetch_array ($select);
    $id = $resultado['id'];

//salvar arquivo na maquina
    $nomeFinal = $nome . $id;
    $destino = 'arquivos/' . $nomeFinal . ".torrent";
    $arquivo_tmp = $_FILES ["arquivo"]['tmp_name'];
        move_uploaded_file( $arquivo_tmp, $destino);
    
//salvar alterações no banco    
    $query_update2 = "UPDATE arquivo SET nome = '$nomeFinal', caminho = '$destino' WHERE id = '$id'";
    $insert2 = mysqli_query ($con, $query_update2);

    if ($insert && $insert2){
        echo"<script language='javascript' type='text/javascript'>
        alert('Arquivo enviado com sucesso!');
        window.location.href='../index.php?';
        </script>";
    } else {
        echo"<script language='javascript' type='text/javascript'>
        alert('Ocorreu um erro tente novamente!');
        window.location.href='../index.php?id=Formularios/Envio';
        </script>";
    }
} elseif ($extensao <> "torrent" || $extensao <> "TORRENT"){
    echo"<script language='javascript' type='text/javascript'>
    alert('O arquivo deve ser um torrent!');
    window.location.href='../index.php?id=Formularios/Envio';
    </script>";
}


     //2000000
?>




