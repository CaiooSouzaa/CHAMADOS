<?php

require_once __DIR__ . '/../codigos_php/conexao.php';
require_once __DIR__ . '/../autenticar/autenticacao.php';


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET['id_usuario'])) {
        require_once __DIR__ . '/../codigos_php/conexao.php';

        $id_usuario = $_GET['id_usuario'];


        $sql_select = "SELECT * from usuario where id_usuario = '$id_usuario'";

        $resultado = conexao($sql_select);

        if ($resultado->num_rows > 0) {
            $user_data = mysqli_fetch_assoc($resultado);
            $nome_usuario = $user_data['nome_usuario'];
            $email_usuario = $user_data['email_usuario'];
            $senha_usuario = $user_data['senha_usuario'];
            $papel_usuario = $user_data['papel_usuario'];
            $ativo_usuario = $user_data['ativo'];
        } else {
            header('Location: ../paginas/paginaIncial_administrador.php');
            exit;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_usuario = $_POST['nome_usuario'];
    $email_usuario = $_POST['email_usuario'];
    $senha_usuario = $_POST['senha_usuario'];
    $papel_usuario = $_POST['papel_usuario'];
    $ativo_usuario = $_POST['ativo'];

    //if(!empty())

    $update_usuario = "UPDATE usuario  SET nome_usuario = '$nome_usuario', email_usuario = '$email_usuario', senha_usuario = '$senha_usuario', papel_usuario = '$papel_usuario', ativo = '$ativo_usuario'";

    $resultado_update = conexao($update_usuario);

    echo '<pre>';
    print_r($_POST);
}
