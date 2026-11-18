<?php
$nomeSistema = "LogiControl";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogiControl - Gestão de Fretes</title>

    <link rel="stylesheet" href="assets/assets/css/style.css">
</head>
<body>

<div class="container">

    <aside class="sidebar">
        <div class="logo">LogiControl</div>

        <nav class="menu">
            <a href="index.php" class="active">Início</a>
            <a href="pages/produtos.php">Produtos</a>
            <a href="pages/enderecos.php">Endereços</a>
            <a href="pages/transportadores.php">Transportadores</a>
            <a href="pages/fretes.php">Fretes</a>
            <a href="pages/relatorios.php">Relatórios</a>
        </nav>
    </aside>

    <main class="main">

        <header class="header">
            <div>
                <h1>Painel inicial</h1>
                <p>Bem-vindo ao sistema de gestão de fretes.</p>
            </div>
        </header>

        <section class="cards">

            <div class="card">
                <p>Produtos cadastrados</p>
                <h2>0</h2>
            </div>

            <div class="card">
                <p>Transportadores</p>
                <h2>0</h2>
            </div>

            <div class="card">
                <p>Fretes realizados</p>
                <h2>0</h2>
            </div>

        </section>

        <section class="table-box">
            <h2>Fretes recentes</h2>

            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Transportador</th>
                        <th>Origem</th>
                        <th>Destino</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td colspan="5">Nenhum frete cadastrado.</td>
                    </tr>
                </tbody>
            </table>
        </section>

    </main>

</div>

</body>
</html>