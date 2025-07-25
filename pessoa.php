<?php 
class Pessoa{
    private $conexao;
    private $nome_tabela="pessoas";

    public $id;
    public $nome;
    public $idade;


    public function __construct($db)
    {
        $this->conexao=$db;
    }

    public function criar(){
        $query = "INSERT INTO ".$this-> nome_tabela . " SET nome=:nome, idade=:idade";
        $stmt = $this->conexao->prepare($query);

        $this->nome=htmlspecialchars(strip_tags($this->nome));
        $this->idade=htmlspecialchars(strip_tags($this->idade));

        $stmt->bindParam(":nome",$this->nome);
        $stmt->bindParam(":idade",$this->nome);

        if($stmt->execute()){
            return true ;
        }

        return false;
    }

    public function ler() {
        $query = "SELECT id,nome,idade FROM " . $this->nome_tabela . " ORDER BY nome ASC";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}




?>