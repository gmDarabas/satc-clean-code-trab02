<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title> Cadastro </title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>
    <style>
        .image-container {
            position: relative;
        }

        .image {
            opacity: 1;
            display: block;
            width: 100%;
            height: auto;
            transition: .5s ease;
            backface-visibility: hidden;
        }

        .middle {
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }

        .image-container:hover .image {
            opacity: 0.3;
        }

        .image-container:hover .middle {
            opacity: 1;
        }
        .tam{
            width: 60%;
        }
        .fonte{
            color:#83be52 !important;  
            }
    </style>
    <script>
    $(document).ready(function () {
            $imgSrc = $('#imgProfile').attr('src');
            function readURL(input) {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#imgProfile').attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
            $('#btnChangePicture').on('click', function () {
                // document.getElementById('profilePicture').click();
                if (!$('#btnChangePicture').hasClass('changing')) {
                    $('#profilePicture').click();
                }
                else {
                    // change
                }
            });
            $('#profilePicture').on('change', function () {
                readURL(this);
                $('#btnChangePicture').addClass('changing');
                $('#btnChangePicture').attr('value', 'Confirm');
                $('#btnDiscard').removeClass('d-none');
                // $('#imgProfile').attr('src', '');
            });
            $('#btnDiscard').on('click', function () {
                // if ($('#btnDiscard').hasClass('d-none')) {
                $('#btnChangePicture').removeClass('changing');
                $('#btnChangePicture').attr('value', 'Change');
                $('#btnDiscard').addClass('d-none');
                $('#imgProfile').attr('src', $imgSrc);
                $('#profilePicture').val('');
                // }
            });
        });
    </script>
</head>
    
<body>
<?php
        $sessao = $_SESSION["id"];
        $sessaoNome = $_SESSION["nome"];
        $sessaoApelido = $_SESSION["apelido"];
        $sessaoEmail = $_SESSION["email"];
        $sessaoSenha = $_SESSION["senha"];

echo ("
<div class='container'>
        <div class='row'>
            <div class='col-12'>
                <div class='card'>

                    <div class='card-body'>
                        <div class='card-title mb-4'>
                            <div class='d-flex justify-content-start'>
                                <div class='image-container'>
                                    <img src='http://placehold.it/150x150' id='imgProfile' style='width: 150px; height: 150px' class='img-thumbnail' />
                                    <div class='middle'>
                                        <input type='button' class='btn btn-secondary botaoverde' id='btnChangePicture' value='Change' />
                                        <input type='file' style='display: none;' id='profilePicture' name='file' />
                                    </div>
                                </div>
                                <div class='userData ml-3'>
                                    <h2 class='d-block fonte' style='font-size: 1.5rem; font-weight: bold'><a href='' class='fonte'>$sessaoApelido</a></h2>
                                    <!--<h6 class='d-block'><a href='javascript:void(0)'>1,500</a> Video Uploads</h6>
                                    <h6 class='d-block'><a href='javascript:void(0)'>300</a> Blog Posts</h6>-->
                                    
                                </div>
                                <div class='ml-auto'>
                                    <input type='button' class='btn btn-primary d-none' id='btnDiscard' value='Discard Changes' />
                                </div>
                            </div>
                        </div>

                        <div class='row'>
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
                                        <div class='row'>
                                            <div class='col-sm-3 col-md-2 col-5'>
                                                <label style='font-weight:bold;'>Nome</label>
                                            </div>
                                            <div class='col-md-8 col-6'>
                                                $sessaoNome
                                            </div>
                                        </div>
                                        <hr />

                                        <div class='row'>
                                            <div class='col-sm-3 col-md-2 col-5'>
                                                <label style='font-weight:bold;'>Apelido</label>
                                            </div>
                                            <div class='col-md-8 col-6'>
                                                $sessaoApelido
                                            </div>
                                        </div>
                                        <hr />
                                        
                                        
                                        <div class='row'>
                                            <div class='col-sm-3 col-md-2 col-5'>
                                                <label style='font-weight:bold;'>E-Mail</label>
                                            </div>
                                            <div class='col-md-8 col-6'>
                                                $sessaoEmail
                                            </div>
                                        </div>
                                        <hr />

                                    </div>
                                    
                                    <div class='tab-pane fade' id='connectedServices' role='tabpanel' aria-labelledby='ConnectedServices-tab'>
                                        <form method=  'post' action='funcoes_usuario/alterar.php' enctype='multipart/form-data'>
                                        <div class='row'>
                                            <div class='col-sm-3 col-md-2 col-5'>
                                                <label style='font-weight:bold;'>Nome</label>
                                            </div>
                                            <div class='col-md-8 col-6'>
                                                <input class='tam' id='nome' name='nome' type='text' placeholder='Insira aqui seu novo Nome' />
                                            </div>
                                        </div>
                                        <hr />

                                        <div class='row'>
                                            <div class='col-sm-3 col-md-2 col-5'>
                                                <label style='font-weight:bold;'>Apelido</label>
                                            </div>
                                            <div class='col-md-8 col-6'>
                                                <input class='tam' id='apelido' name='apelido' type='text' placeholder='Insira aqui seu novo Apelido' />
                                            </div>
                                        </div>
                                        <hr />
                                        
                                        
                                        <div class='row'>
                                            <div class='col-sm-3 col-md-2 col-5'>
                                                <label style='font-weight:bold;'>E-Mail</label>
                                            </div>
                                            <div class='col-md-8 col-6' >
                                                <input class='tam' id='email' name='email' type='text' placeholder='Insira aqui seu novo Email' />
                                            </div>
                                        </div>
                                        <hr />
                                        
                                         <div class='row'>
                                            <div class='col-sm-3 col-md-2 col-5'>
                                                <label style='font-weight:bold;'>Senha</label>
                                            </div>
                                            <div class='col-md-8 col-6' >
                                                <input class='tam' id='senha' name='senha' required='required' type='password' placeholder='Insira sua senha para realizar alterações' />
                                            </div>
                                        </div>
                                        <hr />
                                        <div class='col-sm-3 col-md-2 col-5'>
                                              <input type='submit' class='btn btn-secondary botaoverde' id='btnChangePicture' value='Alterar' />  
                                        </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
<!--");
?>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.full.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</html>