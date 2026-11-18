<?php
require_once "../includes/conexao.php";

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        $sql = "INSERT INTO produtos
        (nome, descricao, peso, comprimento, largura, altura, valor)
        VALUES
        (:nome, :descricao, :peso, :comprimento, :largura, :altura, :valor)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ":nome" => $_POST["nome"],
            ":descricao" => $_POST["descricao"],
            ":peso" => $_POST["peso"],
            ":comprimento" => $_POST["comprimento"],
            ":largura" => $_POST["largura"],
            ":altura" => $_POST["altura"],
            ":valor" => $_POST["valor"]
        ]);

        $mensagem = "Produto cadastrado e salvo com sucesso!";

    } catch (PDOException $e) {
        $mensagem = "Erro ao cadastrar produto.";
    }
}
?>
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos - LogiControl</title>

    <link rel="stylesheet" href="../assets/assets/css/style.css">
</head>
<body>

<div class="container">

    <aside class="sidebar">
        <div class="logo">LogiControl</div>

        <nav class="menu">
            <a href="../index.php">Início</a>
            <a href="produtos.php" class="active">Produtos</a>
            <a href="enderecos.php">Endereços</a>
            <a href="transportadores.php">Transportadores</a>
            <a href="fretes.php">Fretes</a>
            <a href="relatorios.php">Relatórios</a>
        </nav>
    </aside>

    <main class="main">

        <header class="header">
            <div>
                <h1>Cadastro de Produtos</h1>
                <p>Cadastre os produtos que serão transportados.</p>
            </div>
        </header>

        <?php if ($mensagem != ""): ?>
            <div style="background:#d1fae5; padding:15px; margin-bottom:20px; border-radius:8px; color:#065f46;">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <section class="table-box">

            <h2>Informações do produto</h2>

            <form method="POST">

                <label>Nome do produto</label><br>
                <input type="text" name="nome" required><br><br>

                <label>Descrição</label><br>
                <textarea name="descricao" rows="3"></textarea><br><br>

                <label>Peso (kg)</label><br>
                <input type="number" name="peso" step="0.01" min="0.01" required><br><br>

                <label>Comprimento (cm)</label><br>
                <input type="number" name="comprimento" step="0.01" min="0.01" required><br><br>

                <label>Largura (cm)</label><br>
                <input type="number" name="largura" step="0.01" min="0.01" required><br><br>

                <label>Altura (cm)</label><br>
                <input type="number" name="altura" step="0.01" min="0.01" required><br><br>

                <label>Valor do produto (R$)</label><br>
                <input type="number" name="valor" step="0.01" min="0" required><br><br>

                <button type="submit">Cadastrar produto</button>

            </form>

        </section>

    </main>

</div>

</body>
</html>