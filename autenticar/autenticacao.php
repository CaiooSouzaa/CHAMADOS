<?php
// verificar_auth.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function estaLogado() {
    return isset($_SESSION['id_usuario']);
}

function ehAdministrador() {
    return isset($_SESSION['papel_usuario']) && $_SESSION['papel_usuario'] === 'Administrador';
}

function ehUsuario() {
    return isset($_SESSION['papel_usuario']) && $_SESSION['papel_usuario'] === 'usuario';
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

function getUsuarioNome() {
    return $_SESSION['nome_usuario'] ?? 'Usuário';
}

function getUsuarioPapel() {
    return $_SESSION['papel_usuario'] ?? 'usuario';
}
?>
