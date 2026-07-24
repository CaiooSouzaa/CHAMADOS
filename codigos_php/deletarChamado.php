<?php

require_once __DIR__ .  '/../codigos_php/conexao.php';
require_once __DIR__ .'/../autenticar/autenticacao.php';

verificarLogin();

$id_chamado = $_POST['id_chamados'];

$sql = "DELETE from chamados where id_chamados = '$id_chamado'";

$resultado  = conexao($sql);

if(ehAdministrador()){

    header('Location: ../paginas/paginaInicial_administrador.php');
}else if(ehUsuario()){
    header('Location: paginaInicial_usuario.php');
}