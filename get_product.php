<?php
header('Content-Type: application/json');
include 'conexao.php';

// Recebe o idProduto via GET
$idProduto = $_GET['idProduto'] ?? '';
$response = [];

if (!empty($idProduto)) {
    // Prepara a consulta no banco para buscar os dados do produto
    $stmt = $conn->prepare("SELECT * FROM tabela_precos WHERE idProduto = ?");
    $stmt->bind_param("i", $idProduto);

    // Executa a consulta
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($produto = $result->fetch_assoc()) {
            // Se encontrar o produto, retorna os dados, incluindo o preço anterior
            $response = [
                "categoria" => $produto["categoria"] ?? '',
                "observacao" => $produto["observacao"] ?? '',
                "precoCusto" => number_format($produto["precoCusto"], 2, ',', '') ?? '',
                "precoAnterior" => number_format($produto["precoAnterior"], 2, ',', '') ?? '',
                "margem" => number_format($produto["margem"], 2, ',', '') ?? ''
            ];
        } else {
            // Se o produto não for encontrado, retorna um erro
            $response = ['error' => 'Produto não encontrado'];
        }
    } else {
        // Se houver erro na execução da query
        $response = ['error' => 'Erro ao executar consulta: ' . $stmt->error];
    }

    $stmt->close();
} else {
    $response = ['error' => 'ID do produto não fornecido'];
}

echo json_encode($response);
