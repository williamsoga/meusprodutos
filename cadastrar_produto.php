<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produto</title>
</head>
<body>
    <div class="container">
        <header>
            <h1>Cadastro de Produto</h1>
        </header>

        <section>
            <?php
            require_once 'conexao.php';
            require_once 'produto.php';

            $mensagem = '';
            $cadastroSucesso = false;

            $database = new BancoDeDados();
            $db = $database->obterConexao();

            if ($db === null) {
                $mensagem = "Erro: não foi possível conectar ao banco de dados";
            } else {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $produto = new Produto($db);
                    $produto->nome = $_POST['nome'] ?? '';
                    $produto->preco = $_POST['preco'] ?? '';
                    

                    if ($produto->criar()) {
                        $mensagem = "Produto '{$produto->nome}' cadastrado com sucesso!";
                        $cadastroSucesso = true;
                    } else {
                        $mensagem = "Falha ao cadastrar o produto.";
                    }
                }
            }
            ?>
            <form action="" method="post" id="formCadastroProduto">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
                <label for="preco">Preço:</label>
                <input type="number" id="preco" name="preco" step="0.01" required>
                <input type="submit" value="Cadastrar">
            </form>

            <form action="listar_produtos.php" method="get" style="margin-top:10px;">
                <input type="submit" value="Ver Lista de Produtos">
            </form>
        </section>
    </div>

    <script>
        const mensagemDoPHP = "<?php echo $mensagem; ?>";
        const cadastroFoiSucesso = <?php echo json_encode($cadastroSucesso); ?>;

        if (mensagemDoPHP) {
            alert(mensagemDoPHP);

            if (cadastroFoiSucesso) {
                document.getElementById('nome').value = '';
                document.getElementById('preco').value = '';
                document.getElementById('nome').focus();
            }
        }
    </script>
</body>
</html>
