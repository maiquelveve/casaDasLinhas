<?php
    require_once DIR_CONFIG.'tratamentoDados.php';
    require_once DIR_DAO.'vendasProdutosDao.php';

    class VendasProdutosValidacoes {

        private $vendasProdutosDao;
        private $tratamentoDados;

        public function __construct() {
            $this->vendasProdutosDao = new VendasProdutosDao();
            $this->tratamentoDados = new TratamentoDados();
        }

        public function cadastrar($itensVenda, $venda_id) {
            try {
                return $this->vendasProdutosDao->cadastrar($itensVenda, $venda_id);    
            } catch (Exception $e) {
                throw new Exception($e);
            }
        }

        public function editar ($itensVenda, $venda_id) {
            try {
                $antigoItens = $this->vendasProdutosDao->excluir($itensVenda, $venda_id);
                $novosItens = $this->vendasProdutosDao->cadastrar($itensVenda, $venda_id);
                return 1;

            } catch (PDOException $e) {
                throw new Exception($e);
            }
        }

        public function buscarItensVenda($venda_id) {
            try {
                return $this->vendasProdutosDao->buscarItensVenda($venda_id);
            } catch (Exception $e) {
                return 0;
            }
        }

        public function validacao($itens){

            $erros = array();

            if(count($itens) > 0) {
                foreach ($itens as $item) {
                    if(isset($item['nr_quantidade_venda']) && empty($item['nr_quantidade_venda'])){
                        $erros[] = "Informe a Quantidade do Produto ". $item['st_produto']. ".";
                    }

                    if($item['nr_quantidade_venda'] <= 0){
                        $erros[] = "A Quantidade do Produtos ". $item['st_produto'] ." deve ser maior que zero.";
                    }

                    if(empty($item['vl_item_venda'])){
                        $erros[] = "Informe o Valor Total do Produto ". $item['st_produto']. ".";
                    }

                    if(!empty($item['vl_item_venda']) && $item['vl_item_venda'] <= 0){
                        $erros[] = "O Valor Total do Produto ". $item['st_produto'] ." deve ser maior que zero.";
                    }
                    
                    //compara a quantidade do produto solicitado com a quatidade do produto em estoque
                    if($item['nr_quantidade_venda'] > $item['nr_quantidade']) {
                        $erros[] = "A quantidade do ".$item['st_produto']." é maior do que contém no estoque.";
                    }
                    
                }
            } else {
                $erros[] = "Selecione pelo menos 01 item para a venda";
            }
            
            return $erros;
        }
    }
?>