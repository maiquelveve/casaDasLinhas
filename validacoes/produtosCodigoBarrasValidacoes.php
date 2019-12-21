<?php
    require_once DIR_DAO .'produtosCodigoBarrasDao.php';
    require_once DIR_CONEXAOBD.'conexaoPDO.php';

    class produtosCodigoBarrasValidacoes
    {
        private $produtosCodigoBarrasDao;
        private $conexaoBD;

        public function __construct() {
            $this->produtosCodigoBarrasDao = new ProdutosCodigoBarrasDao();
            $this->conexaoBD = ConexaoPDO::getInstance();
        }

        public function cadastrar($codigoBarra, $produto_id) {  
            try {
                $this->produtosCodigoBarrasDao->cadastrar($codigoBarra, $produto_id);
                return 1;

            } catch (Exception $e) {
                throw new Exception($e);
            }
        }

        public function adicionarCodigosBarras($post, $produto_id) {            
            try {
                $this->conexaoBD->beginTransaction();

                $this->excluirTodosCodigosBarraProduto($produto_id);

                if(count($post) > 1) {
                    unset($post['produto_id']);                    
                    foreach ($post as $codigoBarra) {

                        $this->cadastrar($codigoBarra, $produto_id);
                    }    
                }    

                $this->conexaoBD->commit();
                return 1;

            } catch (Exception $e) {
                $this->conexaoBD->rollback();
                return ['Códigos de Barras não foram salvos'];
            }
        }

        private function excluirTodosCodigosBarraProduto($produto_id) {
            try {
                $this->produtosCodigoBarrasDao->excluirTodosCodigosBarraProduto($produto_id);    
            } catch (Exception $e) {
                throw new Exception($e);
            }
        }

        public function buscarCodigosBarrasProduto($produto_id) {
            try {
                return $this->produtosCodigoBarrasDao->buscarCodigosBarrasProduto($produto_id);
            } catch (Exception $e) {
                return 0;
            }
        }

        public function buscarProutoPeloCodigoBarras($st_codigo_barras) {
            try {
                return 4345355;
                return $this->produtosCodigoBarrasDao->buscarProutoPeloCodigoBarras($st_codigo_barras);
            } catch (Exception $e) {
                return 0;
            }
        }
    }
?>

