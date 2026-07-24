<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];


    if (empty($email) || empty($pass)) {
        header('Location: ../paginas/index.php?login=erro');
    }

    try {
        require_once 'conexao.php';

        $sql = "SELECT * FROM usuario where email_usuario = '$email'";

        $resultado = conexao($sql);

        $usuario = $resultado->fetch_assoc();

        if ($usuario) {
            if (password_verify($pass, $usuario['senha_usuario'])) {
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nome_usuario'] = $usuario['nome_usuario'];
                $_SESSION['papel_usuario'] = $usuario['papel_usuario'];

                if ($_SESSION['papel_usuario'] == 'Administrador') {
                    header("Location: ../paginas/paginaInicial_administrador.php");
                }

                if ($_SESSION['papel_usuario'] == 'usuario') {
                    header("Location: ../paginas/paginaInicial_usuario.php");
                }

                if ($_SESSION['papel_usuario'] == 'funcionario') {
                    header("Location: ../paginas/paginaInicial_usuario.php");
                }
                exit;
            } else {
                header('Location: ../paginas/index.php?login=erro');
            }
        } else {
            header('Location: ../paginas/index.php?login=erro');
            exit;
        }
    } catch (Exception $e) {
        echo '' . $e->getMessage() . '';
    }
}
