<?php
    require_once DIR_DAO.'itensDao.php';
    require_once DIR_CONFIG. 'tratamentoDados.php';

    class ItensValidacoes {
        
        private $itensDao;
        private $tratamentoDados;
        
        public function __construct() {
            $this->itensDao = new ItensDao();
            $this->tratamentoDados = new TratamentoDados();
        }
        
        public function cadastrar($itens, $nota_id) {
            try {
                return $this->itensDao->cadastrar($itens, $nota_id);    
            } catch (Exception $e) {
                throw new Exception($e);
            }
        }
    
        public function editar($itensCadastrados, $itensSelecionados, $nota_id) {
            try {
                return $this->itensDao->editar($itensCadastrados, $itensSelecionados, $nota_id);    
            } catch (Exception $e) {
                throw new Exception($e);    
            }
        }
        
        public function buscarItensdaNotaFiscal($nota_id) {
            try {
                $itens = $this->itensDao->buscarItensdaNotaFiscal($nota_id);
                $itensTratadosParaTela = array();
                
                foreach ($itens as $item) {
                    $itensTratadosParaTela[] = $this->tratamentoDados->ajustarFormatosDeDadosParaTela($item);
                }
                
                return $itensTratadosParaTela;    

            } catch (Exception $e) {
                return 0;
            }
        }
        
        public function validacao ($itens) {
            $erros = array();
            $valorDosItens = 0;
            
            foreach ($itens as $item) {
                //validação do nr_quantidade
                if(empty($item['nr_quantidade'])) {
                    $erros[] = 'Quantidade do Item '.$item['st_produto'] .' deve ser preenchida.';
                }
                
                if(strlen($item['nr_quantidade']) > 11) {
                    $erros[] = 'Quantidade do Item '.$item['st_produto'] .' não pode ser maior que 11 dígitos.';
                }
                
                if(!empty($item['nr_quantidade']) && strlen($item['nr_quantidade']) < 1) {
                    $erros[] = 'Quantidade do Item não pode ser menor que 1 unidade.';
                }
                
                //validação do VL_VALOR_TOTAL
                if(isset($item['vl_valor_total']) && !empty($item['vl_valor_total'])) {
                    $valorDosItens += $item['vl_valor_total'];
                }
                
                if(empty($item['vl_valor_total'])) {
                    $erros[] = 'O Valor Total do Item '.$item['st_produto'] .' deve ser preenchido.';
                }

                if(strlen($item['vl_valor_total']) > 10) {
                    $erros[] = 'O Valor Total do Item '.$item['st_produto'] .' não pode ser maior que 10 dígitos.';
                }
                
                //validação do VL_VALOR_UNITARIO
                if(empty($item['vl_valor_unitario'])) {
                    $erros[] = 'O Valor Unitário do Item '.$item['st_produto'] .' deve ser preenchido.';
                }

                if(strlen($item['vl_valor_unitario']) > 10) {
                    $erros[] = 'O Valor Unitário do Item '.$item['st_produto'] .' não pode ser maior que 11 dígitos.';
                }
            }
            
            if(count($erros) > 0) {
                return $erros;
            } else {
                return $valorDosItens;
            }    
        }
    }
?>

