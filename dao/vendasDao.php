<?php
    require_once DIR_CONEXAOBD.'conexaoPDO.php';

    class VendasDao {

        private $conexaoBD;

        public function __construct() {
            $this->conexaoBD = ConexaoPDO::getInstance();
        }

        public function pesquisar($where) {
            $sql = "SELECT * FROM vendas ". $where. " ORDER BY st_situacao desc";

            try {
                $statement =  $this->conexaoBD->prepare($sql);
                $statement->execute();
                return $statement->fetchAll(PDO::FETCH_ASSOC);

            } catch(PDOException $e) {
                throw new Exception($e);
            }
        }

        public function cadastrar($post) {
            $sql = "INSERT INTO vendas (dt_venda, vl_venda_valor_total) VALUES (:dt_venda, :vl_venda_valor_total)";

            try{
                $statement = $this->conexaoBD->prepare($sql);
                $statement->bindValue(":dt_venda", $post['dt_venda'], PDO::PARAM_STR);
                $statement->bindValue(":vl_venda_valor_total", $post['vl_venda_valor_total'], PDO::PARAM_STR);
                $statement->execute();
                return $this->conexaoBD->lastInsertId();

            } catch (PDOException $e) {
                throw new Exception($e);
            }
        }

        public function editar($post, $id) {
            $sql = "UPDATE vendas SET dt_venda = :dt_venda, vl_venda_valor_total = :vl_venda_valor_total WHERE id = :id";

            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->bindValue(":dt_venda", $post['dt_venda'], PDO::PARAM_STR);
                $statement->bindValue(":vl_venda_valor_total", $post['vl_venda_valor_total'], PDO::PARAM_STR);
                $statement->bindValue(":id", $id, PDO::PARAM_INT);
                $statement->execute();

                return 1;

            } catch (PDOException $e) {
                throw new Exception($e);
            }
        }

        public function confirmarVenda($venda_id, $post) {
            $sql = "UPDATE vendas SET st_situacao = :st_situacao, st_pagamento =  :st_pagamento WHERE id = :venda_id";
            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->bindValue(":st_situacao", "C", PDO::PARAM_STR);
                $statement->bindValue(":st_pagamento", $post['st_pagamento'], PDO::PARAM_STR);
                $statement->bindValue(":venda_id", $venda_id, PDO::PARAM_INT);
                $statement->execute();

                return $statement->rowCount();

            } catch(PDOException $e) {
                throw new Exception($e);
            }
        }

        public function cancelarVenda($venda_id) {
            $sql = "UPDATE vendas SET st_situacao = :st_situacao WHERE id = :venda_id";
            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->bindValue(":st_situacao", "CA", PDO::PARAM_STR);
                $statement->bindValue(":venda_id", $venda_id, PDO::PARAM_INT);
                $statement->execute();
                return $statement->rowCount();

            } catch(PDOException $e) {
                throw new Exception($e);
            }
        }


        public function quantidadeItensVenda($id) {
            $sql = "SELECT id FROM vendas_produtos WHERE venda_id = :venda_id";

            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->bindValue(":venda_id", $id, PDO::PARAM_INT);
                $statement->execute();
                return $statement->rowCount();

            } catch(PDOException $e) {
                throw new Exception($e);
            }
        }

        public function buscarVenda($id) {
            $sql = "SELECT * FROM vendas WHERE id = :id";

            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->bindValue(":id", $id, PDO::PARAM_INT);
                $statement->execute();
                return $statement->fetch(PDO::FETCH_ASSOC);

            } catch(PDOException $e) {
                throw new Exception($e);
            }
        }

        public function buscarTodasVendasHoje() {
            $sql = "SELECT * FROM vendas WHERE dt_venda = :dt_venda ORDER BY id desc";

            try {
                $statement =  $this->conexaoBD->prepare($sql);
                $statement->bindValue(":dt_venda", date('Y-m-d'), PDO::PARAM_STR);
                $statement->execute();
                return $statement->fetchAll(PDO::FETCH_ASSOC);

            } catch(PDOException $e) {
                throw new Exception($e);
            }
        }
    }
?>