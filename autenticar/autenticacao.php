<?php
// verificar_auth.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function estaLogado() {
    return isset($_SESSION['id_usuario']);
}

function ehAdministrador() {
    return isset($_SESSION['papel_usuario']) && ($_SESSION['papel_usuario'] === 'Administrador' || $_SESSION['papel_usuario'] === 'admin');
}

function ehUsuario() {
    return isset($_SESSION['papel_usuario']) && $_SESSION['papel_usuario'] === 'usuario';
}

function ehFuncionario() {
    return isset($_SESSION['papel_usuario']) && $_SESSION['papel_usuario'] === 'funcionario';
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
