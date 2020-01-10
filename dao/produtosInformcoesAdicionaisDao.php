<?php
    require_once DIR_CONEXAOBD.'conexaoPDO.php';

    class ProdutosInformacoesAdicionaisDao {
        
        private $conexaoBD;
        
        public function __construct() {
            $this->conexaoBD = ConexaoPDO::getInstance();
        }
        
        public function cadastrar($post) {
                       
            $values = $post['produto_id'];
 
            //informações add referente as linhas
            if (isset($post['st_cor']) && !empty($post['st_cor'])) {
                $values .= ",'".$post['st_cor']."'";
            } else {
                $values .=", NULL";
            }
            
            if (isset($post['nr_codigo_cor']) && !empty($post['nr_codigo_cor'])) {
                $values .= ",".$post['nr_codigo_cor']."";
            } else {
                $values .=", NULL";
            }
            
            if (isset($post['nr_numero_linha']) && !empty($post['nr_numero_linha'])) {
                $values .= ",".$post['nr_numero_linha']."";
            } else {
                $values .=", NULL";
            }

            //informações add referente as agulhas daqui endiante
            
            $sql = "INSERT INTO produtos_informacoes_adicionais (produto_id, st_cor, nr_codigo_cor, nr_numero_linha) "
                 . "VALUES(".$values.")";
            
            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->execute();
                return $this->conexaoBD->lastInsertId();
                
            } catch (PDOException $e) {
                throw new Exception($e);
            }
        }
        
        public function editar($post, $produto_id) {
            
            $values = 'produto_id = '. $produto_id;
            
            //informações add referente as linhas
            if (isset($post['st_cor']) && !empty($post['st_cor'])) {
                $values .= ", st_cor = '".$post['st_cor']."'";
            } else {
                $values .= ", st_cor = NULL";
            }
            
            if (isset($post['nr_codigo_cor']) && !empty($post['nr_codigo_cor'])) {
                $values .= ", nr_codigo_cor = ".$post['nr_codigo_cor'];
            } else {
                $values .= ", nr_codigo_cor = NULL";
            }
            
            if (isset($post['nr_numero_linha']) && !empty($post['nr_numero_linha'])) {
                $values .= ", nr_numero_linha = ".$post['nr_numero_linha'];
            } else {
                $values .= ", nr_numero_linha = NULL";
            }
            
            $sql = "UPDATE produtos_informacoes_adicionais SET ". $values . " WHERE produto_id = ".$produto_id;
            
            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->execute();
                return 1;
                
            } catch (PDOException $e) {
                throw new Exception($e);                
            }
        }
        
        public function buscarInformacoesAdicionais($produto_id) {
            $sql = "SELECT * FROM produtos_informacoes_adicionais WHERE produto_id = ". $produto_id;
            
            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->execute();
                return $statement->fetch(PDO::FETCH_ASSOC);   
            } catch (Exception $e) {
                throw new Exception($e);
            }
        }
    }

?>