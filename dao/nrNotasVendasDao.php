<?php
    require_once DIR_CONEXAOBD.'conexaoPDO.php';

    class nrNotasVendasDao {

        private $conexaoPDO;

        public function __construct() {
            $this->conexaoPDO = ConexaoPDO::getInstance();
        }

        public function cadastrar($numeroNotaVenda, $venda_id) {
            $sql = "INSERT INTO nr_notas_vendas (nr_nota, venda_id) VALUES (:nr_nota, :venda_id)";

            try {
                $statement = $this->conexaoPDO->prepare($sql);
                $statement->bindValue(":nr_nota", $numeroNotaVenda, PDO::PARAM_INT);
                $statement->bindValue(":venda_id", $venda_id, PDO::PARAM_INT);
                $statement->execute();
                return 1;

            } catch (Exception $e) {
                echo '<pre>';
                    print_r($e->getMessage());
                echo '<\pre>';
                return 0;
            }
        }

        public function buscarUltimoNumeroNotaFiscal() {
            try {
                $sql =  "SELECT nr_nota FROM nr_notas_vendas WHERE id = (SELECT max(id) FROM nr_notas_vendas)";

                $statement = $this->conexaoPDO->prepare($sql);
                $statement->execute();
                return $statement->fetch(PDO::FETCH_ASSOC);

            } catch (Exception $e) {
                echo '<pre>';
                    print_r($e->getMessage());
                echo '<\pre>';
                return 0;
            }
        }

        public function buscarNrNotaFiscalVenda($venda_id) {
            $sql = "
                SELECT nr_nota FROM nr_notas_vendas WHERE venda_id = :venda_id";

            try {
                $statement = $this->conexaoPDO->prepare($sql);
                $statement->bindValue(":venda_id", $venda_id, PDO::PARAM_INT);
                $statement->execute();
                return $statement->fetch(PDO::FETCH_ASSOC);

            } catch (Exception $e) {
                echo '<pre>';
                    print_r($e->getMessage());
                echo '<\pre>';
                return 0;
            }
        }
    }
?>

