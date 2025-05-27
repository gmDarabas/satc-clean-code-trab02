<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'ShareTorrent') ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    
    <style>
        .file-card {
            transition: transform 0.2s ease-in-out;
        }
        .file-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .upload-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            z-index: 1000;
        }
        .back-to-top {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            z-index: 1000;
            display: none;
        }
        .popup-info {
            position: absolute;
            background: rgba(0,0,0,0.9);
            color: white;
            padding: 10px;
            border-radius: 5px;
            display: none;
            z-index: 1001;
            max-width: 300px;
            font-size: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
        .file-size {
            color: #6c757d;
            font-size: 0.85em;
        }
        .file-date {
            color: #6c757d;
            font-size: 0.8em;
        }
        .seeders-leechers {
            font-size: 0.8em;
        }
        .seeders {
            color: #198754;
        }
        .leechers {
            color: #dc3545;
        }
        .navbar-brand {
            font-size: 1.5rem;
        }
        .alert {
            margin-bottom: 0;
            border-radius: 0;
        }
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1200px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">📁 ShareTorrent</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav me-auto">
                    <a class="nav-link" href="/">Início</a>
                    <a class="nav-link" href="/categories">Categorias</a>
                    <?php if ($isLoggedIn): ?>
                        <a class="nav-link" href="/files/my-files">Meus Arquivos</a>
                    <?php endif; ?>
                </div>
                
                <!-- Busca -->
                <form class="d-flex me-3" action="/search" method="post">
                    <input class="form-control me-2" type="search" name="pesquisar" 
                           placeholder="Pesquisar arquivos..." value="<?= htmlspecialchars($search ?? '') ?>">
                    <button class="btn btn-outline-light" type="submit">Buscar</button>
                </form>
                
                <!-- Usuário -->
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" 
                            id="userDropdown" data-bs-toggle="dropdown">
                        <?= $isLoggedIn ? 'Olá, ' . htmlspecialchars($currentUser->getUsername()) : 'Entrar' ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <?php if ($isLoggedIn): ?>
                            <li><a class="dropdown-item" href="/auth/profile">
                                <i class="fas fa-user me-2"></i>Perfil
                            </a></li>
                            <li><a class="dropdown-item" href="/files/my-files">
                                <i class="fas fa-folder me-2"></i>Meus Arquivos
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/auth/logout">
                                <i class="fas fa-sign-out-alt me-2"></i>Sair
                            </a></li>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="/auth/login">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </a></li>
                            <li><a class="dropdown-item" href="/auth/register">
                                <i class="fas fa-user-plus me-2"></i>Cadastro
                            </a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mensagens Flash -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= $_SESSION['success'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= $_SESSION['error'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['warning'])): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= $_SESSION['warning'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['warning']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['info'])): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            <?= $_SESSION['info'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['info']); ?>
    <?php endif; ?>

    <!-- Conteúdo Principal -->
    <main class="container mt-4">
        <?php
        if (isset($content)) {
            $contentPath = __DIR__ . '/../' . $content . '.php';
            if (file_exists($contentPath)) {
                require $contentPath;
            } else {
                echo '<div class="alert alert-warning">Conteúdo não encontrado.</div>';
            }
        }
    ?>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>ShareTorrent</h5>
                    <p class="mb-0">Plataforma de compartilhamento de arquivos via torrent.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; <?= date('Y') ?> ShareTorrent. Todos os direitos reservados.</p>
                    <small class="text-muted">Desenvolvido com ❤️</small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Botão de Upload -->
    <?php if ($isLoggedIn): ?>
        <a href="/files/upload" class="btn btn-success upload-btn d-flex align-items-center justify-content-center" 
           title="Enviar arquivo" data-bs-toggle="tooltip">
            <i class="fas fa-plus fa-lg"></i>
        </a>
    <?php endif; ?>

    <!-- Botão Voltar ao Topo -->
    <button class="btn btn-secondary back-to-top" id="backToTop" onclick="scrollToTop()"
            title="Voltar ao topo" data-bs-toggle="tooltip">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>
    
    <script>
        // Inicializar tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Botão voltar ao topo
        window.onscroll = function() {
            const backToTop = document.getElementById('backToTop');
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                backToTop.style.display = 'block';
            } else {
                backToTop.style.display = 'none';
            }
        };

        function scrollToTop() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }

        // Popup de informações
        function showInfo(event, fileInfo) {
            event.preventDefault();
            
            // Remove popups existentes
            const existingPopups = document.querySelectorAll('.popup-info');
            existingPopups.forEach(popup => popup.remove());
            
            // Cria novo popup
            const popup = document.createElement('div');
            popup.className = 'popup-info';
            popup.innerHTML = fileInfo;
            popup.style.left = (event.pageX + 10) + 'px';
            popup.style.top = (event.pageY + 10) + 'px';
            popup.style.display = 'block';
            
            document.body.appendChild(popup);
            
            // Remove popup após 3 segundos ou ao clicar em qualquer lugar
            setTimeout(() => {
                popup.remove();
            }, 3000);
            
            document.addEventListener('click', function hidePopup() {
                popup.remove();
                document.removeEventListener('click', hidePopup);
            });
        }

        // Auto-hide alerts após 5 segundos
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Formatação de tamanho de arquivo
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Formatação de data relativa
        function timeAgo(date) {
            const now = new Date();
            const diffTime = Math.abs(now - date);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if (diffDays === 1) return 'Ontem';
            if (diffDays < 7) return `${diffDays} dias atrás`;
            if (diffDays < 30) return `${Math.ceil(diffDays / 7)} semanas atrás`;
            if (diffDays < 365) return `${Math.ceil(diffDays / 30)} meses atrás`;
            return `${Math.ceil(diffDays / 365)} anos atrás`;
        }

        // Confirmação antes de deletar
        function confirmDelete(filename) {
            return confirm(`Tem certeza que deseja deletar o arquivo "${filename}"?`);
        }

        // Copiar link do magnet
        function copyMagnetLink(magnetLink) {
            navigator.clipboard.writeText(magnetLink).then(function() {
                // Mostrar feedback visual
                const toast = document.createElement('div');
                toast.className = 'toast align-items-center text-white bg-success border-0';
                toast.style.position = 'fixed';
                toast.style.top = '20px';
                toast.style.right = '20px';
                toast.style.zIndex = '9999';
                toast.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-check me-2"></i>Link magnet copiado!
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="this.parentElement.parentElement.remove()"></button>
                    </div>
                `;
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    toast.remove();
                }, 3000);
            });
        }
    </script>
</body>
</html>