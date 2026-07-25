<?php

require_once __DIR__ .  '/../codigos_php/conexao.php';
require_once __DIR__ . '/../autenticar/autenticacao.php';


verificarLogin();

$sql_usuarios = "SELECT id_usuario, nome_usuario, email_usuario, papel_usuario, ativo FROM usuario";
$resultado_usuarios = conexao($sql_usuarios);

// Query 2: totais
$sql_contagem = "SELECT 
                    COUNT(*) AS total_usuarios,
                    SUM(CASE WHEN papel_usuario = 'Administrador' THEN 1 ELSE 0 END) AS total_admins,
                    SUM(CASE WHEN ativo = 1 THEN 1 ELSE 0 END) AS total_ativos
                  FROM usuario";
$resultado_contagem = conexao($sql_contagem);
$totais = $resultado_contagem->fetch_assoc();

$total_usuarios = $totais['total_usuarios'];
$total_admins   = $totais['total_admins'];
$total_ativos   = $totais['total_ativos'];
