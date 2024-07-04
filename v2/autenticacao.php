<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header('Location: login.php');
    exit();
}

require_once 'db.php';

$userid = $_SESSION['userid'];

$stmt = $mysqli->prepare("SELECT autenticacao_habilitada, codigo_autenticacao FROM usuarios WHERE id=?");
$stmt->bind_param("i", $userid);
$stmt->execute();
$result_check_auth = $stmt->get_result();

if ($result_check_auth->num_rows > 0) {
    $row = $result_check_auth->fetch_assoc();
    if (!$row['autenticacao_habilitada']) {
        $_SESSION['message'] = "Autenticação em duas etapas não está habilitada.";
        header('Location: dashboard.php');
        exit();
    }

    $codigo_autenticacao = $row['codigo_autenticacao'];
    if (!$codigo_autenticacao) {
        $codigo_autenticacao = rand(100000, 999999);
        $stmt = $mysqli->prepare("UPDATE usuarios SET codigo_autenticacao=? WHERE id=?");
        $stmt->bind_param("ii", $codigo_autenticacao, $userid);
        $stmt->execute();
    }
} else {
    $_SESSION['error'] = "Erro ao verificar autenticação em duas etapas.";
    header('Location: dashboard.php');
    exit();
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Autenticação em Duas Etapas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100% - 1rem);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Autenticação em Duas Etapas</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <p style="color: red;"><?php echo $_SESSION['error']; ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['message'])): ?>
            <p style="color: green;"><?php echo $_SESSION['message']; ?></p>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        <p>Um código de autenticação foi enviado para o seu e-mail. Por favor, insira o código abaixo para continuar.</p>
        <form action="verificar_codigo.php" method="post">
            <div class="form-group">
                <label for="codigo">Código de Autenticação:</label>
                <input type="text" id="codigo" name="codigo" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Verificar Código</button>
        </form>
    </div>
</body>
</html>
