<?php

require_once __DIR__ .  '/../codigos_php/conexao.php';
require_once __DIR__ . '/../autenticar/autenticacao.php';


verificarLogin();

$resultado = [];

try {

    $id_logado = getUsuarioId();


    if (ehAdministrador()) {
        $sql = "SELECT 
                    c.*, 
                    u.nome_usuario AS nome_solicitante,
                    u2.nome_usuario AS nome_responsavel
                FROM chamados c
                LEFT JOIN usuario u ON c.id_usuario_solicitado = u.id_usuario
                LEFT JOIN usuario u2 ON c.id_usuario_responsavel = u2.id_usuario
                ORDER BY c.inicio_chamado DESC";
        $resultado = conexao($sql);

        $sql_contagem_chamados = "SELECT 
    COUNT(*) AS total_chamados,
    SUM(CASE WHEN status_chamado = 'aberto' THEN 1 ELSE 0 END) AS total_abertos,
    SUM(CASE WHEN status_chamado = 'fechado' THEN 1 ELSE 0 END) AS total_fechados
FROM chamados";

        $resultado_contagem = conexao($sql_contagem_chamados);

        $totais = $resultado_contagem->fetch_assoc();
        
        $total_chamados = $totais['total_chamados'];
        $total_abertos = $totais['total_abertos'];
        $total_fechados = $totais['total_fechados'];

    } else if (ehUsuario()) {
        $sql = "SELECT 
                    c.*, 
                    u.nome_usuario AS nome_solicitante,
                    u2.nome_usuario AS nome_responsavel
                FROM chamados c
                LEFT JOIN usuario u ON c.id_usuario_solicitado = u.id_usuario
                LEFT JOIN usuario u2 ON c.id_usuario_responsavel = u2.id_usuario
                WHERE c.id_usuario_solicitado = $id_logado
                ORDER BY c.inicio_chamado DESC";

        $resultado = conexao($sql);
    }
} catch (Exception $e) {
    echo "Erro ao buscar chamados: " . $e->getMessage();
}
