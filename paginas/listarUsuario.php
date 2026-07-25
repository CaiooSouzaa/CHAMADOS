<?php
session_start();

require_once __DIR__ . '/../codigos_php/listarUsuario.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Usuários - Gestão de Chamados</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/listarUsuario.css">
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
                <a href="../paginas/chamados.php" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Novo Chamado
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Usuários</div>
                <a href="listarUsuarios.php" class="nav-item active">
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
        <div class="topbar">
            <div class="breadcrumb">

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
        </div>



        <!-- CONTENT AREA -->
        <div class="content-area">
            <!-- PAGE HEADER -->
            <div class="page-header animate-in">
                <div class="page-header-left">
                    <h1>Usuários</h1>
                    <p>Gerencie todos os usuários cadastrados no sistema</p>
                </div>
                <a href="cadastroUsuario.php" class="btn btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Novo Usuário
                </a>
            </div>

            <!-- STATS -->
            <div class="stats-grid animate-in delay-1">
                <div class="stat-card">
                    <div class="stat-header">

                        <span class="stat-label">Total de Usuários</span>
                        <div class="stat-icon blue">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo $total_usuarios ? $total_usuarios : '0'; ?></div>
                    <div class="stat-trend">cadastrados no sistema</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Administradores</span>
                        <div class="stat-icon purple">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo $total_admins ? $total_admins : '0'; ?></div>
                    <div class="stat-trend">com acesso total</div>
                </div>
            </div>

            <!-- TABLE -->
            <div class="table-card animate-in delay-2">
                <div class="table-header">
                    <span class="table-title">Lista de Usuários</span>
                    <div class="table-search">
                        <span class="search-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8" />
                                <line x1="21" y1="21" x2="16.65" y2="16.65" />
                            </svg>
                        </span>
                        <input type="text" class="search-input" placeholder="Buscar por nome ou email..." id="searchInput">
                    </div>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Usuário</th>
                                <th>E-mail</th>
                                <th>Nível de Acesso</th>
                                <th>Status</th>
                                <th style="text-align: right;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultado_usuarios as $usuarios) { ?>
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <div class="user-avatar-sm"></div>
                                            <div class="user-cell-info">
                                                <span class="user-cell-name"><?php echo $usuarios['nome_usuario']; ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo $usuarios['email_usuario']; ?></td>

                                    <td><span class="badge badge-admin"><?php echo $usuarios['papel_usuario']; ?></span></td>
                                    <td>
                                        <span class="badge <?php echo $usuarios['ativo'] == true ? 'bg-success' : 'bg-danger'; ?>">
                                            <?php echo $usuarios['ativo'] == true ? "Ativo" : "Inativo"; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="table-actions" style="justify-content: flex-end;">
                                            <a href="../paginas/editarPerfil.php?id_usuario=<?php echo $usuarios['id_usuario']?>">
                                                <button class="action-btn edit" title="Editar">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                    </svg>
                                                </button>
                                            </a>
                                            
                                            <form action="../codigos_php/excluirPerfilUsuario.php" method="post">
                                                <input type="hidden" name="id_usuario" value="<?= $usuarios['id_usuario'] ?>">
                                            <button class="action-btn delete" title="Excluir">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <polyline points="3 6 5 6 21 6" />
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                </svg>
                                            </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION -->
                <div class="pagination">
                    <span class="pagination-info">Mostrando 1 a 10 de 50 resultados</span>
                    <div class="pagination-btns">
                        <button class="page-btn">Anterior</button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn">Próxima</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/listarUsuario.js"></script>

</body>

</html>