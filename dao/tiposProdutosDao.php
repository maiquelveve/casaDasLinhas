<?php
    require_once DIR_CONEXAOBD.'conexaoPDO.php';
    
    class TiposProdutosDao 
    {
        private $conexaoBD;
        
        public function __construct() {
            $this->conexaoBD = ConexaoPDO::getInstance();
        }
        
        public function buscarTiposProdutosCombo() {
            
            $sql = "SELECT id, st_descricao, ch_informacao_adicionais FROM tipos_produtos";
            
            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->execute();
                return $statement->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo '<pre>';
                    print_r($e->getMessage());
                echo  '</pre>';
            }
        }
        
        public function buscarTiposProdutos($id) {
            
            $sql = "SELECT id, st_descricao, ch_informacao_adicionais FROM tipos_produtos WHERE id = ". $id;
            
            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->execute();
                return $statement->fetch(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                echo '<pre>';
                    print_r($e->getMessage());
                echo  '</pre>';
            }
        }
        
        public function cadastrar($post) {
            $sql = "INSERT INTO tipos_produtos (st_descricao,ch_informacao_adicionais) VALUES (:st_descricao, :ch_informacao_adicionais)";
            
            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->bindValue(':st_descricao',$post['st_descricao'],PDO::PARAM_STR);
                $statement->bindValue(':ch_informacao_adicionais',$post['ch_informacao_adicionais'],PDO::PARAM_STR);
                $statement->execute();
                return $this->conexaoBD->lastInsertId();
                
            } catch (PDOException $e) {
                echo '<pre>';
                    print_r($e->getMessage());
                echo  '</pre>';
            }
            
        }
        
        public function editar($post, $id) {
            $sql = "UPDATE tipos_produtos SET st_descricao = :st_descricao, ch_informacao_adicionais = :ch_informacao_adicionais WHERE id = :id";
            
            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->bindValue(':st_descricao', $post['st_descricao'], PDO::PARAM_STR);
                $statement->bindValue(':ch_informacao_adicionais', $post['ch_informacao_adicionais'], PDO::PARAM_STR);
                $statement->bindValue(':id', $id, PDO::PARAM_INT);
                $statement->execute();
                return 1;
                
            } catch(PDOException $e) {
                echo '<pre>';
                    print_r($e->getMessage());
                echo '</pre>';
            }
        }
        
        public function pesquisar($post) {
            $sql = "SELECT id, st_descricao, ch_informacao_adicionais FROM tipos_produtos WHERE st_descricao LIKE '%".$post['st_descricao']."%'";
            
            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->execute();
                return $statement->fetchAll(PDO::FETCH_ASSOC);
                
            } catch(PDOException $e) {
                echo '<pre>';
                    print_r($e->getMessage());
                echo '</pre>';
            }
        }

        public function excluir($id) {
            $sql = "DELETE FROM tipos_produtos WHERE id = :id";
            
            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->bindValue(':id', $id, PDO::PARAM_INT);
                $statement->execute();
                return 1;
                
            } catch(PDOException $e) {
                throw new Exception($e);
            }
        }
    }
?>
