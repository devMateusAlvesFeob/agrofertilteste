<?php

// Inclui o arquivo de conexão com o banco de dados
require_once 'conexao.php'; // Certifique-se de que o caminho para o seu arquivo de conexão está correto

// Verifica se a conexão foi estabelecida com sucesso (opcional, mas bom para segurança)
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Coleta os dados do formulário
$nome = $_POST["nome"];
$email = $_POST["email"];
$usuario = $_POST["usuario"];
$senha = password_hash($_POST["senha"], PASSWORD_DEFAULT); // Hash da senha por segurança
$categoria = $_POST["categoria"];

// Prepara a query SQL para inserir os dados
$sql = "INSERT INTO usuarios (email, usuario, senha, categoria) VALUES (?, ?, ?, ?)";

// Cria uma prepared statement
$stmt = $conn->prepare($sql);

// Liga os parâmetros
$stmt->bind_param("ssss", $email, $usuario, $senha, $categoria);

// Executa a query
if ($stmt->execute()) {
    echo "Usuário cadastrado com sucesso!";
    // Você pode redirecionar o usuário para outra página aqui, se desejar
    // header("Location: pagina_de_sucesso.php");
} else {
    echo "Erro ao cadastrar o usuário: " . $stmt->error;
}

// Fecha a statement e a conexão
$stmt->close();
$conn->close();

?>