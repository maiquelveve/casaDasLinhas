<?php
    require_once DIR_CONEXAOBD.'conexaoPDO.php';

    class produtosCodigoBarrasDao
    {
        private $conexaoBD;

        public function __construct() {
            $this->conexaoBD = ConexaoPDO::getInstance();
        }

        public function cadastrar($codigoBarra, $produto_id) {  

            $sql = "INSERT INTO codigos_barras_produtos (st_codigo_barra, produto_id) VALUES (:st_codigo_barra, :produto_id)";
            
            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->bindValue(":st_codigo_barra", "$codigoBarra", PDO::PARAM_STR);
                $statement->bindValue(":produto_id", "$produto_id", PDO::PARAM_INT);
                $statement->execute();
                return $this->conexaoBD->lastInsertId();

            } catch (PDOException $e){
                throw new Exception($e);
            }
        }

        public function excluirTodosCodigosBarraProduto($produto_id) {
            $sql = "DELETE FROM codigos_barras_produtos WHERE produto_id = :produto_id";

            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->bindValue(":produto_id", $produto_id, PDO::PARAM_INT);
                $statement->execute();
                return 1;

            } catch (Exception $e) {
                throw new Exception($e);
            }
        }

        public function buscarCodigosBarrasProduto($produto_id) {
            $sql = "SELECT id, st_codigo_barra, produto_id FROM codigos_barras_produtos WHERE produto_id = :produto_id";

            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->bindValue(":produto_id", $produto_id, PDO::PARAM_INT);
                $statement->execute();
                return $statement->fetchAll(PDO::FETCH_ASSOC);

            } catch (Exception $e) {
                throw new Exception($e);
            }
        }

        public function buscarProutoPeloCodigoBarras($st_codigo_barras) {
            try {
                $sql = "SELECT produto_id FROM codigos_barras_produtos WHERE st_codigo_barra = :st_codigo_barra";

                $statement = $this->conexaoBD->prepare($sql);
                $statement->bindValue(':st_codigo_barra', $st_codigo_barras, PDO::PARAM_STR);
                $statement->execute();

                return $statement->fetch(PDO::FETCH_ASSOC);

            } catch (Exception $e) {
                throw new Exception($e);
            }
        }
    }
?>