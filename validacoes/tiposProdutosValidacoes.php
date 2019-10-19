<?php
    require_once DIR_DAO.'tiposProdutosDao.php';
    require_once DIR_CONFIG.'tratamentoDados.php';
    
    class TiposProdutosValidacoes 
    {
        private $tiposProdutosDao;
        private $tratamentoDados;
        
        public function __construct() {
            $this->tiposProdutosDao = new TiposProdutosDao();
            $this->tratamentoDados = new TratamentoDados();
        }
        
        public function cadastrar($post) {
            
            $post = $this->tratamentoDados->ajustarFormatosDeDadosParaBanco($post);
            
            $erros = $this->validacao($post);
            
            if(count($erros) == 0) {
                return $this->tiposProdutosDao->cadastrar($post);
            } else {
                return $erros;
            }
        }
        
        public function editar($post, $id) {
            
            $post = $this->tratamentoDados->ajustarFormatosDeDadosParaBanco($post);
            
            $erros = $this->validacao($post);
            
            if(count($erros) == 0) {
                return $this->tiposProdutosDao->editar($post, $id);
            } else {
                return $erros;
            }
        }
        
        public function excluir($id) {
            try {
                $tipoProduto = $this->buscarTiposProdutos($id);
                
                if (count($tipoProduto) >= 1) {
                    return $this->tiposProdutosDao->excluir($id);
                } else {
                    return ['Tipo de Produto não existe no sistema.'];
                }
            } catch (Exception $e) {
                return ['Tipo de Produto não pode ser excluido.'];    
            }
        }

        public function pesquisar($post) {
            return $this->tiposProdutosDao->pesquisar($post);
        }
        
        public function buscarTiposProdutosCombo() {
            return $this->tiposProdutosDao->buscarTiposProdutosCombo();
        }
        
        public function buscarTiposProdutos($id) {
            return $this->tiposProdutosDao->buscarTiposProdutos($id);
        }
        
        public function validacao($dados) {
            
           $erros = array();
           
           if(empty($dados['st_descricao'])) {
               $erros[] = 'O Tipo do Produto deve ser preenchida.';
           }
           
           if(strlen($dados['st_descricao']) > 80) {
               $erros[] = 'O Tipo do Produto deve ter no máximo 80 caracteres.';
           }
           
           if(!empty($dados['st_descricao']) && strlen($dados['st_descricao']) < 3) {
               $erros[] = 'O Tipo do Produto deve ter no mínimo 3 caracteres.';
           }

           if(is_numeric($dados['st_descricao'])) {
               $erros[] = 'O Tipo do Produto não pode ser numérico.';
           }
           
           if(empty($dados['ch_informacao_adicionais'])) {
               $erros[] = 'Selecione um opção no campo "Informações Adicionais".';
           }
                      
           if(!empty($dados['st_descricao']) && strlen($dados['ch_informacao_adicionais']) > 1) {
               $erros[] = 'O campo "Informações Adicionais" deve ter no máximo 1 caracteres.';
           }

           if(is_numeric($dados['ch_informacao_adicionais'])) {
               $erros[] = 'O campo "Informações Adicionais" não pode ser numérico.';
           }
           
           if(!empty($dados['st_descricao']) && $dados['ch_informacao_adicionais'] != 'S' && $dados['ch_informacao_adicionais'] != 'N' && $dados['ch_informacao_adicionais'] != '') {
               $erros[] =  'O valor do campo "Informações Adicionais" é invalido';
           }
           
           return $erros;
        }
    }
?>
