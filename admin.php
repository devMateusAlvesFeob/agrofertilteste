<?php
include 'conexao.php';

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mesSelecionado = $_POST['mesSelecionado'];

    // Salvar o mês selecionado no banco de dados
    $sql = "UPDATE configuracoes SET mesSelecionado = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $mesSelecionado);
    $stmt->execute();
}

// Buscar o mês selecionado
$sql = "SELECT mesSelecionado FROM configuracoes LIMIT 1";
$result = $conn->query($sql);

// Verificar se a consulta retornou um resultado
if ($result && $result->num_rows > 0) {
    $mesAtual = $result->fetch_assoc()['mesSelecionado'];
} else {
    $mesAtual = 'setembro'; // Define um mês padrão se não houver resultado
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Administração - Seleção de Mês</title>
    <link rel="stylesheet" href="Styles.css/mesref.css" />
</head>

<body>
    <div class="cabecalho">
        <h1>Mês de Referencia</h1>
        <p>O mes selecionado sera utilizado como base no PRECO A VISTA</p>
    </div>

    <form class="formulario1" method="post">
        <select name="mesSelecionado" required>
            <option value="setembro" <?php echo $mesAtual === 'setembro' ? 'selected' : ''; ?>>Setembro</option>
            <option value="outubro" <?php echo $mesAtual === 'outubro' ? 'selected' : ''; ?>>Outubro</option>
            <option value="novembro" <?php echo $mesAtual === 'novembro' ? 'selected' : ''; ?>>Novembro</option>
            <option value="dezembro" <?php echo $mesAtual === 'dezembro' ? 'selected' : ''; ?>>Dezembro</option>
            <option value="janeiro" <?php echo $mesAtual === 'janeiro' ? 'selected' : ''; ?>>Janeiro</option>
            <option value="fevereiro" <?php echo $mesAtual === 'fevereiro' ? 'selected' : ''; ?>>Fevereiro</option>
            <option value="marco" <?php echo $mesAtual === 'marco' ? 'selected' : ''; ?>>Março</option>
            <option value="abril" <?php echo $mesAtual === 'abril' ? 'selected' : ''; ?>>Abril</option>
            <option value="maio" <?php echo $mesAtual === 'maio' ? 'selected' : ''; ?>>Maio</option>
            <option value="junho" <?php echo $mesAtual === 'junho' ? 'selected' : ''; ?>>Junho</option>
            <option value="julho" <?php echo $mesAtual === 'julho' ? 'selected' : ''; ?>>Julho</option>
            <option value="agosto" <?php echo $mesAtual === 'agosto' ? 'selected' : ''; ?>>Agosto</option>
        </select>
        <button class="btn" type="submit">Salvar</button>
        <A href="/menu-admin.php">Retornar ao menu anterior</A>
    </form>
</body>

</html>