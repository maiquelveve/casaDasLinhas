<?php

require_once DIR_DAO . 'marcasDao.php';
require_once DIR_CONFIG . 'tratamentoDados.php';

class MarcasValidacoes {

    private $marcasDao;
    private $tratamentoDados;

    public function __construct() {
        $this->marcasDao = new MarcasDao();
        $this->tratamentoDados = new TratamentoDados();
    }

    public function cadastrar($post) {
        try {
            $post = $this->tratamentoDados->ajustarFormatosDeDadosParaBanco($post);

            $erros = $this->validacao($post);

            if (count($erros) == 0) {
                return $this->marcasDao->cadastrar($post);
            } else {
                return $erros;
            }    
        } catch (Exception $e) {
            return 0;    
        }
    }

    public function editar($post, $id) {
        try {
            $post = $this->tratamentoDados->ajustarFormatosDeDadosParaBanco($post);

            $erros = $this->validacao($post);

            if (count($erros) == 0) {
                return $this->marcasDao->editar($post, $id);
            } else {
                return $erros;
            }

        } catch (Exception $e) {
            return 0;
        }
    }

    public function excluir($id) {
        try {
            $marca = $this->buscarMarcas($id);
            
            if (count($marca) >= 1) {
                return $this->marcasDao->excluir($id);
            } else {
                return ['Marca não existe no sistema.'];
            }
        } catch (Exception $e) {
            return ['Marca não pode ser excluida.'];    
        }
    }

    public function pesquisar($post) {
        try {
            return $this->marcasDao->pesquisar($post);    
        } catch (Exception $e) {
            return 0;
        }
    }

    public function buscarMarcas($id) {
        try {
            return $this->marcasDao->buscarMarcas($id);
        } catch (Exception $e) {
            return 0;
        }
    }

    public function buscarMarcasCombo() {
        try {
            return $this->marcasDao->buscarMarcasCombo();
        } catch (Exception $e) {
            return 0;
        }
    }

    public function validacao($dados) {
        $erros = array();

        if (empty($dados['st_marca'])) {
            $erros[] = 'A Marca deve ser preenchida.';
        }

        if (strlen($dados['st_marca']) > 25) {
            $erros[] = 'A Marca deve ter no máximo 25 caracteres.';
        }

        if (!empty($dados['st_marca']) && strlen($dados['st_marca']) < 3) {
            $erros[] = 'A Marca deve ter no mínimo 3 caracteres.';
        }

        if (is_numeric($dados['st_marca'])) {
            $erros[] = 'A Marca não pode ser numérico.';
        }

        return $erros;
    }

}
?>

