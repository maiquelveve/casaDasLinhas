<?php
    require_once DIR_DAO.'produtosInformcoesAdicionaisDao.php';

    class ProdutosInformcoesAdicionaisValidacoes {
        
        private $produtosInformacoesAdicionaisDao;
        
        public function __construct() {
            $this->produtosInformacoesAdicionaisDao = new ProdutosInformacoesAdicionaisDao();
        }

        public function cadastrar($post, $produto_id) {
            try {
                $post['produto_id'] = $produto_id;
                return $this->produtosInformacoesAdicionaisDao->cadastrar($post);     
            } catch (Exception $e) {
                throw new Exception($e);
            }
        }
        
        public function editar ($post, $produto_id) {
            return $this->produtosInformacoesAdicionaisDao->editar($post, $produto_id);
        }
        
        public function buscarInformacoesAdicionais($produto_id) {
            return $this->produtosInformacoesAdicionaisDao->buscarInformacoesAdicionais($produto_id); 
        }
        
        public function validacao($dados) {
            //validações
            $erros = array();
            
            switch ($dados['tipo_produto_id']) {
            
            //validação quanproduto for linha
            case 1:
                //validações do NR_CONDIGO_COR
                if(empty($dados['nr_codigo_cor'])) {
                   $erros[] = 'O Código da Cor deve ser preenchido.';
                }

                if(!is_numeric($dados['nr_codigo_cor'])) {
                   $erros[] = 'O Código da Cor deve ser numérico.';
                }
                
                //validações do NR_NUMERO_LINHA
                if(empty($dados['nr_numero_linha'])) {
                   $erros[] = 'O Número da Linha deve ser preenchido.';
                }

                if(!is_numeric($dados['nr_numero_linha'])) {
                   $erros[] = 'O Número da Linha deve ser numérico.';
                }
                //validação do ST_COR
                if(empty($dados['st_cor'])) {
                   $erros[] = 'A Cor da Linha deve ser preenchido.';
                }

                if(strlen($dados['st_cor']) > 30) {
                   $erros[] = 'A Cor da Linha deve ter 30 caracteres no máximo.';
                }

                if(!empty($dados['st_cor']) && strlen($dados['st_cor']) < 3) {
                   $erros[] = 'A Cor da Linha deve ter 3 caracteres no mínimo.';
                }

                if(is_numeric($dados['st_cor'])) {
                   $erros[] = 'A Cor da Linha não pode ser numérico.';
                }
                break;
            
            //validação quanproduto for agulha
            case 2:
                //validações
                break;
            }
            
            return $erros;
        }
    }

?>
