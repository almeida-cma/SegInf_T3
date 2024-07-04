<!-- criar_backup.php -->
<?php
require_once 'db.php';

// Consulta para obter todos os usuários
$sql = "SELECT * FROM usuarios";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // Array para armazenar linhas de dados
    $rows = [];

    while ($row = $result->fetch_assoc()) {
        // Adicionar cada linha de usuário ao array
        $rows[] = $row;
    }

    // Nome do arquivo de backup
    $backup_file = 'backup_usuarios_' . date('Y-m-d_H-i-s') . '.csv';

    // Caminho onde o arquivo será salvo (pasta backup dentro do diretório do script)
    $backup_path = __DIR__ . '\\backup\\' . $backup_file;

    // Abrir arquivo para escrita
    $backup_handle = fopen($backup_path, 'w');

    if ($backup_handle === false) {
        die("Erro ao abrir o arquivo de backup para escrita.");
    }

    // Escrever cabeçalho (opcional)
    fputcsv($backup_handle, array_keys($rows[0]));

    // Escrever linhas de dados
    foreach ($rows as $row) {
        fputcsv($backup_handle, $row);
    }

    // Fechar o arquivo
    fclose($backup_handle);

    // Mensagem de sucesso
    echo "Backup criado com sucesso em: " . $backup_path;
} else {
    echo "Nenhum usuário encontrado para criar backup.";
}

$mysqli->close();
?>
