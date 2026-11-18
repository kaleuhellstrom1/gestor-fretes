<?php
require_once "../includes/conexao.php";

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $sql = "INSERT INTO enderecos
        (tipo, cep, logradouro, numero, complemento, bairro, cidade, estado)
        VALUES
        (:tipo, :cep, :logradouro, :numero, :complemento, :bairro, :cidade, :estado)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ":tipo" => $_POST["tipo"],
            ":cep" => $_POST["cep"],
            ":logradouro" => $_POST["logradouro"],
            ":numero" => $_POST["numero"],
            ":complemento" => $_POST["complemento"],
            ":bairro" => $_POST["bairro"],
            ":cidade" => $_POST["cidade"],
            ":estado" => strtoupper($_POST["estado"])
        ]);

        $mensagem = "Endereço cadastrado com sucesso!";

    } catch (PDOException $e) {
        $mensagem = "Erro ao cadastrar endereço.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Endereços - LogiControl</title>
    <link rel="stylesheet" href="../assets/assets/css/style.css">
</head>
<body>

<div class="container">

    <aside class="sidebar">
        <div class="logo">LogiControl</div>

        <nav class="menu">
            <a href="../index.php">Início</a>
            <a href="produtos.php">Produtos</a>
            <a href="enderecos.php" class="active">Endereços</a>
            <a href="transportadores.php">Transportadores</a>
            <a href="fretes.php">Fretes</a>
            <a href="relatorios.php">Relatórios</a>
        </nav>
    </aside>

    <main class="main">

        <header class="header">
            <div>
                <h1>Cadastro de Endereços</h1>
                <p>Cadastre os locais de origem e destino dos fretes.</p>
            </div>
        </header>

        <?php if ($mensagem != ""): ?>
            <div style="background:#d1fae5; padding:15px; margin-bottom:20px; border-radius:8px; color:#065f46;">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <section class="table-box">

            <h2>Informações do endereço</h2>

            <form method="POST">

                <label>Tipo de endereço</label><br>
                <select name="tipo" required>
                    <option value="">Selecione</option>
                    <option value="Origem">Origem</option>
                    <option value="Destino">Destino</option>
                </select><br><br>

                <label>CEP</label><br>
                <input type="text" name="cep" maxlength="10" required><br><br>

                <label>Logradouro</label><br>
                <input type="text" name="logradouro" required><br><br>

                <label>Número</label><br>
                <input type="text" name="numero" required><br><br>

                <label>Complemento</label><br>
                <input type="text" name="complemento"><br><br>

                <label>Bairro</label><br>
                <input type="text" name="bairro" required><br><br>

                <label>Cidade</label><br>
                <input type="text" name="cidade" required><br><br>

                <label>Estado (UF)</label><br>
                <input type="text" name="estado" maxlength="2" placeholder="PR" required><br><br>

                <button type="submit">Cadastrar endereço</button>

            </form>

        </section>

    </main>

</div>

</body>
</html>