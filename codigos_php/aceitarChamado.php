<?php

require_once __DIR__ . '/../codigos_php/conexao.php';
require_once __DIR__ . '/../autenticar/autenticacao.php';

header('Content-Type: application/json');

if (ehAdministrador() || ehUsuario()) {

    $recebe_id_chamado = $_POST['id_chamados'];
    $recebe_id_usuario_logado = $_SESSION['id_usuario'];

    if (!empty($recebe_id_chamado) && !empty($recebe_id_usuario_logado)) {
        $sql = "UPDATE chamados 
                SET id_usuario_responsavel = $recebe_id_usuario_logado, 
                    status_chamado = 'Em Andamento'
                WHERE id_chamados = $recebe_id_chamado 
                AND id_usuario_responsavel IS NULL";

        conexao($sql);

        $sqlConfirma = "SELECT id_usuario_responsavel 
                        FROM chamados 
                        WHERE id_chamados = $recebe_id_chamado";

        $resultadoConfirma = conexao($sqlConfirma);
        $linha = $resultadoConfirma->fetch_assoc();

        if ($linha && $linha['id_usuario_responsavel'] == $recebe_id_usuario_logado) {
            echo json_encode([
                'sucesso' => true,
                'mensagem' => 'Chamado aceito com sucesso!',
                'id_usuario_responsavel' => $recebe_id_usuario_logado,
                'nome_responsavel' => $_SESSION['nome_usuario'] ?? 'Você'
            ]);
        } else {
            echo json_encode([
                'sucesso' => false,
                'mensagem' => 'Este chamado já foi aceito por outro atendente.'
            ]);
        }

    } else {
        echo json_encode([
            'sucesso' => false,
            'mensagem' => 'Dados inválidos.'
        ]);
    }

} else {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Você não tem permissão para aceitar chamados.'
    ]);
}