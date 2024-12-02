<?php
$host = 'localhost'; //IP do servidor
$dbname = 'kanbanbd'; // Nome do banco de dados
$username = 'root'; // Usuário
$password = ''; //Não tem senha

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Definindo o modo de erro para exceção
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Falha na conexão: " . $e->getMessage();
}
?>
