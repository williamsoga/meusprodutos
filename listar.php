<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pessoas e Produtos</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        a.button {
            display: inline-block;
            padding: 5px 10px;
            margin: 2px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        a.button.delete {
            background-color: #f44336;
        }
        a.button:hover {
            opacity: 0.8;
        }
        h2 {
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <header>
        <h1 style="text-align:center;">Lista de Pessoas e Produtos</h1>
    </header>

    <section>
        <?php 
        require_once 'conexao.php';
        require_once 'pessoa.php';
        require_once 'produto.php';

        $database = new BancoDeDados();
        $db = $database->obterConexao();

        if ($db === null) {
            die("<p style='color:red; text-align:center;'>Erro: não foi possível conectar ao banco de dados.</p>");
        }

        // ---- LISTAR PESSOAS ----
        echo "<h2>Pessoas</h2>";
        $pessoa = new Pessoa($db);
        $stmtPessoas = $pessoa->ler();
        if ($stmtPessoas->rowCount() > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Nome</th><th>Idade</th><th>Ações</th></tr>";
            while ($linha = $stmtPessoas->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>{$linha['id']}</td>";
                echo "<td>{$linha['nome']}</td>";
                echo "<td>{$linha['idade']}</td>";
                echo "<td>
                        <a class='button' href='editar_pessoa.php?id={$linha['id']}'>Editar</a>
                        <a class='button delete' href='excluir_pessoa.php?id={$linha['id']}' onclick=\"return confirm('Tem certeza que deseja excluir esta pessoa?');\">Excluir</a>
                      </td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='text-align:center; color:blue;'>Nenhuma pessoa cadastrada.</p>";
        }

        // ---- LISTAR PRODUTOS ----
        echo "<h2>Produtos</h2>";
        $produto = new Produto($db);
        $stmtProdutos = $produto->ler();
        if ($stmtProdutos->rowCount() > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Nome</th><th>Preço</th><th>Ações</th></tr>";
            while ($linha = $stmtProdutos->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>{$linha['id']}</td>";
                echo "<td>{$linha['nome']}</td>";
                echo "<td>R$ " . number_format($linha['preco'], 2, ',', '.') . "</td>";
                echo "<td>
                        <a class='button' href='editar_produto.php?id={$linha['id']}'>Editar</a>
                        <a class='button delete' href='excluir_produto.php?id={$linha['id']}' onclick=\"return confirm('Tem certeza que deseja excluir este produto?');\">Excluir</a>
                      </td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='text-align:center; color:blue;'>Nenhum produto cadastrado.</p>";
        }
        ?>
    </section>

    <div style="text-align:center; margin-top:20px;">
        <form action="cadastrar_pessoa.php" method="get" style="display:inline;">
            <input type="submit" value="Cadastrar Pessoa">
        </form>
        <form action="cadastrar_produto.php" method="get" style="display:inline; margin-left:10px;">
            <input type="submit" value="Cadastrar Produto">
        </form>
    </div>
</body>
</html>
