<?php
session_start();

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gestão de Chamados</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>

    <main class="login-card" id="card">
        <div class="login-header" id="header">
            <div class="logo" id="logo">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
            </div>
            <h1 id="title">Acessar o Sistema</h1>
            <p id="subtitle">Entre com suas credenciais para continuar</p>
        </div>

        <!-- Alerta de Erro -->
        <?php if (isset($_GET['login'])): ?>
            <div class="alert-error <?php echo ($_GET['login'] === 'vazio' || $_GET['login'] === 'erro') ? 'show' : ''; ?>" id="alert">
                <span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <?php
                        if ($_GET['login'] === 'vazio') {
                            echo 'Por favor, preencha todos os campos.';
                        } elseif ($_GET['login'] === 'erro') {
                            echo 'E-mail ou senha incorretos.';
                        }
                    ?>
                </span>
            </div>
        <?php endif; ?>

        <form action="../codigos_php/login.php" method="POST" onsubmit="return handleSubmit(event)">
            <div class="form-group" id="fg-email">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="seu.email@exemplo.com" required autocomplete="email">
            </div>

            <div class="form-group" id="fg-pass">
                <div class="label-row">
                    <label for="password">Senha</label>
                    <a href="#" class="forgot-link">Esqueceu?</a>
                </div>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                    <button type="button" class="toggle-password" onclick="togglePassword()" aria-label="Mostrar senha">
                        <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="remember-row" id="fg-remember">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Lembrar-me neste dispositivo</label>
            </div>

            <button type="submit" class="btn-submit" id="btn">
                <span id="btnText">Entrar</span>
                <span class="btn-loader" id="btnLoader">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M21 12a9 9 0 1 1-6.22-8.56"/>
                    </svg>
                    Entrando...
                </span>
            </button>
        </form>

        <div class="login-footer" id="footer">
            <p>Não tem uma conta? <a href="#">Cadastre-se</a></p>
        </div>
    </main>

    <script src="../js/index.js">
    </script>

</body>

</html>