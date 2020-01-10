<?php
    require_once DIR_DAO.'nrNotasVendasDao.php';

    class nrNotasVendasValidacoes {

        private $nrNotasVendasDao;

        public function __construct() {
            $this->nrNotasVendasDao = new nrNotasVendasDao();
        }

        public function cadastrar($venda_id) {
            try {
                $numeroNotaVenda = $this->gerarNumeroNotaFiscalVenda();
                return $this->nrNotasVendasDao->cadastrar($numeroNotaVenda, $venda_id);
            } catch (Exception $e) {
                throw new Exception($e);
            }
        }

        private function gerarNumeroNotaFiscalVenda() {
            try {
                $ultimoNumero = $this->nrNotasVendasDao->buscarUltimoNumeroNotaFiscal();
                return $ultimoNumero['nr_nota'] += 1;
            } catch (Exception $e) {
                throw new Exception($e);
            }
        }

        public function buscarNrNotaFiscalVenda($venda_id) {
            try {
                return $this->nrNotasVendasDao->buscarNrNotaFiscalVenda($venda_id);    
            } catch (Exception $e) {
                throw new Exception($e);
            }
        }

    }
?>
