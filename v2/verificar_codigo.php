<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header('Location: login.php');
    exit();
}

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo = $_POST['codigo'];
    $userid = $_SESSION['userid'];

    $stmt = $mysqli->prepare("SELECT codigo_autenticacao FROM usuarios WHERE id=?");
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if ($codigo == $user['codigo_autenticacao']) {
            $_SESSION['autenticado'] = true;
            header('Location: dashboard.php');
            exit();
        } else {
            $_SESSION['error'] = "Código de autenticação incorreto.";
        }
    } else {
        $_SESSION['error'] = "Erro ao verificar o código de autenticação.";
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Verificar Código de Autenticação</title>
</head>
<body>
    <h2>Verificar Código de Autenticação</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <p style="color: red;"><?php echo $_SESSION['error']; ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <form action="verificar_codigo.php" method="post">
        <label for="codigo">Código de Autenticação:</label><br>
        <input type="text" id="codigo" name="codigo" required><br><br>
        <input type="submit" value="Verificar">
    </form>
</body>
</html>
