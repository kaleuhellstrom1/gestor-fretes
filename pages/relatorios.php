<?php
require_once "../includes/conexao.php";

$data = $_GET["data"] ?? "";

$sql = "SELECT
    f.id,
    f.data_frete,
    f.status,
    p.nome AS produto,
    o.logradouro AS origem,
    o.cidade AS cidade_origem,
    d.logradouro AS destino,
    d.cidade AS cidade_destino,
    t.nome AS transportador
FROM fretes f
INNER JOIN produtos p ON f.produto_id = p.id
INNER JOIN enderecos o ON f.endereco_origem_id = o.id
INNER JOIN enderecos d ON f.endereco_destino_id = d.id
INNER JOIN transportadores t ON f.transportador_id = t.id";

if ($data != "") {
    $sql .= " WHERE f.data_frete = :data";
}

$sql .= " ORDER BY f.data_frete DESC";

$stmt = $pdo->prepare($sql);

if ($data != "") {
    $stmt->bindValue(":data", $data);
}

$stmt->execute();
$fretes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Exportar relatório em CSV
if (isset($_GET["exportar"])) {

    header("Content-Type: text/csv; charset=UTF-8");
    header("Content-Disposition: attachment; filename=relatorio_fretes.csv");

    echo "\xEF\xBB\xBF";

    $arquivo = fopen("php://output", "w");

    fputcsv($arquivo, [
        "ID",
        "Data",
        "Produto",
        "Origem",
        "Destino",
        "Transportador",
        "Status"
    ], ";");

    foreach ($fretes as $frete) {
        fputcsv($arquivo, [
            $frete["id"],
            $frete["data_frete"],
            $frete["produto"],
            $frete["origem"] . " - " . $frete["cidade_origem"],
            $frete["destino"] . " - " . $frete["cidade_destino"],
            $frete["transportador"],
            $frete["status"]
        ], ";");
    }

    fclose($arquivo);
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios - LogiControl</title>
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
            <a href="fretes.php">Fretes</a>
            <a href="relatorios.php" class="active">Relatórios</a>
        </nav>
    </aside>

    <main class="main">

        <header class="header">
            <div>
                <h1>Relatórios de Fretes</h1>
                <p>Consulte e baixe os fretes realizados por dia.</p>
            </div>
        </header>

        <section class="table-box">

            <h2>Filtrar por data</h2>

            <form method="GET">
                <label>Data do frete</label><br>

                <input
                    type="date"
                    name="data"
                    value="<?php echo htmlspecialchars($data); ?>"
                >

                <br><br>

                <button type="submit">Consultar</button>

                <a href="relatorios.php">Limpar filtro</a>
            </form>

            <br>

            <a href="?<?php echo htmlspecialchars(http_build_query([
                "data" => $data,
                "exportar" => 1
            ])); ?>">
                <button type="button">Baixar relatório CSV</button>
            </a>

        </section>

        <section class="table-box">

            <h2>Fretes encontrados</h2>

            <p>Total de fretes: <?php echo count($fretes); ?></p>

            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Produto</th>
                        <th>Origem</th>
                        <th>Destino</th>
                        <th>Transportador</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($fretes as $frete): ?>
                    <tr>
                        <td><?php echo $frete["id"]; ?></td>
                        <td><?php echo date("d/m/Y", strtotime($frete["data_frete"])); ?></td>
                        <td><?php echo htmlspecialchars($frete["produto"]); ?></td>
                        <td><?php echo htmlspecialchars($frete["origem"] . " - " . $frete["cidade_origem"]); ?></td>
                        <td><?php echo htmlspecialchars($frete["destino"] . " - " . $frete["cidade_destino"]); ?></td>
                        <td><?php echo htmlspecialchars($frete["transportador"]); ?></td>
                        <td><?php echo htmlspecialchars($frete["status"]); ?></td>
                    </tr>
                    <?php endforeach; ?>

                    <?php if (count($fretes) == 0): ?>
                    <tr>
                        <td colspan="7">Nenhum frete encontrado.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </section>

    </main>

</div>

</body>
</html>