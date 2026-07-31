<?php

require_once __DIR__ .  '/../codigos_php/conexao.php';
require_once __DIR__ . '/../autenticar/autenticacao.php';

$titulo_chamado = null;
$descricao_chamado = null;
$id_chamado = null;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET['id_chamado'])) {
        require_once __DIR__ .  '/../codigos_php/conexao.php';

        $id_chamado = $_GET['id_chamado'];

        $select = "SELECT * FROM chamados WHERE id_chamados = '$id_chamado'";
        $resultado_select = conexao($select);

        if ($resultado_select->num_rows > 0) {
            $user_data = mysqli_fetch_assoc($resultado_select);
            $titulo_chamado = $user_data['titulo_chamado'];
            $descricao_chamado = $user_data['descricao_chamado'];
        } else {
            header('Location: ../paginas/paginaIncial_administrador.php');
            exit;
        }
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

$titulo_chamado = $_POST['titulo_chamado'];
$descricao_chamado = $_POST['descricao_chamado'];
$id_chamado = $_POST['id_chamado'];

$sql = "UPDATE chamados SET titulo_chamado = '$titulo_chamado', descricao_chamado = '$descricao_chamado' where id_chamados = '$id_chamado'";

$resultado = conexao($sql);

if (ehAdministrador()) {
        header("Location: ../paginas/paginaInicial_administrador.php");
        exit;
    } else if (ehUsuario()) {
        header("Location: ../paginas/paginaInicial_usuario.php");
        exit;
    }
}
