<!-- dashboard.php -->
<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h2>Dashboard</h2>
    <p>Bem-vindo, <?php echo $username; ?>!</p>
    <p><a href="logout.php">Sair</a></p>

    <!-- Botão para criar backup -->
    <form action="criar_backup.php" method="post">
        <input type="submit" name="backup" value="Criar Backup da Tabela de Usuários">
    </form>
</body>
</html>
