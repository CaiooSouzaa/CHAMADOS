<?php
session_start();
require_once __DIR__ . '/../codigos_php/listarChamados.php';

$id = isset($_GET['id_chamado']) ? intval($_GET['id_chamado']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'encaminhar') {
    $id_chamado_post = intval($_POST['id_chamado'] ?? 0);
    $id_colaborador = intval($_POST['id_colaborador'] ?? 0);

    if ($id_chamado_post > 0 && $id_colaborador > 0) {
        $sql_encaminhar = "UPDATE chamados 
            SET id_usuario_responsavel = $id_colaborador, status_chamado = 'Em andamento' 
            WHERE id_chamados = $id_chamado_post";
        conexao($sql_encaminhar);
    }

    header("Location: visualizarChamado.php?id_chamado=" . $id_chamado_post);
    exit;
}

$sql_chamado = "SELECT 
    c.*, 
    u.nome_usuario AS nome_solicitante,
    u2.nome_usuario AS nome_responsavel
FROM chamados c
LEFT JOIN usuario u ON c.id_usuario_solicitado = u.id_usuario
LEFT JOIN usuario u2 ON c.id_usuario_responsavel = u2.id_usuario
WHERE c.id_chamados = $id
LIMIT 1";

$resultado_chamado = conexao($sql_chamado);
$chamados = !empty($resultado_chamado) ? $resultado_chamado : null;

$sql_colabs = "SELECT id_usuario, nome_usuario FROM usuario 
               WHERE papel_usuario IN ('tecnico', 'admin', 'usuario', 'Administrador') 
               AND ativo = 1 
               ORDER BY nome_usuario";

$colaboradores = conexao($sql_colabs);

function classeStatus($status) {
    $normalizado = strtolower(trim($status));
    $mapa = [
        'aberto'        => 'status-aberto',
        'em andamento'  => 'status-andamento',
        'andamento'     => 'status-andamento',
        'fechado'       => 'status-fechado',
        'concluido'     => 'status-fechado',
        'concluído'     => 'status-fechado',
    ];
    return $mapa[$normalizado] ?? 'status-aberto';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Chamado - Gestao de Chamados</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/visualizarChamado.css">
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
        <span class="sidebar-title">Gestao de Chamados</span>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-section-title">Chamados</div>
            <?php if(ehUsuario()): ?>
            <a href="../paginas/paginaInicial_usuario.php" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
                Dashboard
            </a>
            <?php else: ?>
                <a href="../paginas/paginaInicial_administrador.php" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
                Dashboard
            </a>
            <?php endif; ?>
            <a href="../paginas/chamados.php" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                Novo Chamado
            </a>
        </div>
        <div class="nav-section">
            <div class="nav-section-title">Usuarios</div>
            <a href="#" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                Listar Usuarios
            </a>
            <a href="cadastroUsuario.php" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                Novo Usuario
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
                    <?php echo isset($_SESSION['nome_usuario']) ? htmlspecialchars($_SESSION['nome_usuario']) : 'Usuario'; ?>
                </div>
                <div class="user-role">
                    <span class="admin-badge">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        <?php echo isset($_SESSION['papel_usuario']) ? htmlspecialchars($_SESSION['papel_usuario']) : 'Usuario'; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</aside>

<div class="main-content">
    <header class="topbar">
        <div class="breadcrumb">
            <a href="paginaInicial_administrador.php">Home</a>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="9 18 15 12 9 6" />
            </svg>
            <a href="#">Chamados</a>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="9 18 15 12 9 6" />
            </svg>
            <span>Visualizar Chamado</span>
        </div>
        <div class="topbar-right">
            <button class="topbar-btn" title="Notificacoes">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                    <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                </svg>
                <span class="notification-dot"></span>
            </button>
            <a href="sair.php" style="text-decoration:none;">
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

    <div class="content-area">
        <div class="view-container" id="container">
            <div class="view-header">
                <div class="view-logo">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                    </svg>
                </div>
                <h1>Visualizar Chamado</h1>
                <p>Detalhes do chamado selecionado</p>
            </div>

            <?php if (!empty($resultado_chamado)): ?>
                <?php foreach ($resultado_chamado as $chamados): ?>
            <div class="ticket-card">
                <div class="ticket-header">
                    <div class="ticket-id-badge">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="16" y1="13" x2="8" y2="13" />
                            <line x1="16" y1="17" x2="8" y2="17" />
                        </svg>
                        Chamado #<?php echo htmlspecialchars($chamados['id_chamados']); ?>
                    </div>
                    <h2 class="ticket-title"><?php echo htmlspecialchars($chamados['titulo_chamado']); ?></h2>
                    <span class="status-badge <?php echo classeStatus($chamados['status_chamado']); ?>">
                        <?php echo htmlspecialchars($chamados['status_chamado']); ?>
                    </span>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z" />
                            </svg>
                            Categoria
                        </div>
                        <div class="info-value"><?php echo htmlspecialchars($chamados['categoria_chamado']); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            </svg>
                            Status
                        </div>
                        <div class="info-value"><?php echo htmlspecialchars($chamados['status_chamado']); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            Solicitante
                        </div>
                        <div class="info-value"><?php echo htmlspecialchars($chamados['nome_solicitante']); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                            Responsavel
                        </div>
                        <div class="info-value <?php echo $chamados['nome_responsavel'] ? '' : 'null'; ?>">
                            <?php echo $chamados['nome_responsavel'] ? htmlspecialchars($chamados['nome_responsavel']) : 'Nao atribuido'; ?>
                        </div>
                    </div>
                    <div class="info-item full-width">
                        <div class="info-label">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                            Data de Abertura
                        </div>
                        <div class="info-value"><?php echo date('d/m/Y H:i', strtotime($chamados['inicio_chamado'])); ?></div>
                    </div>
                </div>

                <div class="desc-section">
                    <div class="desc-header">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="21" y1="10" x2="3" y2="10" />
                            <line x1="21" y1="6" x2="3" y2="6" />
                            <line x1="21" y1="14" x2="3" y2="14" />
                            <line x1="21" y1="18" x2="3" y2="18" />
                        </svg>
                        <h3>Descricao do Chamado</h3>
                    </div>
                    <div class="desc-body">
                        <?php echo nl2br(htmlspecialchars($chamados['descricao_chamado'])); ?>
                    </div>
                </div>

                <div class="action-bar">
                    <button type="button" class="btn btn-primary">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                        </svg>
                        Aceitar chamado
                    </button>

                    <form class="encaminhar-form" method="POST" action="visualizarChamado.php">
                        <input type="hidden" name="acao" value="encaminhar">
                        <input type="hidden" name="id_chamado" value="<?php echo (int) $id; ?>">

                        <select class="action-select" name="id_colaborador" id="encaminhar">
                            <option value="" disabled selected>Encaminhar para um colaborador</option>
                            <?php if (!empty($colaboradores)): ?>
                                <?php foreach ($colaboradores as $colab): ?>
                                    <option value="<?php echo htmlspecialchars($colab['id_usuario']); ?>">
                                        <?php echo htmlspecialchars($colab['nome_usuario']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>Nenhum colaborador disponivel</option>
                            <?php endif; ?>
                        </select>

                        <button type="submit" class="btn btn-primary" id="btn-encaminhar" disabled>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <line x1="22" y1="2" x2="11" y2="13" />
                                <polygon points="22 2 15 22 11 13 2 9 22 2" />
                            </svg>
                            Encaminhar
                        </button>
                    </form>

                    <a href="listarChamados.php" class="btn btn-secondary">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="15 18 9 12 15 6" />
                        </svg>
                        Voltar
                    </a>
                </div>
            </div>
                <?php endforeach; ?>
            <?php else: ?>
            <div class="ticket-card">
                <p style="text-align:center;color:var(--text-secondary);font-size:0.9rem;">Chamado nao encontrado.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="../js/visualizarChamado.js"></script>
</body>
</html>