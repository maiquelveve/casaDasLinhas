<?php
	require_once DIR_CONEXAOBD."conexaoPDO.php";

	class VendasProdutosDao {

		private $conexaoBD;

		public function __construct() {
			$this->conexaoBD = ConexaoPDO::getInstance();
		}

		public function cadastrar($itensVenda, $venda_id) {
			$sql = "INSERT INTO vendas_produtos (produto_id, venda_id, nr_quantidade_venda, vl_item_venda) VALUES (:produto_id, :venda_id, :nr_quantidade_venda, :vl_item_venda)";

			foreach ($itensVenda as $item) {
				try {
					$statement = $this->conexaoBD->prepare($sql);
					$statement->bindValue(":produto_id", $item['produto_id'], PDO::PARAM_INT);
					$statement->bindValue(":venda_id", $venda_id, PDO::PARAM_INT);
					$statement->bindValue(":nr_quantidade_venda", $item['nr_quantidade_venda'], PDO::PARAM_INT);
					$statement->bindValue(":vl_item_venda", $item['vl_item_venda'], PDO::PARAM_STR);
					$statement->execute();
				} catch(PDOException $e) {
					throw new Exception($e);
				}
			}
		}

        public function excluir($itensVenda, $venda_id) {
            $sql = "DELETE FROM vendas_produtos WHERE venda_id = :venda_id";

            try {
              $statement = $this->conexaoBD->prepare($sql);
              $statement->bindValue(":venda_id", $venda_id, PDO::PARAM_INT);
              $statement->execute();
              return 1;

            } catch(PDOException $e) {
                throw new Exception($e);
            }
        }

		public function buscarItensVenda($venda_id) {
            $sql = "SELECT P.id, P.st_produto, P.vl_valor_venda,
                           M.st_marca,
                           E.nr_quantidade,
                           VP.nr_quantidade_venda, VP.vl_item_venda, VP.venda_id
                    FROM vendas_produtos VP
                        INNER JOIN produtos P ON VP.produto_id = P.id
                        INNER JOIN estoques E ON P.id = E.produto_id
                        INNER JOIN marcas M ON M.id = P.marca_id
                    WHERE venda_id = :venda_id";

			try{
				$statement = $this->conexaoBD->prepare($sql);
				$statement->bindValue(":venda_id", $venda_id, PDO::PARAM_INT);
				$statement->execute();
				return $statement->fetchAll(PDO::FETCH_ASSOC);

			} catch(PDOException $e) {
				throw new Exception($e);
			}
		}
	}

?>