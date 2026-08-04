<?php
session_start();
require_once __DIR__ . '/../codigos_php/conexao.php';
require_once __DIR__ . '/../autenticar/autenticacao.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../paginas/login.php');
    exit;
}

$acaoEncaminhar = $_POST['acao'] ?? '';
$id_usuario = intval($_SESSION['id_usuario']);
$id_chamado = intval($_POST['id_chamado'] ?? 0);
$id_novo_responsavel = intval($_POST['novo_responsavel'] ?? 0);

if ($id_chamado <= 0 || $id_novo_responsavel <= 0) {
    $_SESSION['erro'] = "Dados inválidos para transferência.";
    header('Location: ../paginas/paginaInicial_funcionario.php');
    exit;
}

if ($acaoEncaminhar === 'encaminhar') {
    if ($_SESSION['papel_usuario'] == 'funcionario') {
        $_SESSION['erro'] = "Funcionários não podem transferir chamados.";
        header('Location: ../paginas/paginaInicial_funcionario.php');
        exit;
    }

    try {
        $buscarUsuarioAtual = "SELECT id_usuario_responsavel FROM chamados WHERE id_chamados = $id_chamado";
        $resultadoBusca = conexao($buscarUsuarioAtual);

        if (!$resultadoBusca || $resultadoBusca->num_rows == 0) {
            throw new Exception("Chamado não encontrado.");
        }

        $usuario_responsavel_chamado = $resultadoBusca->fetch_assoc();
        $id_usuario_anterior = intval($usuario_responsavel_chamado['id_usuario_responsavel']);

        $data = new DateTime();
        $data_transferencia = $data->format('Y-m-d H:i:s');

        $sql_update = "UPDATE chamados 
                       SET id_usuario_responsavel = $id_novo_responsavel, 
                           status_chamado = 'Em Andamento' 
                       WHERE id_chamados = $id_chamado";

        $sql_insert = "INSERT INTO ticket_transferencias
                       (id_chamado, id_usuario_anterior, id_usuario_novo, id_usuario_executor, data_transferencia) 
                       VALUES 
                       ($id_chamado, $id_usuario_anterior, $id_novo_responsavel, $id_usuario, '$data_transferencia')";

        // VAR_DUMP PARA DEBUG
        echo "<h2>Dados da Transferência:</h2>";
        echo "<pre>";
        echo "=== DADOS RECEBIDOS ===\n";
        echo "Ação: " . $acaoEncaminhar . "\n";
        echo "ID Usuário Logado: " . $id_usuario . "\n";
        echo "ID Chamado: " . $id_chamado . "\n";
        echo "ID Novo Responsável: " . $id_novo_responsavel . "\n";
        echo "ID Usuário Anterior: " . $id_usuario_anterior . "\n";
        echo "Data Transferência: " . $data_transferencia . "\n";
        echo "Papel do Usuário: " . $_SESSION['papel_usuario'] . "\n\n";
        
        echo "=== QUERIES ===\n";
        echo "UPDATE: " . $sql_update . "\n\n";
        echo "INSERT: " . $sql_insert . "\n\n";
        
        $insert_result = conexao($sql_insert);
        echo "RESULTADO INSERT: ";
        var_dump($insert_result);
        echo "\n";
        
        $update_result = conexao($sql_update);
        echo "RESULTADO UPDATE: ";
        var_dump($update_result);
        echo "\n";
        
        if ($insert_result && $update_result) {
            echo "✅ SUCESSO: Ambas as queries foram executadas com sucesso!\n";
        } else {
            echo "❌ ERRO: Alguma query falhou!\n";
        }
        echo "</pre>";

        $_SESSION['sucesso'] = "Chamado transferido com sucesso para ID $id_novo_responsavel!";
        
        exit;
    } catch (Exception $e) {
        echo "<h2>❌ ERRO NA TRANSFERÊNCIA</h2>";
        echo "<pre>";
        echo "Mensagem: " . $e->getMessage() . "\n";
        echo "Arquivo: " . $e->getFile() . "\n";
        echo "Linha: " . $e->getLine() . "\n";
        echo "</pre>";
        
        $_SESSION['erro'] = "Erro na transferência: " . $e->getMessage();
        exit;
    }
} else {
    echo "<h2>❌ AÇÃO INVÁLIDA</h2>";
    echo "<pre>";
    echo "Ação recebida: " . $acaoEncaminhar . "\n";
    echo "Ações esperadas: 'encaminhar'\n";
    echo "</pre>";
    
    $_SESSION['erro'] = "Ação inválida.";
    exit;
}
?>