<?php

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Pegando os dados do formulário

    $nome_usuario = $_POST['nome_usuario'];
    $email_usuario = $_POST['email_usuario'];
    $senha_usuario = $_POST['senha_usuario'];
    $papel_usuario = $_POST['papel_usuario'];
    $ativo = isset($_POST['ativo']) ? (int)$_POST['ativo'] : 1;

    // Validação básica
    if (empty($nome_usuario) || empty($email_usuario) || empty($senha_usuario) || empty($papel_usuario)) {
        die("Todos os campos são obrigatórios!");
    }

    // Criptografando a senha (recomendado)
    $senha_criptografada = password_hash($senha_usuario, PASSWORD_DEFAULT);

    require_once __DIR__ . '/../codigos_php/conexao.php';

    // Usando prepared statement para evitar SQL Injection
    $insert = "INSERT INTO usuario (nome_usuario, email_usuario, senha_usuario, papel_usuario, ativo) 
    VALUES ('$nome_usuario', '$email_usuario', '$senha_criptografada', '$papel_usuario', $ativo)";

    $resultado = conexao($insert);

    header('Locartion: ../paginas/paginaInicial_administrador.php');
}
?>