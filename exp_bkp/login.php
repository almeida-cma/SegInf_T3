<?php
session_start();

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $senha = $_POST['senha'];

    // Consulta usuário no banco de dados
    $sql = "SELECT * FROM usuarios WHERE username='$username'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        // Usuário encontrado, verifica a senha
        $row = $result->fetch_assoc();
        if (password_verify($senha, $row['senha'])) {
            // Login bem-sucedido
            $_SESSION['userid'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            if ($row['autenticacao_habilitada']) {
                // Implementar lógica para autenticação em duas etapas
                $_SESSION['message'] = "Login bem-sucedido! Autenticação em duas etapas requerida.";
                header('Location: autenticacao.php');
                exit();
            } else {
                $_SESSION['message'] = "Login bem-sucedido!";
                header('Location: dashboard.php');
                exit();
            }
        } else {
            $_SESSION['error'] = "Senha incorreta!";
        }
    } else {
        $_SESSION['error'] = "Usuário não encontrado!";
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login de Usuário</title>
</head>
<body>
    <h2>Login de Usuário</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <p style="color: red;"><?php echo $_SESSION['error']; ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['message'])): ?>
        <p style="color: green;"><?php echo $_SESSION['message']; ?></p>
        <?php unset($_SESSION['message']); ?>
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
