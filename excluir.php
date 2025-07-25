<?php
require_once 'conexao.php';
require_once 'pessoa.php';

$database = new BancoDeDados();
$db = $database->obterConexao();

if ($db === null) {
    die("Erro: não foi possível conectar ao banco de dados.");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $pessoa = new Pessoa($db);

    if ($pessoa->excluir($id)) {
        header("Location: listar.php?msg=Pessoa+excluída+com+sucesso");
        exit();
    } else {
        echo "Erro ao excluir a pessoa.";
    }
} else {
    echo "ID não fornecido.";
}
?>