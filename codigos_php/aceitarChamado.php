<?php
session_start(); // OBRIGATÓRIO para ler $_SESSION['id_usuario']

require_once __DIR__ . '/../codigos_php/conexao.php';
require_once __DIR__ . '/../autenticar/autenticacao.php';

function isAjaxRequest() {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

$ajax = isAjaxRequest();
if ($ajax) {
    header('Content-Type: application/json; charset=utf-8');
}

if (ehAdministrador() || ehUsuario()) {

    $recebe_id_chamado = isset($_POST['id_chamados']) ? intval($_POST['id_chamados']) : 0;
    $recebe_id_usuario_logado = isset($_SESSION['id_usuario']) ? intval($_SESSION['id_usuario']) : 0;

    if ($recebe_id_chamado > 0 && $recebe_id_usuario_logado > 0) {
        
        // 1. Atualiza o chamado
        $sql = "UPDATE chamados 
                SET id_usuario_responsavel = $recebe_id_usuario_logado, 
                    status_chamado = 'Em Andamento'
                WHERE id_chamados = $recebe_id_chamado 
                AND id_usuario_responsavel IS NULL";

        conexao($sql);

        // 2. Confirma a alteração
        $sqlConfirma = "SELECT id_usuario_responsavel 
                        FROM chamados 
                        WHERE id_chamados = $recebe_id_chamado";

        $resultadoConfirma = conexao($sqlConfirma);
        
        // Trata a resposta independente de ser Objeto MySQLi ou Array associativo
        $id_responsavel = null;
        if (is_object($resultadoConfirma) && method_exists($resultadoConfirma, 'fetch_assoc')) {
            $linha = $resultadoConfirma->fetch_assoc();
            $id_responsavel = $linha['id_usuario_responsavel'] ?? null;
        } elseif (is_array($resultadoConfirma)) {
            $id_responsavel = $resultadoConfirma[0]['id_usuario_responsavel'] ?? ($resultadoConfirma['id_usuario_responsavel'] ?? null);
        }

        if ($id_responsavel == $recebe_id_usuario_logado) {
            $response = [
                'sucesso' => true,
                'mensagem' => 'Chamado aceito com sucesso!',
                'id_usuario_responsavel' => $recebe_id_usuario_logado,
                'nome_responsavel' => $_SESSION['nome_usuario'] ?? 'Você',
                'id_chamado' => $recebe_id_chamado
            ];
            if ($ajax) {
                echo json_encode($response);
            } else {
                header('Location: ../paginas/ticket_conversa.php?id_chamado=' . $recebe_id_chamado);
            }
            exit;
        } else {
            $response = [
                'sucesso' => false,
                'mensagem' => 'Este chamado já possui outro responsável ou não pôde ser atribuído.'
            ];
            if ($ajax) {
                echo json_encode($response);
            } else {
                header('Location: ../paginas/visualizarChamado.php?id_chamado=' . $recebe_id_chamado);
            }
            exit;
        }

    } else {
        $response = [
            'sucesso' => false,
            'mensagem' => 'Dados inválidos ou sessão expirada.'
        ];
        if ($ajax) {
            echo json_encode($response);
        } else {
            header('Location: ../paginas/visualizarChamado.php?id_chamado=' . $recebe_id_chamado);
        }
        exit;
    }

} else {
    $response = [
        'sucesso' => false,
        'mensagem' => 'Você não tem permissão para aceitar chamados.'
    ];
    if ($ajax) {
        echo json_encode($response);
    } else {
        header('Location: ../paginas/visualizarChamado.php?id_chamado=' . $recebe_id_chamado);
    }
    exit;
}