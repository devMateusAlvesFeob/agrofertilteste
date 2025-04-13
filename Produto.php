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
        /*<?php
        // Inicializa a variável de mensagem e classe
        $mensagem = '';
        $classe = '';

        // Verifica se o formulário foi enviado
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Inclui o arquivo de conexão
            include 'conexao.php';

            // Recebe os dados do formulário
            $descricao = $_POST['descricao'];
            $observacao = $_POST['observacao'];
            $precoCusto = $_POST['precoCusto'];
            $margem = $_POST['margem'];
            $precoPartida = $_POST['precoPartida'];

            // Prepara a query SQL com prepared statements
            $stmt = $conn->prepare("INSERT INTO tabela_precos (descricao, observacao, precoCusto, margem, partida) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssddd", $descricao, $observacao, $precoCusto, $margem, $precoPartida);

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
        ?>*/
        
        <div class="alerta <?php echo $classe; ?>" id="mensagem" style="display: <?php echo $mensagem ? 'block' : 'none'; ?>;">
            <?php echo $mensagem; ?>
        </div>

        <form action="Produto.php" method="post">
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
                    placeholder="Digite a descrição"
                /><br />
                <label for="categoria"><strong>Categoria:</strong></label>
                <select id="categoria" name="categoria" required>
  <!-- Fertilizantes -->
  <optgroup label="Fertilizantes">
    <option value="fertilizantes_foliares">Fertilizantes Foliares</option>
    <option value="fertilizantes_soluveis">Fertilizantes Solúveis</option>
    <option value="fertilizantes_orgânicos">Fertilizantes Orgânicos</option>
  </optgroup>
  
  <!-- Biológicos -->
  <optgroup label="Biológicos">
    <option value="biologicos_agricolas">Biológicos Agrícolas</option>
    <option value="inoculantes">Inoculantes</option>
  </optgroup>
  
  <!-- Sementes -->
  <optgroup label="Sementes">
    <option value="sementes_milho">Sementes de Milho</option>
    <option value="sementes_soja">Sementes de Soja</option>
    <option value="sementes_brachiarias">Sementes de Brachiária</option>
  </optgroup>
  
  <!-- Defensivos -->
  <optgroup label="Defensivos">
    <option value="defensivos_inseticidas">Defensivos (Inseticidas)</option>
    <option value="defensivos_fungicidas">Defensivos (Fungicidas)</option>
    <option value="herbicidas">Herbicidas</option>
  </optgroup>
  
  <!-- Outros Produtos -->
  <optgroup label="Outros Produtos">
    <option value="aditivos_agricolas">Aditivos Agrícolas</option>
    <option value="calcio_magnesium">Calcário e Máxi-Cal</option>
    <option value="ferramentas_agricolas">Ferramentas e Equipamentos Agrícolas</option>
    <option value="equipamentos_irrigacao">Equipamentos de Irrigação</option>
    <option value="mulchagem">Mulchagem e Cobertura de Solo</option>
    <option value="outros_produtos">Outros Produtos Agropecuários</option>
  </optgroup>
</select>


</select><br />


                <label for="observacao"><strong>Observação:</strong></label>
                <input
                    type="text"
                    id="observacao"
                    name="observacao"
                    placeholder="Digite a observação"
                /><br />

                <label for="precoCusto"><strong>Penultimo preço de custo:</strong></label>
                <input
                    type="text"
                    id="precoCusto"
                    name="precoCusto"
                    required
                    placeholder="Digite o preço de custo"
                /><br />

                <label for="precoCusto"><strong>Preço de custo ATUAL:</strong></label>
                <input
                    type="text"
                    id="precoCusto"
                    name="precoCusto"
                    required
                    placeholder="Digite o preço de custo"
                /><br />

                <label for="margem"><strong>Taxa para calculo da margem:</strong></label>
                <input
                    type="text"
                    id="margem"
                    name="margem"
                    required
                    placeholder="Digite a margem"
                /><br />

                <label for="precoPartida"><strong>Preço de Partida:</strong></label>
                <input
                    type="text"
                    id="precoPartida"
                    name="precoPartida"
                    required
                    placeholder="Preco atualizado"
                /><br />
            </div>

            <div class="botoes">
                <a href="index.html" class="btn-retornar">Menu Principal</a>
                <button type="submit" class="btn">Cadastrar</button>
            </div>
        </form>
    </div>
</body>
</html>
