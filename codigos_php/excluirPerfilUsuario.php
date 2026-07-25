<?php

require_once __DIR__ .  '/../codigos_php/conexao.php';
require_once __DIR__ .'/../autenticar/autenticacao.php';

verificarLogin();


$id_usuario = $_POST['id_usuario'];

$deletar = "DELETE from usuario where id_usuario = '$id_usuario'";

$resultado = conexao($deletar);


header('Location: ../paginas/paginaInicial_administrador.php');