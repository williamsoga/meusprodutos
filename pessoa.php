<?php 
class Pessoa {
    private $conexao;
    private $nome_tabela = "pessoas";

    public $id;
    public $nome;
    public $idade;

    public function __construct($db) {
        $this->conexao = $db;
    }

    public function criar() {
        $query = "INSERT INTO " . $this->nome_tabela . " (nome, idade) VALUES (:nome, :idade)";
        $stmt = $this->conexao->prepare($query);

        // Limpa dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->idade = htmlspecialchars(strip_tags($this->idade));

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":idade", $this->idade);

        return $stmt->execute();
    }

    public function ler() {
        $query = "SELECT id, nome, idade FROM " . $this->nome_tabela . " ORDER BY nome ASC";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt;
   
    }



    public function atualizar() {
        $query = "UPDATE " . $this->nome_tabela . " 
                  SET nome = :nome, idade = :idade 
                  WHERE id = :id";
    
        $stmt = $this->conexao->prepare($query);
    
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->idade = htmlspecialchars(strip_tags($this->idade));
        $this->id = htmlspecialchars(strip_tags($this->id));
    
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":idade", $this->idade);
        $stmt->bindParam(":id", $this->id);
    
        return $stmt->execute();
    }
    
    public function buscarPorId($id) {
        $query = "SELECT * FROM " . $this->nome_tabela . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function excluir($id) {
        $query = "DELETE FROM " . $this->nome_tabela . " WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
}



?>
