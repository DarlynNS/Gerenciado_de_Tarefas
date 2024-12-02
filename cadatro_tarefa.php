<?php
// Inclui o arquivo de conexão com o banco de dados
include 'db.php';

// Verifica se o formulário foi enviado para registrar o pedido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $descricao = $_POST['descricao'];
    $nome_setor = $_POST['nome_setor'];
    $prioridade = $_POST['prioridade'];
    $data_cadastro = $_POST['data_cadastro'];
    $status = $_POST['status'];

    // Insere o pedido no banco de dados
    $sql = "INSERT INTO visualizar (id_usuario, descricao, nome_setor, prioridade, data_cadastro, status)
            VALUES (:id_usuario, :nome_setor, :prioridade, :data_cadastro, :status)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':nome_setor', $nome_setor);
    $stmt->bindParam(':prioridade', $prioridade);
    $stmt->bindParam(':data_cadastro', $data_cadastro);
    $stmt->bindParam(':status', $status);

    $stmt->execute();

    /* Redireciona para a página de visualização de visualizar
    header('Location: visualizar.php');
    exit;*/
}

// Consulta todos os clientes cadastrados
$sql = "SELECT * FROM usuario";
$stmt = $conn->prepare($sql);
$stmt->execute();
$clientes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Tarefa - Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="style.css">
    <script>
        // Função para preencher os campos de telefone e endereço automaticamente ao selecionar o cliente
        function preencherDadosCliente() {
            var clienteId = document.getElementById("id_usuario").value;
            var telefone = document.getElementById("telefone");
            var endereco = document.getElementById("endereco");

            <?php foreach ($clientes as $cliente): ?>
                if (clienteId == <?php echo $cliente['id']; ?>) {
                    telefone.value = "<?php echo $cliente['telefone_cliente']; ?>";
                    endereco.value = "<?php echo $cliente['endereco_cliente']; ?>";
                }
            <?php endforeach; ?>
        }
    </script>
</head>
<body>
    <!-- Menu de Navegação -->
    <nav>
        <a href="cadastro_tarefa.php">Registrar Tarefa</a>
        <a href="visualizar.php">Visualizar Tarefas</a>
        <a href="cadastro_usuario.php">Cadastrar Usuário</a>
    </nav>

    <h1>Registrar Tarefa</h1>
    <form action="cadastro_tarefa.php" method="POST">
        <label for="id_usuario">Selecione o Usuário:</label>
        <select id="id_usuario" name="id_usuario" onchange="preencherDadosCliente()" required>
            <option value="">Escolha o Usuário</option>
            <?php foreach ($clientes as $cliente): ?>
                <option value="<?php echo $cliente['id']; ?>"><?php echo $cliente['nome']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" disabled><br>

        <label for="nome_setor">Nome do Setor:</label>
        <input type="text" id="nome_setor" name="nome_setor" required><br>

        <label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="descricao" required><br>

        <label for="prioridade">Prioridade:</label>
        <input type="number" id="prioridade" name="prioridade" required><br>

        <label for="data_cadastro">Data:</label>
        <input type="text" id="data_cadastro" name="data_cadastro"><br>

        <label for="status">Status:</label>
        <input type="text" id="status" name="status"><br>

        <button type="submit">Registrar Tarefa</button>
    </form>
</body>
</html>
