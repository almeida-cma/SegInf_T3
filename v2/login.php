<?php
session_start();

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $senha = $_POST['senha'];

    $stmt = $mysqli->prepare("SELECT id, senha, autenticacao_habilitada FROM usuarios WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (password_verify($senha, $user['senha'])) {
            $_SESSION['userid'] = $user['id'];
            $_SESSION['username'] = $username;

            if ($user['autenticacao_habilitada']) {
                header('Location: autenticacao.php');
            } else {
                header('Location: dashboard.php');
            }
            exit();
        } else {
            $_SESSION['error'] = "Credenciais incorretas. Por favor, tente novamente.";
        }
    } else {
        $_SESSION['error'] = "Usuário não encontrado.";
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <p style="color: red;"><?php echo $_SESSION['error']; ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <form action="login.php" method="post">
        <label for="username">Nome de Usuário:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        <label for="senha">Senha:</label><br>
        <input type="password" id="senha" name="senha" required><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
