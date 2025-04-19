<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Entrar - Microsoft</title>
  <link rel="stylesheet" href="Styles.css/stilecssreal.css" />
</head>

<body>
  <div class="container">
    <div class="login-box">
      <img
        src="assets/logo-agrofertil-removebg-preview.png"
        alt="Agrofertil logo"
        class="logo" />
      <h2>Entrar</h2>
      <input type="text" id="usuario" placeholder="Usuário" class="input" />
      <input
        type="password"
        id="senha"
        placeholder="Sua senha"
        class="input" />

      <a href="#" class="link">Não consegue acessar sua conta?</a>
      <div class="buttons">
        <button class="btn avancar" onclick="verificarLogin()">
          Avançar
        </button>
      </div>
    </div>
    <div class="footer">
      <button class="entrada"><span class="icon">🔑</span> Manual</button>
    </div>
  </div>

  <script>
    function verificarLogin() {
      const usuario = document.getElementById("usuario").value;
      const senha = document.getElementById("senha").value;

      if (usuario === "admin" && senha === "admin") {
        window.location.href = "menu-admin.php";
      } else {
        alert("Usuário ou senha incorretos!");
      }
    }
  </script>
</body>

</html>