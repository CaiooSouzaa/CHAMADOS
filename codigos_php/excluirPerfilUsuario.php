<?php

require_once __DIR__ . '/../codigos_php/conexao.php';
require_once __DIR__ . '/../autenticar/autenticacao.php';
require_once __DIR__ . '/../codigos_php/listarChamados.php';

verificarLogin();

$id_usuario = intval($_POST['id_usuario'] ?? 0);

if ($id_usuario <= 0) {
    $_SESSION['erro_usuario'] = 'Usuário inválido.';
    header('Location: ../paginas/listarUsuario.php');
    exit;
}

$select = "SELECT 
                c.id_chamados,
                c.titulo_chamado,
                c.descricao_chamado,
                c.categoria_chamado,
                c.status_chamado,
                c.inicio_chamado,
                c.id_usuario_solicitado,
                c.id_usuario_responsavel,
                u1.nome_usuario AS nome_solicitante,
                u2.nome_usuario AS nome_responsavel,
                CASE 
                    WHEN c.id_usuario_solicitado = '$id_usuario' AND c.id_usuario_responsavel = '$id_usuario' THEN 'Solicitante e Responsavel'
                    WHEN c.id_usuario_solicitado = '$id_usuario' THEN 'Solicitante'
                    WHEN c.id_usuario_responsavel = '$id_usuario' THEN 'Responsavel'
                END AS papel_no_chamado
            FROM chamados c
            LEFT JOIN usuario u1 ON c.id_usuario_solicitado = u1.id_usuario
            LEFT JOIN usuario u2 ON c.id_usuario_responsavel = u2.id_usuario
            WHERE c.id_usuario_solicitado = '$id_usuario' 
               OR c.id_usuario_responsavel = '$id_usuario'";

$resultadoConsulta = conexao($select);

if ($resultadoConsulta->num_rows > 0) {
    $qtd = $resultadoConsulta->num_rows;
    $plural = $qtd > 1 ? 'chamados vinculados' : 'chamado vinculado';

    $_SESSION['erro_usuario'] = "Não é possível desativar este usuário: ele possui {$qtd} {$plural} (como solicitante ou responsável). Reatribua ou finalize esses chamados antes de desativá-lo.";

    header('Location: ../paginas/listarUsuario.php');
    exit;
}

$inativar = "UPDATE usuario SET ativo = false WHERE id_usuario = $id_usuario";
$resultadoAtualizacao = conexao($inativar);

$_SESSION['sucesso_usuario'] = 'Usuário desativado com sucesso.';
header('Location: ../paginas/listarUsuario.php');
exit;