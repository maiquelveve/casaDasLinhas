<?php
    require_once DIR_CONFIG.'tratamentoDados.php';
    require_once DIR_DAO.'vendasDao.php';
    require_once DIR_CONEXAOBD.'conexaoPDO.php';
    require_once DIR_VALIDACOES.'vendasProdutosValidacoes.php';
    require_once DIR_VALIDACOES.'estoquesValidacoes.php';
    require_once DIR_VALIDACOES.'nrNotasVendasValidacoes.php';

    class VendasValidacoes {

        private $vendasDao;
        private $vendasProdutosValidacoes;
        private $tratamentoDados;
        private $estoquesValidacoes;
        private $nrNotaVenda;
        private $conexaoBD;

        public function __construct() {
            $this->vendasDao = new VendasDao();
            $this->vendasProdutosValidacoes = new VendasProdutosValidacoes();
            $this->tratamentoDados = new TratamentoDados();
            $this->estoquesValidacoes = new estoquesValidacoes();
            $this->nrNotaVenda = new nrNotasVendasValidacoes();
            $this->conexaoBD = ConexaoPDO::getInstance();
        }

        public function pesquisar($post) {
            $where = 'WHERE 1 = 1';

            if(isset($post['dt_venda_inicial']) && !empty($post['dt_venda_inicial'])) {
                $data_inicial = $post['dt_venda_inicial'];
            } else {
                $data_inicial = '1900-01-01';
            }

            if(isset($post['dt_venda_final']) && !empty($post['dt_venda_final'])) {
                $data_final = $post['dt_venda_final'];
            } else {
                $data_final = '2100-12-31';
            }

            if(isset($post['st_situacao']) && !empty($post['st_situacao'])) {
                $where .= " AND st_situacao = '".$post['st_situacao']."'";
            }

            if(isset($post['st_pagamento']) && !empty($post['st_pagamento'])) {
                $where .= " AND st_pagamento = '".$post['st_pagamento']."'";
            }

            $where .= " AND dt_venda BETWEEN '".$data_inicial ."' AND '".$data_final."'";

            return $this->vendasDao->pesquisar($where);
        }

        public function cadastrar($post) {
            $post['dt_venda'] = date('d/m/Y');
            $post = $this->tratamentoDados->ajustarFormatosDeDadosParaBanco($post);
            $itensSelecionados = $this->itensSelecionadosParaVenda($post);

            $validacaoVenda = $this->validacao($post, $itensSelecionados);

            if(count($validacaoVenda) > 0) {
                return $validacaoVenda;
            } 

            try {
                $this->conexaoBD->beginTransaction();

                $vendas = $this->vendasDao->cadastrar($post);
                $itensVenda = $this->vendasProdutosValidacoes->cadastrar($itensSelecionados, $vendas);
                $this->conexaoBD->commit();

                return $vendas;

            } catch (PDOException $e) {
                $this->conexaoBD->rollback();
                return 0;
            }
        }

        public function editar($id, $post) {
            $post = $this->tratamentoDados->ajustarFormatosDeDadosParaBanco($post);
            $itensVenda = $this->itensSelecionadosParaVenda($post);

            $validacaoVenda = $this->validacao($post, $itensVenda);

            if(count($validacaoVenda) > 0) {
                return $validacaoVenda;
            } 

            try{
                $this->conexaoBD->beginTransaction();
                
                $vendas = $this->vendasDao->editar($post, $id);
                $itens = $this->vendasProdutosValidacoes->editar($itensVenda, $id);
                $this->conexaoBD->commit();

                return $vendas;

            } catch (PDOException $e) {
                $this->conexaoBD->rollback();
                return 0;
            }
        }

        public function confirmarVenda($venda_id, $post) {
            $erros = array();
            $itensVenda = $this->vendasProdutosValidacoes->buscarItensVenda($venda_id);
            $erros = $this->validacao('', $itensVenda);

            if(count($erros) == 0) {
                $this->conexaoBD->beginTransaction();
                try {
                    $venda = $this->vendasDao->confirmarVenda($venda_id, $post);
                    $notaVenda = $this->nrNotaVenda->cadastrar($venda_id);
                    $estoque = $this->estoquesValidacoes->diminuirEstoque($itensVenda);
                    $this->conexaoBD->commit();

                    return $estoque;

                } catch(PDOException $e) {
                    $this->conexaoBD->rollback();
                    return 0;
                }
            } else {
                return $erros;
            }
        }

        public function cancelarVenda($id) {
            try {
                return $this->vendasDao->cancelarVenda($id);
            } catch (Exception $e) {
                return 0;
            }
        }

        public function buscarTodasVendasHoje() {
            try {
                return $this->vendasDao->buscarTodasVendasHoje();
            } catch (Exception $e) {
                return 0;
            }
        }

        public function quantidadeItensVenda($id) {
            try {
                return $this->vendasDao->quantidadeItensVenda($id);
            } catch (Exception $e) {
                return 0;
            }
        }

        public function buscarVenda($id) {
            try {
                $venda = $this->vendasDao->buscarVenda($id);
                return $this->tratamentoDados->ajustarFormatosDeDadosParaTela($venda);    
            } catch (Exception $e) {
                return 0;
            }
        }

        public function itensSelecionadosParaVenda($post) {
            $itens = array();
            $x = 0;

            foreach ($post as $key => $v) {
                $k = explode("-", $key);

                if($k[0] == "nr_quantidade_venda") {
                    $nr_quantidade_venda = $v;
                    $produto_id = $k[1];
                    $x++;
                }

                if($k[0] == "vl_item_venda") {
                    $vl_item_venda = $v;
                    $x++;
                }

                if($k[0] == "st_produto") {
                    $st_produto = $v;
                    $x++;
                }

                if($k[0] == "nr_quantidade") {
                    $nr_quantidade = $v;
                    $x++;
                }

                if($x == 4) {
                    $itens[] = ["produto_id" => $produto_id, "nr_quantidade_venda" => $nr_quantidade_venda, "vl_item_venda" => $vl_item_venda, "st_produto" => $st_produto, "nr_quantidade" => $nr_quantidade];
                    $x = 0;
                }
            }

            return $itens;
        }

        public function validacao($dados, $itensVenda) {

            $erros = array();

            if(isset($dados['dt_venda']) && empty($dados['dt_venda'])) {
                $erros[] = "Informe a Data da Venda";
            }

            if(isset($dados['vl_venda_valor_total']) && empty($dados['vl_venda_valor_total'])){
                $erros[] = "Informe o Valor Total da Venda";
            }

            if(isset($dados['vl_venda_valor_total']) && $dados['vl_venda_valor_total'] <= 0){
                $erros[] = "O Valor Total da Venda deve ser maior que zero";
            }

            //validação dos itens
            $errosItensVenda = $this->vendasProdutosValidacoes->validacao($itensVenda);

            if(count($errosItensVenda) >= 1) {
                foreach ($errosItensVenda as $e) {
                    $erros[] = $e;
                }
            }

            return $erros;
        }
    }
?>
