<?php

require_once DIR_DAO . 'estoquesDao.php';

class estoquesValidacoes {

    private $estoquesDao;

    public function __construct() {
        $this->estoquesDao = new estoquesDao();
    }

    public function cadastrar($item) {
        try {
            $this->estoquesDao->cadastrar($item);    
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function editar($item, $produto_id) {
        $this->estoquesDao->editar($item, $produto_id);
    }

    public function verificaItemEstoque($itens) {
        foreach ($itens as $item) {
            $registroEstoque = $this->estoquesDao->verificaItemEstoque($item);
            if ($registroEstoque) {
                $item['nr_quantidade'] += $registroEstoque['nr_quantidade'];
                $this->editar($item, $registroEstoque['produto_id']);
            } else {
                $this->cadastrar($item);
            }
        }
    }
    
    public function diminuirEstoque($itensVenda) {
        
        try {
            foreach ($itensVenda as $item) {
                $itemNoEstoque = $this->buscarItemDoEstoque($item['id']);            
                $itemNoEstoque['nr_quantidade'] = $itemNoEstoque['nr_quantidade'] - $item['nr_quantidade_venda'];
                $this->editar($itemNoEstoque, $item['id']);
            }
            return 1; 
            
        } catch(PDOException $e) {
            return 0;
        }
    }

    //FAZER O PESQUISAR PARA ALTERARR O ESQOTQUE
    public function buscarItemDoEstoque($produto_id) {
        return $this->estoquesDao->buscarItemDoEstoque($produto_id);
    }

}

?>