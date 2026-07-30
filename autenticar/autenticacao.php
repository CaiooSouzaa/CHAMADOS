<?php
// verificar_auth.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function normalizarPapel($papel) {
    $papel = trim((string)($papel ?? ''));
    $papel = str_replace(['á', 'à', 'â', 'ã', 'ä'], 'a', $papel);
    $papel = str_replace(['é', 'è', 'ê', 'ë'], 'e', $papel);
    $papel = str_replace(['í', 'ì', 'î', 'ï'], 'i', $papel);
    $papel = str_replace(['ó', 'ò', 'ô', 'õ', 'ö'], 'o', $papel);
    $papel = str_replace(['ú', 'ù', 'û', 'ü'], 'u', $papel);
    $papel = str_replace(['ç'], 'c', $papel);
    return strtolower($papel);
}

function estaLogado() {
    return isset($_SESSION['id_usuario']);
}

function ehAdministrador() {
    $papel = normalizarPapel($_SESSION['papel_usuario'] ?? '');
    return in_array($papel, ['administrador', 'admin', 'adm'], true);
}

function ehUsuario() {
    $papel = normalizarPapel($_SESSION['papel_usuario'] ?? '');
    return in_array($papel, ['usuario', 'user', 'cliente', 'usuario'], true);
}

function ehFuncionario() {
    $papel = normalizarPapel($_SESSION['papel_usuario'] ?? '');
    return in_array($papel, ['funcionario', 'funcionaria', 'funcionário', 'employee', 'tecnico', 'tecnico', 'tecnico', 'tecnico'], true);
}

function verificarLogin() {
    if (!estaLogado()) {
        header('Location: index.php');
        exit;
    }
}

function getUsuarioId() {
    return $_SESSION['id_usuario'] ?? 0;
}

function getIdChamado(){
    return $_SESSION['id_chamados'] ?? 0;
}

function getUsuarioNome() {
    return $_SESSION['nome_usuario'] ?? 'Usuário';
}

function getUsuarioPapel() {
    return $_SESSION['papel_usuario'] ?? 'usuario';
}
?>
