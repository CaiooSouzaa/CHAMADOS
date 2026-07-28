<?php

require_once __DIR__ .  '/../codigos_php/conexao.php';
require_once __DIR__ . '/../autenticar/autenticacao.php';

verificarLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo_chamado = $_POST['titulo_chamado'];
    $categoria_chamado = $_POST['categoria_chamado'];
    $descricao_chamado = $_POST['descricao_chamado'];
    $usuario = getUsuarioId();

    if (!empty($titulo_chamado) && !empty($descricao_chamado) && !empty($usuario)) {
        $sql = "INSERT INTO chamados (
    titulo_chamado,
    categoria_chamado,
    descricao_chamado,
    status_chamado,
    id_usuario_solicitado,
    id_usuario_responsavel,
    inicio_chamado,
    fim_chamado
) VALUES (
    '$titulo_chamado',
    '$categoria_chamado',
    '$descricao_chamado',
    'Aberto',
    '$usuario',
    NULL,
    NOW(),
    NULL
)";

        $resultado = conexao($sql);

        if (ehAdministrador()) {
            header("Location: ../paginas/paginaInicial_administrador.php");
            exit;
        } else if (ehUsuario()) {
            header("Location: ../paginas/paginaInicial_usuario.php");
            exit;
        }
    } else {
        header('Location: chamados.php?envio=erro');
        exit;
    }
}
