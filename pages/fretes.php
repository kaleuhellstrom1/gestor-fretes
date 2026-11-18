<?php
require_once "../includes/conexao.php";

$mensagem = "";

$produtos = $pdo->query(
    "SELECT id, nome FROM produtos ORDER BY nome"
)->fetchAll(PDO::FETCH_ASSOC);

$origens = $pdo->query(
    "SELECT id, logradouro, numero, cidade, estado
     FROM enderecos WHERE tipo = 'Origem'
     ORDER BY cidade"
)->fetchAll(PDO::FETCH_ASSOC);

$destinos = $pdo->query(
    "SELECT id, logradouro, numero, cidade, estado
     FROM enderecos WHERE tipo = 'Destino'
     ORDER BY cidade"
)->fetchAll(PDO::FETCH_ASSOC);

$transportadores = $pdo->query(
    "SELECT id, nome FROM transportadores ORDER BY nome"
)->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $sql = "INSERT INTO fretes
        (produto_id, endereco_origem_id, endereco_destino_id,
         transportador_id, data_frete, observacoes)
        VALUES
        (:produto, :origem, :destino, :transportador, :data, :observacoes)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ":produto" => $_POST["produto"],
            ":origem" => $_POST["origem"],
            ":destino" => $_POST["destino"],
            ":transportador" => $_POST["transportador"],
            ":data" => $_POST["data_frete"],
            ":observacoes" => $_POST["observacoes"]
        ]);

        $mensagem = "Frete gerado e salvo com sucesso!";

    } catch (PDOException $e) {
        $mensagem = "Não foi possível gerar o frete. Confira os cadastros selecionados.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geração de Fretes - LogiControl</title>
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
            <a href="transportadores.php">Transportadores</a>
            <a href="fretes.php" class="active">Fretes</a>
            <a href="relatorios.php">Relatórios</a>
        </nav>
    </aside>

    <main class="main">

        <header class="header">
            <div>
                <h1>Geração de Fretes</h1>
                <p>Relacione produtos, endereços e transportadores.</p>
            </div>
        </header>

        <?php if ($mensagem != ""): ?>
            <div style="background:#d1fae5; padding:15px; margin-bottom:20px; border-radius:8px; color:#065f46;">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <section class="table-box">

            <h2>Informações do frete</h2>

            <form method="POST">

                <label>Produto</label><br>
                <select name="produto" required>
                    <option value="">Selecione um produto</option>
                    <?php foreach ($produtos as $produto): ?>
                        <option value="<?php echo $produto["id"]; ?>">
                            <?php echo htmlspecialchars($produto["nome"]); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br><br>

                <label>Endereço de origem</label><br>
                <select name="origem" required>
                    <option value="">Selecione a origem</option>
                    <?php foreach ($origens as $endereco): ?>
                        <option value="<?php echo $endereco["id"]; ?>">
                            <?php echo htmlspecialchars(
                                $endereco["logradouro"] . ", " .
                                $endereco["numero"] . " - " .
                                $endereco["cidade"] . "/" .
                                $endereco["estado"]
                            ); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br><br>

                <label>Endereço de destino</label><br>
                <select name="destino" required>
                    <option value="">Selecione o destino</option>
                    <?php foreach ($destinos as $endereco): ?>
                        <option value="<?php echo $endereco["id"]; ?>">
                            <?php echo htmlspecialchars(
                                $endereco["logradouro"] . ", " .
                                $endereco["numero"] . " - " .
                                $endereco["cidade"] . "/" .
                                $endereco["estado"]
                            ); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br><br>

                <label>Transportador</label><br>
                <select name="transportador" required>
                    <option value="">Selecione o transportador</option>
                    <?php foreach ($transportadores as $transportador): ?>
                        <option value="<?php echo $transportador["id"]; ?>">
                            <?php echo htmlspecialchars($transportador["nome"]); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br><br>

                <label>Data do frete</label><br>
                <input type="date" name="data_frete" required><br><br>

                <label>Observações</label><br>
                <textarea name="observacoes" rows="3"></textarea><br><br>

                <button type="submit">Gerar frete</button>

            </form>

        </section>

    </main>

</div>

</body>
</html>