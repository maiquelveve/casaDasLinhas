<?php
    require_once DIR_DAO.'nrNotasVendasDao.php';

    class nrNotasVendasValidacoes {

        private $nrNotasVendasDao;

        public function __construct() {
            $this->nrNotasVendasDao = new nrNotasVendasDao();
        }

        public function cadastrar($venda_id) {
            $numeroNotaVenda = $this->gerarNumeroNotaFiscalVenda();
            return $this->nrNotasVendasDao->cadastrar($numeroNotaVenda, $venda_id);
        }

        private function gerarNumeroNotaFiscalVenda() {
            $ultimoNumero = $this->nrNotasVendasDao->buscarUltimoNumeroNotaFiscal();
            return $ultimoNumero['nr_nota'] += 1;
        }

        public function buscarNrNotaFiscalVenda($venda_id) {
            return $this->nrNotasVendasDao->buscarNrNotaFiscalVenda($venda_id);
        }

    }
?>
