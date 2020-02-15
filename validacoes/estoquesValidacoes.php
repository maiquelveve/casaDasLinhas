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
        try {
            return $this->estoquesDao->editar($item, $produto_id);    
        } catch (Exception $e) {
            throw new Exception($e);    
        }
    }

    //Essa função eh para add mais quatidade no item no estoque, a tela e acessada pelo produtos/pesquisar
    public function adicionarQuantidadeEstoque($itens) {
        try {
            $this->verificaItemEstoque($itens);
            return 1;
        } catch (Exception $e) {
            return 0;    
        }
    }

    public function verificaItemEstoque($itens) {
        try {
            //var_dump($itens);die('aqui');
            foreach ($itens as $item) {
                $registroEstoque = $this->estoquesDao->verificaItemEstoque($item);
                
                if ($registroEstoque) {
                    $item['nr_quantidade'] += $registroEstoque['nr_quantidade'];
                    $this->editar($item, $registroEstoque['produto_id']);
                } else {
                    $this->cadastrar($item);
                }
            }    
        } catch (Exception $e) {
            throw new Exception($e);     
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
        try {
            return $this->estoquesDao->buscarItemDoEstoque($produto_id);
        } catch (Exception $e) {
            return 0;
        }
    }
}

?>