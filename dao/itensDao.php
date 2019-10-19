<?php
    require_once DIR_CONEXAOBD.'conexaoPDO.php';

    class ItensDao {
        
        private $conexaoBD;
        
        public function __construct() {
            $this->conexaoBD = ConexaoPDO::getInstance();
        }
        
        public function cadastrar($itens, $nota_id) {
            $sql = "INSERT INTO itens_notas (nota_id, produto_id, nr_quantidade, vl_valor_unitario, vl_valor_total) "
                 . "VALUES (:nota_id, :produto_id, :nr_quantidade, :vl_valor_unitario, :vl_valor_total)";
            
            foreach ($itens as $item) {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->bindValue(':nota_id', $nota_id, PDO::PARAM_STR);
                $statement->bindValue(':produto_id',$item['produto_id'], PDO::PARAM_STR);
                $statement->bindValue(':nr_quantidade',$item['nr_quantidade'], PDO::PARAM_STR);
                $statement->bindValue(':vl_valor_unitario',$item['vl_valor_unitario'], PDO::PARAM_STR);
                $statement->bindValue(':vl_valor_total',$item['vl_valor_total'], PDO::PARAM_STR);
                $statement->execute();
            }
            
            return 1;
        }
        
        public function editar($itensCadastrados, $itensSelecionados, $nota_id) {
            
            $sql = "DELETE FROM itens_notas WHERE id = :id";
            
            
            //quando tiver alimentando o estoque aqui deve primeiro diminuir a quantidade do estoque e depois somar quando salvar 
            

            //faz a exclusão dos itens cadastrados inicialmente
            foreach ($itensCadastrados as $itensCadastrado) {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->bindValue(":id",$itensCadastrado['id'],PDO::PARAM_INT);
                $statement->execute();
            }
            
            //faz o cadasto dos novos itens 
            return $this->cadastrar($itensSelecionados, $nota_id);
        }
        
        public function buscarItensdaNotaFiscal($nota_id) {
            $sql = " SELECT I.id, I.nr_quantidade, I.vl_valor_unitario, I.vl_valor_total, I.nota_id, I.produto_id,
                            P.id as IdProduto, P.st_produto 
                     FROM itens_notas I INNER JOIN produtos P ON I.produto_id = P.id  
                     WHERE I.nota_id = ". $nota_id;
            
            $statement = $this->conexaoBD->prepare($sql);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>

