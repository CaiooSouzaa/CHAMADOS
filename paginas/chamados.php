<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Chamado - Gestão de Chamados</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/chamados.css">
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                    <polyline points="10 17 15 12 10 7" />
                    <line x1="15" y1="12" x2="3" y2="12" />
                </svg>
            </div>
            <span class="sidebar-title">Gestão de Chamados</span>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Chamados</div>
                <a href="paginaInicial_administrador.php" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    Dashboard
                </a>
                <a href="chamdos.php" class="nav-item active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Novo Chamado
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Usuários</div>
                <a href="listarUsuario.php" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    Listar Usuários
                </a>
                <a href="cadastroUsuario.php" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Novo Usuário
                </a>
            </div>
        </nav>

        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar">
                    <?php echo isset($_SESSION['nome_usuario']) ? substr($_SESSION['nome_usuario'], 0, 1) : 'U'; ?>
                </div>
                <div class="user-info">
                    <div class="user-name">
                        <?php echo isset($_SESSION['nome_usuario']) ? htmlspecialchars($_SESSION['nome_usuario']) : 'Usuário'; ?>
                    </div>
                    <div class="user-role">
                        <span class="admin-badge">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
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
                <a href="painel_admin.php">Home</a>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6" />
                </svg>
                <a href="#">Chamados</a>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6" />
                </svg>
                <span>Novo Chamado</span>
            </div>
            <div class="topbar-right">
                <button class="topbar-btn" title="Notificações">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                        <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                    </svg>
                    <span class="notification-dot"></span>
                </button>
                <a href="../codigos_php/sair.php" style="text-decoration:none;">
                    <button type="button" class="topbar-btn" title="Sair">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
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
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                    </div>
                    <h1 id="title">Abrir Novo Chamado</h1>
                    <p id="subtitle">Descreva o problema para que a equipe possa atender</p>
                </div>

                <!-- FORM CARD -->
                <div class="form-card" id="form-card">
                    <form action="../codigos_php/criarChamado.php" method="post" onsubmit="return handleSubmit(event)">

                        <!-- Título -->
                        <div class="form-group" id="fg-titulo">
                            <label for="titulo_chamado">Título do Chamado</label>
                            <div class="input-wrapper">
                                <span class="input-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                        <polyline points="14 2 14 8 20 8" />
                                        <line x1="16" y1="13" x2="8" y2="13" />
                                        <line x1="16" y1="17" x2="8" y2="17" />
                                    </svg>
                                </span>
                                <input type="text" id="titulo_chamado" name="titulo_chamado" placeholder="Ex: Erro ao acessar o sistema de vendas" required maxlength="120">
                            </div>
                        </div>

                        
                        <div class="form-group" id="fg-prioridade">
                            <!-- Prioridade 
                            <label for="prioridade_chamado">Prioridade</label>
                            <div class="input-wrapper">
                                <span class="input-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                    </svg>
                                </span>
                                <select id="prioridade_chamado" name="prioridade_chamado" required>
                                    <option value="" disabled selected>Selecione a prioridade</option>
                                    <option value="Baixa">Baixa</option>
                                    <option value="Media">Média</option>
                                    <option value="Alta">Alta</option>
                                    <option value="Critica">Crítica</option>
                                </select>
                                <span class="select-arrow">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="6 9 12 15 18 9" />
                                    </svg>
                                </span>
                            </div>
                            <br>-->
                            <label for="categoria_chamado">Categoria</label>
                            <div class="input-wrapper">
                                <span class="input-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                    </svg>
                                </span>
                                <select id="prioridade_chamado" name="categoria_chamado" required>
                                    <option value="" disabled selected>Selecione a prioridade</option>
                                    <option value="Financeiro">Financeiro</option>
                                    <option value="Moodle">Moodle</option>
                                    <option value="Aplicativo ITE">Aplicativo ITE</option>
                                    <option value="Infraestrutura e TI">Infraestrutura e TI</option>
                                    <option value="Acadêmico (Secretaria)">Acadêmico (Secretaria)</option>
                                </select>
                                <span class="select-arrow">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="6 9 12 15 18 9" />
                                    </svg>
                                </span>
                            </div>
                        </div>



                        <!-- Descrição -->
                        <div class="form-group" id="fg-descricao">
                            <label for="descricao_chamado">Descrição</label>
                            <div class="input-wrapper">
                                <span class="input-icon" style="top: 22px; transform: none;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="21" y1="10" x2="3" y2="10" />
                                        <line x1="21" y1="6" x2="3" y2="6" />
                                        <line x1="21" y1="14" x2="3" y2="14" />
                                        <line x1="21" y1="18" x2="3" y2="18" />
                                    </svg>
                                </span>
                                <textarea id="descricao_chamado" name="descricao_chamado" placeholder="Descreva detalhadamente o problema, passos para reproduzir, e qualquer informação relevante..." required maxlength="2000"></textarea>
                            </div>
                            <div class="char-counter" id="charCounter">0 / 2000 caracteres</div>
                        </div>

                        <!-- Botão -->
                        <button type="submit" class="btn-submit" id="btn">
                            <span id="btnText">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <line x1="22" y1="2" x2="11" y2="13" />
                                    <polygon points="22 2 15 22 11 13 2 9" />
                                </svg>
                                Enviar Chamado
                            </span>
                            <span class="btn-loader" id="btnLoader">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M21 12a9 9 0 1 1-6.22-8.56" />
                                </svg>
                                Enviando...
                            </span>
                        </button>
                    </form>
                </div>

                <!-- FOOTER -->
                <div class="form-footer" id="footer">
                    <p>Todos os campos são obrigatórios</p>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/chamados.js">

    </script>

</body>

</html>