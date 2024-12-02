<?php
// Inclui o arquivo de conexão com o banco de dados
include 'db.php';

// Verifica se o pedido foi excluído
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $sql = "DELETE FROM tarefa WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header('Location: cadastro_tarefa.php');
    exit;
}

// Verifica se o status do pedido foi alterado
if (isset($_GET['atualizar_status'])) {
    $id = $_GET['atualizar_status'];
    $sql = "UPDATE tarefa SET status = CASE 
                WHEN status = 'A fazer' THEN 'Em preparação' 
                WHEN status = 'Em preparação' THEN 'Pronto' 
                WHEN status = 'Pronto' THEN 'A fazer' 
            END WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header('Location: cadastro_tarefa.php');
    exit;
}

// Consulta os tarefa e os dados dos usuario
$sql = "SELECT tarefa.*, usuario.nome, usuario.email
        FROM tarefa 
        JOIN usuario ON tarefa.id_usuario = id_usuario";
$stmt = $conn->prepare($sql);
$stmt->execute();
$tarefa = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Tarefas - Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Menu de Navegação -->
    <nav>
        <a href="cadastro_tarefa.php">Registrar Tarefa</a>
        <a href="visualizar.php">Visualizar Tarefa</a>
        <a href="cadastro_usuario.php">Cadastrar Usuário</a>
    </nav>

    <h1>Tarefas</h1>
    <div class="colunas">
        <!-- tarefa a fazer -->
        <div class="coluna">
            <h2>Tarefa a Fazer</h2>
            <?php foreach ($tarefa as $pedido): ?>
                <?php if ($pedido['status'] == 'A fazer'): ?>
                    <div class="pedido">
                        <p><strong>Usuário:</strong> <?php echo $pedido['nome']; ?></p>
                        <p><strong>Email:</strong> <?php echo $pedido['email']; ?></p>
                        <p><strong>Descrição:</strong> <?php echo $pedido['descricao']; ?></p>
                        <p><strong>Prioridade:</strong> <?php echo $pedido['prioridade']; ?></p>
                        <p><strong>Data do Cadastro:</strong> <?php echo $pedido['data_cadastro']; ?></p>
                        <p><strong>Status:</strong> <?php echo $pedido['status']; ?></p>
                        <a href="?atualizar_status=<?php echo $pedido['id']; ?>">Alterar Status</a>
                        <a href="?excluir=<?php echo $pedido['id']; ?>">Excluir Pedido</a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- tarefa em preparação -->
        <div class="coluna">
            <h2>tarefa em Preparação</h2>
            <?php foreach ($tarefa as $pedido): ?>
                <?php if ($pedido['status'] == 'Em preparação'): ?>
                    <div class="pedido">
                        <p><strong>Usuário:</strong> <?php echo $pedido['nome']; ?></p>
                        <p><strong>Email:</strong> <?php echo $pedido['email']; ?></p>
                        <p><strong>Descrição:</strong> <?php echo $pedido['descricao']; ?></p>
                        <p><strong>Prioridade:</strong> <?php echo $pedido['prioridade']; ?></p>
                        <p><strong>Data do Cadastro:</strong> <?php echo $pedido['data_cadastro']; ?></p>
                        <p><strong>Status:</strong> <?php echo $pedido['status']; ?></p>
                        <a href="?atualizar_status=<?php echo $pedido['id']; ?>">Alterar Status</a>
                        <a href="?excluir=<?php echo $pedido['id']; ?>">Excluir Pedido</a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- tarefa prontos -->
        <div class="coluna">
            <h2>tarefa Prontos</h2>
            <?php foreach ($tarefa as $pedido): ?>
                <?php if ($pedido['status'] == 'Pronto'): ?>
                    <div class="pedido">
                        <p><strong>Usuário:</strong> <?php echo $pedido['nome']; ?></p>
                        <p><strong>Email:</strong> <?php echo $pedido['email']; ?></p>
                        <p><strong>Descrição:</strong> <?php echo $pedido['descricao']; ?></p>
                        <p><strong>Prioridade:</strong> <?php echo $pedido['prioridade']; ?></p>
                        <p><strong>Data do Cadastro:</strong> <?php echo $pedido['data_cadastro']; ?></p>
                        <p><strong>Status:</strong> <?php echo $pedido['status']; ?></p>
                        <a href="?atualizar_status=<?php echo $pedido['id']; ?>">Alterar Status</a>
                        <a href="?excluir=<?php echo $pedido['id']; ?>">Excluir Pedido</a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
