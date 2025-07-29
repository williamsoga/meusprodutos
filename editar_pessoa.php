<?php
require_once 'conexao.php';
require_once 'pessoa.php';

$database = new BancoDeDados();
$db = $database->obterConexao();

if ($db === null) {
    die("Erro: não foi possível conectar ao banco de dados.");
}

$pessoa = new Pessoa($db);

// Verifica se o ID foi passado pela URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID da pessoa não informado.");
}

$id = intval($_GET['id']);

// Busca os dados da pessoa
$stmt = $db->prepare("SELECT * FROM pessoas WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() !== 1) {
    die("Pessoa não encontrada.");
}

$dados = $stmt->fetch(PDO::FETCH_ASSOC);

// Atualização dos dados se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];

    $atualizar = $db->prepare("UPDATE pessoas SET nome = :nome, idade = :idade WHERE id = :id");
    $atualizar->bindParam(':nome', $nome);
    $atualizar->bindParam(':idade', $idade, PDO::PARAM_INT);
    $atualizar->bindParam(':id', $id, PDO::PARAM_INT);

    if ($atualizar->execute()) {
        echo "<p style='color:green; text-align:center;'>Pessoa atualizada com sucesso!</p>";
        echo "<p style='text-align:center;'><a href='listar.php'>Voltar para a lista</a></p>";
        exit;
    } else {
        echo "<p style='color:red; text-align:center;'>Erro ao atualizar pessoa.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Pessoa</title>
    <style>
        form {
            width: 300px;
            margin: 50px auto;
        }
        label, input {
            display: block;
            width: 100%;
            margin: 10px 0;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            opacity: 0.9;
        }
        a {
            text-align: center;
            display: block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Editar Pessoa</h2>
    <form method="post">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($dados['nome']) ?>" required>

        <label for="idade">Idade:</label>
        <input type="number" name="idade" id="idade" value="<?= htmlspecialchars($dados['idade']) ?>" required>

        <input type="submit" value="Salvar Alterações">
    </form>
    <a href="listar.php">Voltar para a lista</a>
</body>
</html>
