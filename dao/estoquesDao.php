<?php

require_once DIR_CONEXAOBD . 'conexaoPDO.php';

class estoquesDao {

    private $conexaoBD;

    public function __construct() {
        $this->conexaoBD = ConexaoPDO::getInstance();
    }

    public function cadastrar($item) {
        $sql = "INSERT INTO estoques (produto_id, nr_quantidade) VALUES(:produto_id, :nr_quantidade)";

        try {
            $statement = $this->conexaoBD->prepare($sql);
            $statement->bindValue(':produto_id', $item['produto_id'], PDO::PARAM_INT);
            $statement->bindValue(':nr_quantidade', $item['nr_quantidade'], PDO::PARAM_INT);
            $statement->execute();
            return 1;
        } catch (PDOException $e) {
            throw new Exception($e);
        }
    }

    public function editar($item, $produto_id) {
        $sql = "UPDATE estoques SET produto_id = :produto_id, nr_quantidade = :nr_quantidade WHERE produto_id = :produto_id";

        try {
            $statement = $this->conexaoBD->prepare($sql);
            $statement->bindValue(":produto_id", $item['produto_id'], PDO::PARAM_INT);
            $statement->bindValue(":nr_quantidade", $item['nr_quantidade'], PDO::PARAM_INT);
            $statement->execute();
            return 1;
        } catch (PDOException $e) {

            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
            return 0;
        }
    }

    public function verificaItemEstoque($item) {
        try {
            $sql = "SELECT id, produto_id, nr_quantidade FROM estoques WHERE produto_id = :produto_id";

            $statement = $this->conexaoBD->prepare($sql);
            $statement->bindValue(":produto_id", $item['produto_id'], PDO::PARAM_INT);
            $statement->execute();

            $produtoEstoque = $statement->fetch(PDO::FETCH_ASSOC);

            return $produtoEstoque;    
        } catch (Exception $e) {
            throw new Exception($e); 
        }
    }

    public function buscarItemDoEstoque($produto_id) {
        try {
            $sql = "SELECT id, produto_id, nr_quantidade FROM estoques WHERE produto_id = :produto_id";
            $statement = $this->conexaoBD->prepare($sql);
            $statement->bindValue(":produto_id", $produto_id, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);    
        } catch (Exception $e) {
           throw new Exception($e); 
        }
    }

}

?>