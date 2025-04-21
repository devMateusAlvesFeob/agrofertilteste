<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="Styles.css/testedeestilo.css" />
  <title>Agrofertil Agricola</title>
</head>

<body>
  <?php
  // Conexão com o banco de dados
  include 'conexao.php';

  // Verificar se a conexão foi estabelecida
  if (!($conn instanceof mysqli) || $conn->connect_error) {
    die("Erro: Conexão com o banco de dados não estabelecida corretamente");
  }

  // Buscar produtos do banco de dados
  $produtos = [];
  try {
    $sql = "SELECT idProduto, descricao FROM tabela_precos ORDER BY descricao";
    $result = $conn->query($sql);

    if ($result === false) {
      throw new Exception("Erro na consulta: " . $conn->error);
    }

    $produtos = $result->fetch_all(MYSQLI_ASSOC);
  } catch (Exception $e) {
    die("Erro: " . $e->getMessage());
  }

  // Buscar o mês selecionado
  $sql = "SELECT mesSelecionado FROM configuracoes LIMIT 1";
  $resultMes = $conn->query($sql);
  $mesAtual = $resultMes && $resultMes->num_rows > 0 ? $resultMes->fetch_assoc()['mesSelecionado'] : 'setembro';
  ?>

  <form action="" method="get">
    <div class="conteiner-principal">
      <div class="cabecalho">
        <h1>TABELA ONLINE</h1>
      </div>
      <div class="conteiner1">
        <img src="assets/logo-agrofertil-removebg-preview.png" alt="logomarca da empresa" width="40%" />
      </div>
    </div>

    <div class="conteiner2">
      <select id="produto" name="produto" required>
        <option value="">Selecione um produto</option>
        <?php foreach ($produtos as $produto): ?>
          <option value="<?php echo $produto['idProduto']; ?>">
            <?php echo htmlspecialchars($produto['descricao']); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="menu-exibicao">
      <label for="valor">Valor à vista: R$</label>
      <span id="valorDisplay" style="font-weight: bold; padding: 5px; display: inline-block;"></span>
      <input type="hidden" id="valor" name="valor" />
    </div>

    <div class="menu-exibicao">
      <label for="prazo">Prazo safra: R$</label>
      <span id="prazoDisplay" style="font-weight: bold; padding: 5px; display: inline-block;"></span>
      <input type="hidden" id="prazo" name="prazo" />
    </div>

    <div class="campo-observacao">
      <h3>Observações:</h3>
      <textarea class="bold-textarea" rows="4" cols="50" name="observacao"></textarea>
    </div>

    <div class="toggle">Clique para exibir a tabela completa</div>
    <div class="conteiner3">
      <div class="tabEsquerda">
        <?php
        $meses = ['setembro', 'outubro', 'novembro', 'dezembro', 'janeiro', 'fevereiro', 'marco', 'abril', 'maio', 'junho', 'julho', 'agosto'];
        foreach ($meses as $mes): ?>
          <label for="<?php echo $mes; ?>"><?php echo ucfirst($mes); ?></label>
          <span id="<?php echo $mes; ?>" data-preco="0.00">R$ 0,00</span><br />
        <?php endforeach; ?>
      </div>
    </div>

    <script>
      document.querySelectorAll(".toggle").forEach((toggle) => {
        toggle.addEventListener("click", function() {
          const content = this.nextElementSibling;
          content.style.display = content.style.display === "block" ? "none" : "block";
        });
      });

      // Função para formatar valor em moeda
      function formatarMoeda(valor) {
        return valor.toLocaleString('pt-BR', {
          style: 'currency',
          currency: 'BRL',
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        });
      }

      document.getElementById("produto").addEventListener("change", function() {
        const produtoId = this.value;
        if (produtoId) {
          fetch(`buscar_produto.php?id=${produtoId}`)
            .then((response) => {
              if (!response.ok) {
                throw new Error('Erro na requisição');
              }
              return response.json();
            })
            .then((data) => {
              if (data.error) {
                console.error("Erro:", data.error);
                return;
              }

              // Obtém os valores do banco de dados
              const precoCusto = parseFloat(data.precoCusto) || 0;
              const precoAnterior = parseFloat(data.precoAnterior) || 0;
              const margemPercentual = parseFloat(data.margem) || 0;

              // Calcula o valor base
              const valorBase = (precoCusto + precoAnterior) / 2;

              // Aplica a margem para obter o valor à vista
              const valorAVista = valorBase * (1 + (margemPercentual / 100));

              // Exibe o valor à vista
              document.getElementById("valorDisplay").textContent = formatarMoeda(valorAVista);
              document.getElementById("valor").value = valorAVista.toFixed(2);

              // Cálculo do prazo safra
              const prazoSafra = valorAVista * 1.1779;
              document.getElementById("prazoDisplay").textContent = formatarMoeda(prazoSafra);
              document.getElementById("prazo").value = prazoSafra.toFixed(2);

              // Atualiza os preços mensais imediatamente
              calcularPrecosMensais(valorAVista);
            })
            .catch((error) => {
              console.error("Erro:", error);
              document.getElementById("valorDisplay").textContent = "Erro ao carregar";
              document.getElementById("prazoDisplay").textContent = "Erro ao carregar";
            });
        } else {
          // Limpa os campos se nenhum produto estiver selecionado
          document.getElementById("valorDisplay").textContent = "";
          document.getElementById("prazoDisplay").textContent = "";
          document.getElementById("valor").value = "";
          document.getElementById("prazo").value = "";
        }
      });

      // Função para calcular os preços mensais
      function calcularPrecosMensais(valorAVista) {
        const meses = ['setembro', 'outubro', 'novembro', 'dezembro', 'janeiro', 'fevereiro', 'marco', 'abril', 'maio', 'junho', 'julho', 'agosto'];

        let valorAtual = valorAVista;

        meses.forEach((mes) => {
          const span = document.getElementById(mes);
          // Atualiza o preço mensal apenas se ainda não estiver definido
          span.setAttribute('data-preco', valorAtual.toFixed(2));
          span.textContent = formatarMoeda(valorAtual);
          valorAtual *= 1.015; // Aumenta 1.5% para o próximo mês
        });
      }

      // Atualiza o valor à vista com o mês selecionado ao carregar a página
      window.onload = function() {
        const mesInicial = "<?php echo $mesAtual; ?>";
        const valorMensal = parseFloat(document.getElementById(mesInicial).getAttribute('data-preco')) || 0;
        document.getElementById("valorDisplay").textContent = formatarMoeda(valorMensal);
        document.getElementById("valor").value = valorMensal.toFixed(2);
      };
    </script>
  </form>
</body>

</html>