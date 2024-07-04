<?php
session_start();

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirm_senha = $_POST['confirm_senha'];

    if ($senha !== $confirm_senha) {
        $_SESSION['error'] = "As senhas não coincidem. Por favor, tente novamente.";
        header('Location: register.php');
        exit();
    }

    $stmt = $mysqli->prepare("SELECT * FROM usuarios WHERE username=? OR email=?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result_check_user = $stmt->get_result();

    if ($result_check_user->num_rows > 0) {
        $_SESSION['error'] = "Usuário ou e-mail já registrado. Por favor, escolha outro.";
        header('Location: register.php');
        exit();
    }

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("INSERT INTO usuarios (username, email, senha) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $senha_hash);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Usuário registrado com sucesso!";

        if (isset($_POST['autenticacao_duas_etapas']) && $_POST['autenticacao_duas_etapas'] == 1) {
            $userid = $mysqli->insert_id;
            $codigo_autenticacao = rand(100000, 999999);

            $stmt = $mysqli->prepare("UPDATE usuarios SET autenticacao_habilitada=1, codigo_autenticacao=? WHERE id=?");
            $stmt->bind_param("ii", $codigo_autenticacao, $userid);
            $stmt->execute();

            $_SESSION['message'] = "Autenticação em duas etapas habilitada. Um código de autenticação foi enviado para você.";
            header('Location: autenticacao.php');
            exit();
        } else {
            header('Location: login.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Erro ao registrar o usuário: " . $stmt->error;
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuário</title>
    <script>
        function verificarSenha() {
            var senha = document.getElementById('senha').value;
            var confirmSenha = document.getElementById('confirm_senha').value;
            var mensagem = document.getElementById('mensagem-senha');
            var forte = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            if (senha !== confirmSenha) {
                mensagem.style.color = 'red';
                mensagem.textContent = 'As senhas não coincidem.';
                return false;
            }

            if (forte.test(senha)) {
                mensagem.style.color = 'green';
                mensagem.textContent = 'Senha forte.';
                return true;
            } else {
                mensagem.style.color = 'red';
                mensagem.textContent = 'A senha deve ter pelo menos 8 caracteres, incluindo letras maiúsculas, minúsculas, números e caracteres especiais.';
                return false;
            }
        }
    </script>
</head>
<body>
    <h2>Registro de Usuário</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <p style="color: red;"><?php echo $_SESSION['error']; ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <p style="color: green;"><?php echo $_SESSION['success']; ?></p>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <form action="register.php" method="post" onsubmit="return verificarSenha();">
        <label for="username">Nome de Usuário:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        <label for="email">E-mail:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <label for="senha">Senha:</label><br>
        <input type="password" id="senha" name="senha" required oninput="verificarSenha();"><br><br>
        <label for="confirm_senha">Confirme a Senha:</label><br>
        <input type="password" id="confirm_senha" name="confirm_senha" required oninput="verificarSenha();"><br>
        <span id="mensagem-senha"></span><br><br>
        <label>
            <input type="checkbox" name="autenticacao_duas_etapas" value="1"> Habilitar Autenticação em Duas Etapas
        </label><br><br>
        <input type="submit" value="Registrar">
    </form>
</body>
</html>
