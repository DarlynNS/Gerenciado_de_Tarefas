<?php
// Inclui o arquivo de conexão com o banco de dados
include 'db.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coleta os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    // Insere os dados no banco de dados
    $sql = "INSERT INTO usuario (nome, email)
            VALUES (:nome, :email)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);

    $stmt->execute();

    // Redireciona para a página de visualizar
    header('Location: cadatro_tarefa.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário - Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Menu de Navegação -->
    <nav>
        <a href="cadastro_tarefa.php">Registrar Tarefa</a>
        <a href="visualizar.php">Visualizar Tarefas</a>
        <a href="cadastro_usuario.php">Cadastrar Usuário</a>
    </nav>

    <h1>Cadastro de Usuário</h1>
    <form action="cadastro_usuario.php" method="POST">
        <label for="nome">Nome do Usuário:</label>
        <input type="text" id="nome" name="nome" required><br>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required><br>

        <button type="submit">Cadastrar Usuário</button>
    </form>
</body>
</html>
