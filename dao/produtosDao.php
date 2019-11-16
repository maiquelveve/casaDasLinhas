<?php
    require_once DIR_CONEXAOBD.'conexaoPDO.php';

    class ProdutosDao
    {
        private $conexaoBD;

        public function __construct() {
            $this->conexaoBD = ConexaoPDO::getInstance();
        }

        public function pesquisar($post) {
            $where = "WHERE 1=1";

            if(isset($post['st_produto']) && !empty($post['st_produto'])) {
                $where .= " AND P.st_produto LIKE '%". $post['st_produto']."%'";
            }

            if (isset($post['st_marca']) && !empty($post['st_marca'])) {
                $where .= " AND M.st_marca LIKE '%". $post['st_marca']. "%'";
            }

            if (isset($post['ch_codeBarra']) && $post['ch_codeBarra'] == 'S') {
                $where .= " AND EXISTS (SELECT 1 FROM codigos_barras_produtos C WHERE C.produto_id = P.id)";
            } 

            if(isset($post['ch_codeBarra']) && $post['ch_codeBarra'] == 'N') {
                $where .= " AND NOT EXISTS (SELECT 1 FROM codigos_barras_produtos C WHERE C.produto_id = P.id)";
            }

            if (isset($post['st_codigo_barra']) && !empty($post['st_codigo_barra'])) {
                $where .= " AND CBP.st_codigo_barra = '". $post['st_codigo_barra'] . "'";
            }

            $sql = "SELECT P.id, P.st_produto, P.vl_valor_venda, M.st_marca, T.st_descricao, E.nr_quantidade "
                    ."FROM produtos P"
                    .   " LEFT JOIN estoques E ON E.produto_id = P.id " 
                    .   " INNER JOIN marcas M ON P.marca_id = M.id "
                    .   " INNER JOIN tipos_produtos T ON P.tipo_produto_id = T.id "
                    .   " LEFT JOIN codigos_barras_produtos CBP ON CBP.produto_id = P.id "
                    . $where
                    ." ORDER BY P.id LIMIT 50";    
               
            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->execute();
                return $statement->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $e){
                throw new Exception($e);
            }
        }

        public function BuscarTodosProdutos() {

            $sql = "SELECT P.id, P.st_produto, P.vl_valor_venda, M.st_marca, T.st_descricao "
                 . "FROM produtos P "
                 . "INNER JOIN marcas M ON P.marca_id = M.id "
                 . "INNER JOIN tipos_produtos T ON P.tipo_produto_id = T.id ";

            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->execute();
                return $statement->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $e){
                echo '<pre>';
                    print_r($e->getMessage());
                echo '</pre>';
            }
        }

        public function buscarTodosProdutosParaVenda() {
            $sql ="SELECT P.id AS id, P.st_produto, P.st_tamanho, P.st_medida, P.tipo_produto_id, P.marca_id, P.vl_valor_venda, P.st_observacao,
                          T.id AS 'T_ID', T.st_descricao, T.ch_informacao_adicionais,
                          M.id AS 'M_ID', M.st_marca,
                          E.nr_quantidade,
                          I.st_cor, I.nr_codigo_cor, I.nr_numero_linha
                    FROM produtos P
                       	INNER JOIN estoques E ON P.id = E.produto_id
                        INNER JOIN tipos_produtos T ON P.tipo_produto_id = T.id
                        INNER JOIN marcas M ON P.marca_id = M.id
                        INNER JOIN produtos_informacoes_adicionais I ON P.id = I.produto_id";

            $statement = $this->conexaoBD->prepare($sql);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        public function buscarProdutoParaVenda($produto_id) {
            $sql ="SELECT P.id, P.st_produto, P.st_tamanho, P.st_medida, P.tipo_produto_id, P.marca_id, P.vl_valor_venda, P.st_observacao,
                          T.id AS 'T_ID', T.st_descricao, T.ch_informacao_adicionais,
                          M.id AS 'M_ID', M.st_marca,
                          E.nr_quantidade,
                          I.st_cor, I.nr_codigo_cor, I.nr_numero_linha
                    FROM produtos P
                       	INNER JOIN estoques E ON P.id = E.produto_id
                        INNER JOIN tipos_produtos T ON P.tipo_produto_id = T.id
                        INNER JOIN marcas M ON P.marca_id = M.id
                        INNER JOIN produtos_informacoes_adicionais I ON P.id = I.produto_id
                    WHERE P.id = :id";

            $statement = $this->conexaoBD->prepare($sql);
            $statement->bindValue(":id", $produto_id, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        }

        public function cadastrar($post) {
            $sql = "INSERT INTO produtos (st_produto, vl_valor_venda, marca_id, tipo_produto_id,st_observacao, st_tamanho, st_medida) "
                 . "VALUES (:st_produto, :vl_valor_venda, :marca_id, :tipo_produto_id, :st_observacao, :st_tamanho, :st_medida)";

            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->bindValue(':st_produto',$post['st_produto'] ,PDO::PARAM_STR);
                $statement->bindValue(':vl_valor_venda',$post['vl_valor_venda'] ,PDO::PARAM_STR);
                $statement->bindValue(':marca_id',$post['marca_id'] ,PDO::PARAM_INT);
                $statement->bindValue(':tipo_produto_id',$post['tipo_produto_id'] ,PDO::PARAM_INT);
                $statement->bindValue(':st_observacao',$post['st_observacao'] ,PDO::PARAM_STR);
                $statement->bindValue(':st_tamanho',$post['st_tamanho'] ,PDO::PARAM_STR);
                $statement->bindValue(':st_medida',$post['st_medida'] ,PDO::PARAM_STR);
                $statement->execute();

                return $this->conexaoBD->lastInsertId();

            } catch (PDOException $e) {
                throw new Exception($e);
            }
        }

        public function editar($post, $id) {
            $sql = "UPDATE produtos SET st_produto = :st_produto, vl_valor_venda = :vl_valor_venda, marca_id = :marca_id, tipo_produto_id = :tipo_produto_id ,st_observacao = :st_observacao, st_tamanho = :st_tamanho, st_medida = :st_medida WHERE id = :id";

            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->bindValue(':st_produto',$post['st_produto'], PDO::PARAM_STR);
                $statement->bindValue(':vl_valor_venda',$post['vl_valor_venda'], PDO::PARAM_STR);
                $statement->bindValue(':marca_id', $post['marca_id'], PDO::PARAM_INT);
                $statement->bindValue(':tipo_produto_id', $post['tipo_produto_id'], PDO::PARAM_INT);
                $statement->bindValue(':st_observacao', $post['st_observacao'], PDO::PARAM_STR);
                $statement->bindValue(':st_tamanho',$post['st_tamanho'] ,PDO::PARAM_STR);
                $statement->bindValue(':st_medida',$post['st_medida'] ,PDO::PARAM_STR);
                $statement->bindValue(':id', $id, PDO::PARAM_INT);
                $statement->execute();
                return 1;

            } catch (PDOException $e) {
                echo '<pre>';
                    print_r($e->getMessage());
                echo  '</pre>';
            }

        }

        public function buscarProduto($id) {
            $sql = "SELECT P.id, P.st_produto, P.marca_id, P.st_observacao, P.vl_valor_venda, P.st_tamanho, P.st_medida ,P.tipo_produto_id "
                  ."FROM produtos P INNER JOIN marcas M ON M.id = P.marca_id "
                  ."WHERE P.id = ".$id;

            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->execute();
                return $statement->fetch(PDO::FETCH_ASSOC);
            }
            catch (PDOException $e) {
                echo '<pre>';
                    print_r($e->getMessage());
                echo '</pre>';
            }
        }

        public function visualizar($id) {
          $sql = " SELECT P.id, P.st_produto, P.st_tamanho, P.st_medida, P.tipo_produto_id, P.marca_id, P.vl_valor_venda, P.st_observacao,
                          T.id, T.st_descricao, T.ch_informacao_adicionais,
                          M.id, M.st_marca,
                          E.nr_quantidade,
                          I.st_cor, I.nr_codigo_cor, I.nr_numero_linha
                    FROM produtos P
                        LEFT JOIN estoques E ON P.id = E.produto_id
                        INNER JOIN tipos_produtos T ON P.tipo_produto_id = T.id
                        INNER JOIN marcas M ON P.marca_id = M.id
                        INNER JOIN produtos_informacoes_adicionais I ON P.id = I.produto_id
                    WHERE P.id = ". $id;

            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->execute();
                return $statement->fetch(PDO::FETCH_ASSOC);
            }
            catch (PDOException $e) {
                echo '<pre>';
                    print_r($e->getMessage());
                echo '</pre>';
            }
        }
    }

?>

