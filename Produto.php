<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="Styles.css/cadastro.css" />
    <title>AgroPlataforma</title>
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

            // Recebe os dados do formulário
            $descricao = $_POST['descricao'];
            $categoria = $_POST['categoria'];
            $observacao = $_POST['observacao'];
            $precoCusto = str_replace(',', '.', $_POST['precoCusto']); // Converte vírgula para ponto
            $margem = str_replace(',', '.', $_POST['margem']); // Converte vírgula para ponto

            // Calcula o preço de partida (opcional, se quiser calcular automaticamente)
            // $precoPartida = $precoCusto * (1 + ($margem / 100));

            // Prepara a query SQL com prepared statements
            // Nota: Adicionei a coluna 'categoria' que estava no formulário mas não na query
            $stmt = $conn->prepare("INSERT INTO tabela_precos (descricao, categoria, observacao, precoCusto, margem) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssdd", $descricao, $categoria, $observacao, $precoCusto, $margem);

            // Executa a query
            if ($stmt->execute()) {
                $mensagem = "Produto cadastrado com sucesso!";
                $classe = "success";
            } else {
                $mensagem = "Erro ao cadastrar produto: " . $stmt->error;
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

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="cabecalho">
                <h1>Cadastro de Produtos</h1>
            </div>
            <div class="cadastroUnico">
                <label for="descricao"><strong>Descrição:</strong></label>
                <input
                    type="text"
                    id="descricao"
                    name="descricao"
                    required
                    placeholder="Digite a descrição" /><br />
                <label for="categoria"><strong>Categoria:</strong></label>
                <select id="categoria" name="categoria" required>
                    <optgroup label="Defensivos e Produtos Agrícolas">
                        <option value="adubos">Adubos</option>
                        <option value="biologicos">Biológicos</option>
                        <option value="fungicida">Fungicida</option>
                        <option value="fungicida_herbicida">Fungicida + Herbicida</option>
                        <option value="foliares">Foliares</option>
                        <option value="herbicida">Herbicida</option>
                        <option value="inoculantes">Inoculantes</option>
                        <option value="sementes">Sementes</option>
                    </optgroup>
                </select><br />

                <label for="observacao"><strong>Observação:</strong></label>
                <input
                    type="text"
                    id="observacao"
                    name="observacao"
                    placeholder="Digite a observação" /><br />

                <label for="precoCusto"><strong>Preço de custo ATUAL:</strong></label>
                <input
                    type="text"
                    id="precoCusto"
                    name="precoCusto"
                    required
                    placeholder="Digite o preço de custo" /><br />

                <label for="margem"><strong>Markup:</strong></label>
                <input
                    type="text"
                    id="margem"
                    name="margem"
                    required
                    placeholder="Digite a margem" />
            </div>

            <div class="botoes">
                <a href="menu-admin.php" class="btn-menu">Menu</a>
                <button type="submit" class="btn">Cadastrar</button>
            </div>
        </form>
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