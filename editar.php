<?php
require_once 'conexao.php';
require_once 'pessoa.php';

$database = new BancoDeDados();
$db = $database->obterConexao();
$pessoa = new Pessoa($db);

$mensagem = '';
$dados = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $dados = $pessoa->buscarPorId($id);
    if (!$dados) {
        die("Pessoa não encontrada.");
    }
} else {
    die("ID não fornecido.");
}

// Se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pessoa->id = $_POST['id'];
    $pessoa->nome = $_POST['nome'];
    $pessoa->idade = $_POST['idade'];

    if ($pessoa->atualizar()) {
        $mensagem = "Pessoa atualizada com sucesso!";
        // Atualiza os dados para refletir a alteração
        $dados = $pessoa->buscarPorId($pessoa->id);
    } else {
        $mensagem = "Erro ao atualizar.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Pessoa</title>
</head>
<body>
    <h1>Editar Pessoa</h1>

    <?php if ($mensagem): ?>
        <p><?php echo $mensagem; ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="id" value="<?php echo $dados['id']; ?>">
        <label>Nome:
            <input type="text" name="nome" value="<?php echo htmlspecialchars($dados['nome']); ?>" required>
        </label><br><br>
        <label>Idade:
            <input type="number" name="idade" value="<?php echo htmlspecialchars($dados['idade']); ?>" required>
        </label><br><br>
        <input type="submit" value="Salvar Alterações">
    </form>

    <form action="listar.php" method="get" style="margin-top:10px;">
        <input type="submit" value="Voltar à Lista">
    </form>
</body>
</html>
