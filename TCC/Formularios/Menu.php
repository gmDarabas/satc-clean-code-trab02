<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">ShareTorrent</a>
        <nav class="navbar navbar-light bg-light">
            <!--<a href="index.php" class="navbar-brand">
                <img src="Imagens/Logo.png" width="90" height="50" alt="">
            </a>-->
        </nav>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            </ul>

            <!-- Barra e Botão de pesquisa -->
            <form class="form-inline my-2 my-lg-0" action="Index.php?id=funcoes/pesquisa" method="post">
                <input class="form-control mr-sm-2" type="text" placeholder="Pesquisar arquivos" aria-label="Search" name="pesquisar" id="pesquisar">
                <button class="btn btn-outline-success btnPesquisar my-2 my-sm-0 " type="submit">Pesquisar</button>
            </form>

            <!-- BOTAO  DE SESSAO -->
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle btCadastro" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Iniciar Sessão
                </button>
                <?php if ($logado) { ?>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="index.php?id=Formularios/Perfil">Perfil</a>
                        <a class="dropdown-item" href="index.php?id=funcoes_usuario/sair">Sair</a>
                    </div>
                <?php } else { ?>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="index.php?id=Formularios/Login">Login</a>
                        <a class="dropdown-item" href="index.php?id=Formularios/Cadastrar">Cadastro</a>
                    </div>
                
                <?php } ?>
            </div>
        </div>
    </nav>