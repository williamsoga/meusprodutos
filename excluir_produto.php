<?php
require_once 'conexao.php';
require_once 'produto.php';

$database = new BancoDeDados();
$db = $database->obterConexao();
$produto = new Produto($db);

if (isset($_GET['id'])) {
    if ($produto->excluir($_GET['id'])) {
        header("Location: listar.php?msg=Produto+excluído+com+sucesso");
        exit();
    } else {
        echo "Erro ao excluir produto.";
    }
} else {
    echo "ID não informado.";
}
