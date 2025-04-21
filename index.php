<?php
session_start(); // Inicia a sessão para armazenar informações do usuário logado

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include 'conexao.php'; // Inclui o arquivo de conexão com o banco de dados

  $usuario = $_POST["usuario"];
  $senha = $_POST["senha"];

  // Prepara a query para buscar o usuário, senha e categoria
  $stmt = $conn->prepare("SELECT id, categoria FROM usuarios WHERE usuario = ? AND senha = ?");
  $stmt->bind_param("ss", $usuario, $senha);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows == 1) {
    $stmt->bind_result($id, $categoria);
    $stmt->fetch();

    // Armazena informações na sessão
    $_SESSION["usuario_id"] = $id;
    $_SESSION["usuario_categoria"] = $categoria;

    // Redireciona de acordo com a categoria
    if ($categoria === "administrador") {
      header("Location: menu-admin.php");
    } else {
      header("Location: tabela2.php");
    }
    exit();
  } else {
    // Usuário ou senha incorretos
    $erro = "Usuário ou senha incorretos!";
  }

  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Agrofertil Agricola</title>
  <link rel="stylesheet" href="Styles.css/stilecssreal.css" />
  <style>
    .error-message {
      color: red;
      margin-top: 10px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="login-box">
      <img src="assets/logo-agrofertil-removebg-preview.png" alt="Agrofertil logo" class="logo" />
      <h2>Entrar</h2>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="text" id="usuario" name="usuario" placeholder="Usuário" class="input" required />
        <input type="password" id="senha" name="senha" placeholder="Sua senha" class="input" required />

        <a href="#" class="link">Não consegue acessar sua conta?</a>
        <div class="buttons">
          <button type="submit" class="btn avancar">Avançar</button>
        </div>
      </form>
      <?php if (isset($erro)): ?>
        <p class="error-message"><?php echo $erro; ?></p>
      <?php endif; ?>
    </div>
    <div class="footer">
      <button class="entrada"><span class="icon">🔑</span>Suporte</button>
    </div>
  </div>
</body>

</html>