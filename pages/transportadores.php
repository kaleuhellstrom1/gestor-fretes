
<?php
require_once "../includes/conexao.php";

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $sql = "INSERT INTO transportadores
        (nome, documento, telefone, email, cidade, estado)
        VALUES
        (:nome, :documento, :telefone, :email, :cidade, :estado)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ":nome" => trim($_POST["nome"]),
            ":documento" => trim($_POST["documento"]),
            ":telefone" => trim($_POST["telefone"]),
            ":email" => trim($_POST["email"]),
            ":cidade" => trim($_POST["cidade"]),
            ":estado" => strtoupper(trim($_POST["estado"]))
        ]);

        $mensagem = "Transportador cadastrado com sucesso!";

    } catch (PDOException $e) {
        $mensagem = "Erro ao cadastrar transportador.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transportadores - LogiControl</title>
    <link rel="stylesheet" href="../assets/assets/css/style.css">
</head>
<body>

<div class="container">

    <aside class="sidebar">
        <div class="logo">LogiControl</div>

        <nav class="menu">
            <a href="../index.php">Início</a>
            <a href="produtos.php">Produtos</a>
            <a href="enderecos.php">Endereços</a>
            <a href="transportadores.php" class="active">Transportadores</a>
            <a href="fretes.php">Fretes</a>
            <a href="relatorios.php">Relatórios</a>
        </nav>
    </aside>

    <main class="main">

        <header class="header">
            <div>
                <h1>Cadastro de Transportadores</h1>
                <p>Cadastre os responsáveis pelo transporte dos produtos.</p>
            </div>
        </header>

        <?php if ($mensagem != ""): ?>
            <div style="background:#d1fae5; padding:15px; margin-bottom:20px; border-radius:8px; color:#065f46;">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <section class="table-box">

            <h2>Informações do transportador</h2>

            <form method="POST">

                <label>Nome ou razão social</label><br>
                <input type="text" name="nome" required><br><br>

                <label>CPF ou CNPJ</label><br>
                <input type="text" name="documento" required><br><br>

                <label>Telefone</label><br>
                <input type="text" name="telefone" required><br><br>

                <label>E-mail</label><br>
                <input type="email" name="email"><br><br>

                <label>Cidade</label><br>
                <input type="text" name="cidade" required><br><br>

                <label>Estado (UF)</label><br>
                <input type="text" name="estado" maxlength="2" placeholder="PR" required><br><br>

                <button type="submit">Cadastrar transportador</button>

            </form>

        </section>

    </main>

</div>

</body>
</html>
