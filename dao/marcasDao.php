<?php
    require_once DIR_CONEXAOBD.'conexaoPDO.php';

    class MarcasDao {
        
        private $conexaoBD;
        
        public function __construct() {
            $this->conexaoBD = ConexaoPDO::getInstance();
        }
        
        public function buscarMarcas($id) {
            $sql = "SELECT id, st_marca FROM marcas WHERE id = ". $id;
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
        
        public function buscarMarcasCombo() {
            $sql = "SELECT id, st_marca FROM marcas";
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
        
        public function pesquisar($post) {
            $where = 'WHERE 1=1';
            
            if(isset($post['st_marca']) && !empty($post['st_marca'])) {
                $where.= " AND M.st_marca LIKE '%". $post['st_marca']. "%'";
            }
            
            
            $sql = "SELECT M.id, M.st_marca "
                 . "FROM marcas M "
                 .$where; 

            try{
                $statement = $this->conexaoBD->prepare($sql);
                $statement->execute();
                return $statement->fetchAll(PDO::FETCH_ASSOC);
                
            } catch(PDOException $e) {
                echo '<pre>';
                    print_r($e->getMessage());
                echo  '</pre>';     
            }
        }
        
        public function cadastrar($post) {
            
            $sql = "INSERT INTO marcas (st_marca) VALUES (:st_marca)";
            
            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->bindValue(':st_marca',$post['st_marca'],PDO::PARAM_STR);
                $statement->execute();
                return $this->conexaoBD->lastInsertId();
                
            } catch(PDOException $e) {
                echo '<pre>';
                    print_r($e->getMessage());
                echo  '</pre>';     
            }
        }
        
        public function editar($post, $id) {
            $sql = "UPDATE marcas SET st_marca = :st_marca WHERE id = :id";
            
            try {
                $statement = $this->conexaoBD->prepare($sql);
                $statement->bindValue(':st_marca', $post['st_marca'], PDO::PARAM_STR);
                $statement->bindValue(':id', $id, PDO::PARAM_INT);
                $statement->execute();
                return 1;
                
            } catch(PDOException $e) {
                echo '<pre>';
                    print_r($e->getMessage());
                echo  '</pre>';     
            }
        }

        public function excluir($id) {
            $sql = "DELETE FROM marcas WHERE id = :id";
            
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

