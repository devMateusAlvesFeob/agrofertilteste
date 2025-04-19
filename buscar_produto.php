<?php
header('Content-Type: application/json');

include 'conexao.php';

if (!$conn instanceof mysqli || $conn->connect_error) {
    echo json_encode(['error' => 'Conexão com o banco falhou']);
    exit;
}

$id = $conn->real_escape_string($_GET['id'] ?? '');

if (empty($id)) {
    echo json_encode(['error' => 'ID não fornecido']);
    exit;
}

$sql = "SELECT * FROM tabela_precos WHERE id = ?";
$sql = "SELECT idProduto, descricao, precoCusto, precoAnterior, margem FROM tabela_precos WHERE idProduto = ?";


$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['error' => 'Erro na preparação: ' . $conn->error]);
    exit;
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(['error' => 'Produto não encontrado']);
}

$stmt->close();
$conn->close();
