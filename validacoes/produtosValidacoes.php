<?php
    require_once DIR_VALIDACOES .'produtosInformacoesAdicionaisValidacoes.php';
    require_once DIR_VALIDACOES .'produtosCodigoBarrasValidacoes.php';
    require_once DIR_DAO .'produtosDao.php';
    require_once DIR_CONEXAOBD.'conexaoPDO.php';
    require_once DIR_CONFIG.'tratamentoDados.php';

    class ProdutosValidacoes
    {
        private $produtosDao;
        private $produtosInformacoesAdicionaisValidacoes;
        private $produtosCodigoBarras;
        private $conexaoBD;
        private $tratamentoDados;

        public function __construct() {
            $this->produtosDao = new ProdutosDao();
            $this->produtosInformacoesAdicionaisValidacoes = new ProdutosInformcoesAdicionaisValidacoes();
            $this->produtosCodigoBarras = new ProdutosCodigoBarrasValidacoes();
            $this->tratamentoDados = new TratamentoDados();
            $this->conexaoBD = ConexaoPDO::getInstance();
        }

        public function pesquisar($post) {
            return $this->produtosDao->pesquisar($post);
        }

        public function BuscarTodosProdutos() {
            return $this->produtosDao->BuscarTodosProdutos();
        }

        public function cadastrar($post) {

            $post = $this->tratamentoDados->ajustarFormatosDeDadosParaBanco($post);
            $erros = $this->validacao($post);

            if(count($erros) > 0) {
                return $erros;
            }    

            try {
                $this->conexaoBD->beginTransaction();
                $produto = $this->produtosDao->cadastrar($post);
                $this->produtosInformacoesAdicionaisValidacoes->cadastrar($post, $produto);
                
                if(!empty($post['st_codigo_barra'])) {
                    $this->produtosCodigoBarras->cadastrar($post['st_codigo_barra'], $produto);
                }

                $this->conexaoBD->commit();
                return 1;

            } catch (Exception $e) {
                $this->conexaoBD->rollback();
                return ['Não foi possível cadastrar o produto'];
            }
        }

        public function editar($post, $id) {

            $post = $this->tratamentoDados->ajustarFormatosDeDadosParaBanco($post);

            $erros = $this->validacao($post);

            if(count($erros) == 0) {
                $this->conexaoBD->beginTransaction();

                $produto = $this->produtosDao->editar($post, $id);

                if($produto > 0) {
                    $informcoesAdd = $this->produtosInformacoesAdicionaisValidacoes->editar($post, $id);

                    if($informcoesAdd > 0){
                        $this->conexaoBD->commit();
                    } else {
                        $this->conexaoBD->rollback();
                    }
                    return $informcoesAdd;
                } else {
                    $this->conexaoBD->rollback();
                    return $produto;
                }
            } else {
                return $erros;
            }
        }

        public function buscarProduto($id) {
            return $this->produtosDao->buscarProduto($id);
        }

        public function buscarTodosProdutosParaVenda() {
            return $this->produtosDao->BuscarTodosProdutosParaVenda(); 
        }

        public function buscarProdutoParaVenda($produto_id) {
            $produtos = $this->produtosDao->buscarProdutoParaVenda($produto_id);
            return $this->tratamentoDados->ajustarFormatosDeDadosParaTela($produtos);     
        }

        public function visualizar($id) {
            return $this->produtosDao->visualizar($id);
        }

        private function validacao($dados) {
            $erros = array();

            //validação do ST_PRODUTO
            if(empty($dados['st_produto'])) {
               $erros[] = 'O nome do Pruduto deve ser preenchido.';
            }

            if(strlen($dados['st_produto']) > 80) {
               $erros[] = 'O nome do Pruduto deve ter 80 caracteres no máximo.';
            }

            if(!empty($dados['st_produto']) && strlen($dados['st_produto']) < 3) {
               $erros[] = 'O nome do Pruduto deve ter 3 caracteres no mínimo.';
            }

            if(is_numeric($dados['st_produto'])) {
               $erros[] = 'O nome do Pruduto não pode ser numérico.';
            }

            //validacão do ST_TAMANHO
            if(empty($dados['st_tamanho'])) {
               $erros[] = 'O Tamanho deve ser preenchido.';
            }

            if(strlen($dados['st_tamanho']) > 25) {
               $erros[] = 'O Tamanho deve ter 25 caracteres no máximo.';
            }

            if(!empty($dados['st_tamanho']) && strlen($dados['st_tamanho']) < 2) {
               $erros[] = 'O Tamanho deve ter 2 caracteres no mínimo.';
            }

            //validação do ST_MEDIDA
            if(empty($dados['st_medida'])) {
               $erros[] = 'Selecione uma Unidade de Medida.';
            }

            if($dados['st_medida'] != 'G' && $dados['st_medida'] != 'KG' && $dados['st_medida'] != 'M' && $dados['st_medida'] != 'CM' && $dados['st_medida'] != 'TM' && $dados['st_medida'] != '')  {
               $erros[] = 'Tipo de Medida invalido.';
            }

            //validação do TIPO_PRODUTO_ID
            if(empty($dados['tipo_produto_id'])) {
               $erros[] = 'Selecione o Tipo do Produto.';
            }

            if(!is_numeric($dados['tipo_produto_id'])) {
               $erros[] = 'Tipo do Produto invalido.';
            }

            //validação do MARCA_ID
            if(empty($dados['marca_id'])) {
               $erros[] = 'Selecione a Marca do Produto.';
            }

            if(!is_numeric($dados['marca_id'])) {
               $erros[] = 'Marca do Produto invalida.';
            }

            //validação do VL_VALOR_VENDA
            if(empty($dados['vl_valor_venda'])) {
               $erros[] = 'O Valor do Pruduto deve ser preenchido.';
            }

            if(strlen($dados['vl_valor_venda']) > 30) {
               $erros[] = 'O Valor do Pruduto deve ter 30 caracteres no máximo.';
            }

            //tem que fazer validar com numero com virgula
            if(!is_numeric($dados['vl_valor_venda'])) {
               $erros[] = 'O Valor do Pruduto deve ser decimal.';
            }

            //validação do ST_OBSERVACAO
            if(strlen($dados['st_observacao']) > 200) {
               $erros[] = 'O campo "OBESRVAÇÃO"  deve ter 200 caracteres no máximo.';
            }

            //valida as informações adicionais e se houver erro popula na variavel $erros
            $validacaoProdutoInformacaoAdd = $this->produtosInformacoesAdicionaisValidacoes->validacao($dados);

            if(count($validacaoProdutoInformacaoAdd) > 0) {
                foreach($validacaoProdutoInformacaoAdd as $v) {
                    $erros[] = $v;
                }
            }

            return $erros;
        }
    }
?>

