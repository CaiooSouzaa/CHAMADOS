<?php
session_start();
require_once __DIR__ . '/../codigos_php/listarChamados.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Gestão de Chamados</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/paginaInicial_administrador.css">
</head>

<body>
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
            <!-- SEÇÃO: CHAMADOS (Ambos) -->
            <div class="nav-section">
                <div class="nav-section-title">Chamados</div>
                <a href="../paginas/paginaInicial_administrador.php" class="nav-item active">
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

            <!-- SEÇÃO: USUÁRIOS (Admin only) -->
            <div class="nav-section">
                <div class="nav-section-title">Usuários</div>
                <a href="../paginas/listarUsuario.php" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    Listar Usuários
                </a>
                <a href="../paginas/cadastroUsuario.php" class="nav-item">
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
                <div class="user-avatar"><?php echo isset($_SESSION['nome_usuario']) ? substr($_SESSION['nome_usuario'], 0, 1) : 'U'; ?></div>
                <div class="user-info">
                    <div class="user-name"><?php echo getUsuarioNome() ?></div>
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
            <div class="topbar-left">
                <div class="breadcrumb">
                    <a href="paginaInicial_administrador.php">Home</a>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2">
                        <polyline points="9 18 15 12 9 6" />
                    </svg>
                    <span>Dashboard</span>
                </div>
            </div>
            <div class="topbar-right">
                <button class="topbar-btn" title="Notificações">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                        <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                    </svg>
                    <span class="notification-dot"></span>
                </button>
                <a href="../codigos_php/sair.php">
                    <button class="topbar-btn" title="Sair">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
                    </button>
                </a>
            </div>
        </header>

        <!-- CONTENT -->
        <div class="content-area">
            <!-- STATS -->
            <div class="stats-grid">
                <div class="stat-card animate-in delay-1">
                    <div class="stat-header">
                        <span class="stat-label">Total de Chamados</span>
                        <div class="stat-icon blue">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                                <line x1="16" y1="13" x2="8" y2="13" />
                                <line x1="16" y1="17" x2="8" y2="17" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo $total_chamados ? $total_chamados : '0' ?></div>
                    <div class="stat-trend up">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="18 15 12 9 6 15" />
                        </svg>
                        +12% este mês
                    </div>
                </div>

                <div class="stat-card animate-in delay-2">
                    <div class="stat-header">
                        <span class="stat-label">Em Aberto</span>
                        <div class="stat-icon yellow">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo $total_abertos ? $total_abertos : '0' ?></div>
                    <div class="stat-trend neutral">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <circle cx="12" cy="12" r="1" />
                            <circle cx="19" cy="12" r="1" />
                            <circle cx="5" cy="12" r="1" />
                        </svg>
                        Aguardando atendimento
                    </div>
                </div>

                <div class="stat-card animate-in delay-3">
                    <div class="stat-header">
                        <span class="stat-label">Resolvidos</span>
                        <div class="stat-icon green">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="2.5">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo $total_fechados ? $total_fechados : '0' ?></div>
                    <div class="stat-trend up">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="18 15 12 9 6 15" />
                        </svg>
                        +5% esta semana
                    </div>
                </div>

                <div class="stat-card animate-in delay-4">
                    <div class="stat-header">
                        <span class="stat-label">Urgentes</span>
                        <div class="stat-icon red">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="2">
                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                <line x1="12" y1="9" x2="12" y2="13" />
                                <line x1="12" y1="17" x2="12.01" y2="17" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value">16</div>
                    <div class="stat-trend down">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="6 9 12 15 18 9" />
                        </svg>
                        -3% em relação a ontem
                    </div>
                </div>
            </div>

            <!-- ACTIONS -->
            <div class="actions-bar animate-in delay-5">
                <button class="btn btn-secondary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" y1="15" x2="12" y2="3" />
                    </svg>
                    Exportar
                </button>
            </div>


            <!-- TABLE -->
            <div class="table-card animate-in delay-6">
                <div class="table-header">
                    <h2 class="table-title">Lista de Chamados</h2>
                    <div class="table-search">
                        <input type="text" class="search-input" placeholder="Buscar chamado...">
                    </div>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Solicitante</th>
                                <th>Responsavel</th>
                                <th>Status</th>
                                <th>Data</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($resultado as $chamados) { ?>
                                <tr>
                                    <!-- aparece-->


                                    <td><span class="ticket-id"><?php echo $chamados['id_chamados'] ?></span></td>
                                    <td><span class="ticket-title"><?php echo $chamados['titulo_chamado'] ?></span></td>
                                    <td><span class="ticket-user"><?php echo $chamados['nome_solicitante'] ?></span></td>
                                    <td><span class="ticket-user"><?php echo isset($chamados['nome_responsavel']) ? $chamados['nome_responsavel'] : 'Null'; ?></span></td>
                                    <td><span class="badge badge-aberto"><?php echo $chamados['status_chamado'] ?></span></td>
                                    <td style="color:#64748b"><?php echo date('d/m/Y H:i', strtotime($chamados['inicio_chamado'])) ?></td>

                                    <!-- Ações-->
                                    <td>
                                        <div class="table-actions">
                                            <button type="button"
                                                class="action-btn btn-ver-chamado"
                                                data-id="<?= htmlspecialchars($chamados['id_chamados']) ?>"
                                                data-solicitante="<?= htmlspecialchars($chamados['nome_solicitante'] ?? '') ?>"
                                                data-titulo="<?= htmlspecialchars($chamados['titulo_chamado'] ?? '') ?>"
                                                data-descricao="<?= htmlspecialchars($chamados['descricao_chamado'] ?? 'Sem descrição') ?>"
                                                title="Visualizar">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                                    <circle cx="12" cy="12" r="3" />
                                                </svg>
                                            </button>
                                            <a href="../paginas/atualizarChamado.php?id_chamado=<?php echo $chamados['id_chamados'] ?>">
                                                <button class="action-btn edit" title="Editar"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                    </svg>
                                                </button>
                                            </a>
                                            <form action="../codigos_php/deletarChamado.php" method="post" class="form-excluir">
                                                <input type="hidden" name="id_chamados" value="<?= $chamados['id_chamados'] ?>">

                                                <button type="button" class="action-btn delete" onclick="abrirModal(this.form)">
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
                <div class="pagination">
                    <span class="pagination-info">Mostrando 1-4 de 142 chamados</span>
                    <div class="pagination-btns">
                        <button class="page-btn">&lt;</button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn">...</button>
                        <button class="page-btn">36</button>
                        <button class="page-btn">&gt;</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL DE CONFIRMAÇÃO -->
        <div class="modal-overlay" id="modalOverlay">
            <div class="modal">
                <div class="modal-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                        <line x1="12" y1="9" x2="12" y2="13" />
                        <line x1="12" y1="17" x2="12.01" y2="17" />
                    </svg>
                </div>
                <h3 class="modal-title">Excluir chamado?</h3>
                <p class="modal-text">Tem certeza que deseja excluir este chamado? Esta ação não pode ser desfeita.</p>
                <div class="modal-actions">
                    <button type="button" class="modal-btn modal-btn-cancel" onclick="fecharModal()">Cancelar</button>
                    <button type="button" class="modal-btn modal-btn-confirm" onclick="confirmarExclusao()">Excluir</button>
                </div>
            </div>
        </div>

       <!-- Modal de Gestão de Chamado -->
<div class="modal-overlay" id="modalChamadoOverlay">
    <div class="modal modal-lg">
        
        <!-- Cabeçalho Fixo no Topo -->
        <div class="modal-header">
            <span class="badge badge-pending" id="statusBadge">Em Aberto</span>
            <button type="button" class="btn-close" onclick="fecharModalChamado()">&times;</button>
        </div>

        <!-- TELA 1: Detalhes do Chamado (Conteúdo com Scroll) -->
        <div class="modal-step active" id="stepDetalhes">
            <h3 class="modal-title">Detalhes do Chamado <span class="chamado-id" id="chamadoId">#1042</span></h3>

            <div class="chamado-info-grid">
                <div class="info-group">
                    <label>Solicitante</label>
                    <p id="chamadoSolicitante">Ana Silva</p>
                </div>

                <div class="info-group">
                    <label>Título</label>
                    <p id="chamadoTitulo">Erro ao exportar relatório</p>
                </div>

                <div class="info-group full-width">
                    <label>Descrição</label>
                    <div class="description-box" id="chamadoDescricao">
                        <!-- O texto longo entra aqui -->
                    </div>
                </div>
            </div>

            <!-- Botões no final do scroll -->
            <div class="modal-actions" id="acoesIniciais">
                <button type="button" class="modal-btn modal-btn-secondary" onclick="irParaEncaminhar()">Encaminhar para Responsável</button>
                <button type="button" class="modal-btn modal-btn-primary" onclick="aceitarChamado()">Aceitar Chamado</button>
            </div>

            <div class="modal-actions hidden" id="acoesEmAndamento">
                <button type="button" class="modal-btn modal-btn-secondary" onclick="irParaEncaminhar()">Reencaminhar Funcionário</button>
                <button type="button" class="modal-btn modal-btn-success" onclick="finalizarChamado()">Finalizar Chamado</button>
            </div>
        </div>

        <!-- TELA 2: Encaminhar para Responsável -->
        <div class="modal-step" id="stepEncaminhar">
            <!-- Conteúdo da tela 2 -->
        </div>

    </div>
</div>

    </div>

    <script src="../js/paginaInicial_administrador.js"></script>

</body>

</html>