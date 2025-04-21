<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="Styles.css/usuarios.css" />
    <title>Agrofertil Agricola</title>
    <style>
        .alerta {
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .alerta.show {
            opacity: 1;
        }

        .alerta.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alerta.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>
    <div class="tela">
        <?php
        // Inicializa a variável de mensagem e classe
        $mensagem = '';
        $classe = '';

        // Verifica se o formulário foi enviado
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Inclui o arquivo de conexão
            include 'conexao.php';

            // Recebe os dados do formulário de usuários
            $nome = $_POST["nome"];
            $email = $_POST["email"];
            $usuario = $_POST["usuario"];
            $senha = $_POST["senha"]; // Não hash a senha aqui para salvar como string
            $categoria = $_POST["categoria"];

            // Prepara a query SQL para inserir os dados na tabela 'usuarios'
            $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, usuario, senha, categoria) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $nome, $email, $usuario, $senha, $categoria);

            // Executa a query
            if ($stmt->execute()) {
                $mensagem = "Usuário cadastrado com sucesso!";
                $classe = "success";
            } else {
                $mensagem = "Erro ao cadastrar o usuário: " . $stmt->error;
                $classe = "error";
            }

            // Fecha a conexão
            $stmt->close();
            $conn->close();
        }
        ?>

        <div class="alerta <?php echo $classe; ?> <?php echo $mensagem ? 'show' : ''; ?>" id="mensagem">
            <?php echo $mensagem; ?>
        </div>

        <div class="cabecalho">
            <h1>Gestão de Usuários</h1>
            <p>Cadastramento de Usuários</p>
        </div>
        <div class="superior">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="nome">Nome Completo</label>
                <input type="text" id="nome" name="nome" required />

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required />

                <label for="usuario">Usuário:</label>
                <input type="text" id="usuario" name="usuario" required />

                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required />

                <label for="categoria">Categoria:</label>
                <select name="categoria" id="categoria" required>
                    <option value="administrador">Administrador</option>
                    <option value="usuario">Usuário</option>
                </select>

                <button class="btn" type="submit">Cadastrar Usuário</button>
            </form>
        </div>
    </div>
    <script>
        // Fecha o alerta após 5 segundos
        document.addEventListener('DOMContentLoaded', function() {
            const alerta = document.getElementById('mensagem');
            if (alerta) {
                setTimeout(() => {
                    alerta.classList.remove('show');
                }, 5000);
            }
        });
    </script>
</body>

</html>