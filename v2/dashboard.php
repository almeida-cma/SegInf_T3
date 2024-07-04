<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header('Location: login.php');
    exit();
}

echo "Bem-vindo ao dashboard, " . $_SESSION['username'] . "!";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h2>Dashboard</h2>
    <a href="criar_backup.php">Criar Backup</a><br><br>
    <a href="logout.php">Logout</a>
</body>
</html>
