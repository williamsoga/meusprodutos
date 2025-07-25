<?php
require_once 'conexao.php';
require_once 'produto.php';

$database = new BancoDeDados();
$db = $database->obterConexao();
$produto = new Produto($db);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $produto->id = $_POST['id'];
    $produto->nome = $_POST['nome'];
    $produto->preco = $_POST['preco'];

    if ($produto->atualizar()) {
        header("Location: listar.php?msg=Produto+atualizado+com+sucesso");
        exit();
    } else {
        echo "Erro ao atualizar o produto.";
    }
} elseif (isset($_GET['id'])) {
    $dados = $produto->buscarPorId($_GET['id']);
    if (!$dados) {
        die("Produto não encontrado.");
    }
} else {
    die("ID do produto não informado.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
</head>
<body>
    <h1>Editar Produto</h1>
    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($dados['id']); ?>">
        <label>Nome:</label>
        <input type="text" name="nome" value="<?php echo htmlspecialchars($dados['nome']); ?>" required><br>
        <label>Preço:</label>
        <input type="number" name="preco" value="<?php echo htmlspecialchars($dados['preco']); ?>" step="0.01" required><br>
        <input type="submit" value="Salvar Alterações">
    </form>
    <a href="listar.php">Voltar</a>
</body>
</html>
