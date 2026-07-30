<?php
session_start();
require_once __DIR__ . '/../autenticar/autenticacao.php';

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

                $papel = strtolower(trim((string)($_SESSION['papel_usuario'] ?? '')));
                $papel = str_replace(['á', 'à', 'â', 'ã', 'ä'], 'a', $papel);
                $papel = str_replace(['é', 'è', 'ê', 'ë'], 'e', $papel);
                $papel = str_replace(['í', 'ì', 'î', 'ï'], 'i', $papel);
                $papel = str_replace(['ó', 'ò', 'ô', 'õ', 'ö'], 'o', $papel);
                $papel = str_replace(['ú', 'ù', 'û', 'ü'], 'u', $papel);
                $papel = str_replace(['ç'], 'c', $papel);

                if ($papel === 'administrador' || $papel === 'admin' || $papel === 'adm') {
                    header("Location: ../paginas/paginaInicial_administrador.php");
                } else {
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
