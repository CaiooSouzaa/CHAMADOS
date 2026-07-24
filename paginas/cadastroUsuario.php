<?php
require_once __DIR__ . '/../codigos_php/validarCadastro.php';
require_once __DIR__ . '/../autenticar/autenticacao.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário - Gestão de Chamados</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/cadastroUsuario.css">
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
            </div>
            <span class="sidebar-title">Gestão de Chamados</span>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Chamados</div>
                <a href="paginaInicial_administrador.php" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Dashboard
                </a>
                <a href="chamados.php" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Novo Chamado
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Usuários</div>
                <a href="listarUsuario.php" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Listar Usuários
                </a>
                <a href="cadastroUsuario.php" class="nav-item active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Novo Usuário
                </a>
            </div>
        </nav>

        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar"><?php echo isset($_SESSION['nome_usuario']) ? substr($_SESSION['nome_usuario'], 0, 1) : 'U'; ?></div>
                <div class="user-info">
                    <?php echo getUsuarioNome()?>
                    <div class="user-name"></div>
                    <div class="user-role">
                        <span class="admin-badge">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            <?php echo isset($_SESSION['papel_usuario']) ? htmlspecialchars($_SESSION['papel_usuario']) : 'Usuário'; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <!-- TOPBAR -->
        <header class="topbar">
            <div class="breadcrumb">
                <a href="#">Home</a>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                <a href="#">Usuários</a>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                <span>Novo Usuário</span>
            </div>
            <div class="topbar-right">
                <button class="topbar-btn" title="Notificações">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    <span class="notification-dot"></span>
                </button>
                <a href="../codigos_php/sair.php" style="text-decoration:none;">
                    <button type="button" class="topbar-btn" title="Sair">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    </button>
                </a>
            </div>
        </header>

        <!-- CONTENT AREA -->
        <div class="content-area">
            <div class="form-container" id="container">
                <!-- HEADER -->
                <div class="form-header" id="header">
                    <div class="form-logo" id="logo">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <h1 id="title">Cadastro de Usuário</h1>
                    <p id="subtitle">Preencha os dados para criar uma nova conta no sistema</p>
                </div>

                <!-- FORM CARD -->
                <div class="form-card" id="form-card">
                    <form action="cadastroUsuario.php" method="post" onsubmit="return handleSubmit(event)">

                        <!-- Nome -->
                        <div class="form-group" id="fg-nome">
                            <label for="nome_usuario">Nome Completo</label>
                            <div class="input-wrapper">
                                <span class="input-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                        <circle cx="12" cy="7" r="4"/>
                                    </svg>
                                </span>
                                <input type="text" id="nome_usuario" name="nome_usuario" placeholder="Digite o nome completo" required autocomplete="name">
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-group" id="fg-email">
                            <label for="email_usuario">E-mail</label>
                            <div class="input-wrapper">
                                <span class="input-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                        <polyline points="22,6 12,13 2,6"/>
                                    </svg>
                                </span>
                                <input type="email" id="email_usuario" name="email_usuario" placeholder="seu.email@exemplo.com" required autocomplete="email">
                            </div>
                        </div>

                        <!-- Senha -->
                        <div class="form-group" id="fg-senha">
                            <label for="senha_usuario">Senha</label>
                            <div class="input-wrapper">
                                <span class="input-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                    </svg>
                                </span>
                                <input type="password" id="senha_usuario" name="senha_usuario" placeholder="Mínimo 6 caracteres" required minlength="6">
                                <button type="button" class="toggle-password" onclick="togglePassword()" aria-label="Mostrar senha">
                                    <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="strength-wrapper">
                                <div class="strength-bar-container">
                                    <div class="strength-bar" id="strength-bar"></div>
                                </div>
                                <p class="strength-text">
                                    <span id="strength-text">Digite uma senha</span>
                                </p>
                            </div>
                        </div>

                        <!-- Papel -->
                        <div class="form-group" id="fg-papel">
                            <label for="papel_usuario">Nível de Acesso</label>
                            <div class="input-wrapper">
                                <span class="input-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                    </svg>
                                </span>
                                <select id="papel_usuario" name="papel_usuario" required>
                                    <option value="" disabled selected>Selecione o nível de acesso</option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="usuario">Usuário</option>
                                    <option value="funcionario">Funcionario</option>
                                </select>
                                <span class="select-arrow">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="6 9 12 15 18 9"/>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <!-- Botão -->
                        <button type="submit" class="btn-submit" id="btn">
                            <span id="btnText">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <line x1="12" y1="5" x2="12" y2="19"/>
                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                </svg>
                                Cadastrar Usuário
                            </span>
                            <span class="btn-loader" id="btnLoader">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M21 12a9 9 0 1 1-6.22-8.56"/>
                                </svg>
                                Cadastrando...
                            </span>
                        </button>
                    </form>
                </div>

                <!-- FOOTER -->
                <div class="form-footer" id="footer">
                    <p>Todos os campos são obrigatórios · <a href="#">Ver lista de usuários</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/cadastroUsuario.js">
        
    </script>

</body>
</html>