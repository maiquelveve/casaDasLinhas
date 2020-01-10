<?php

require_once DIR_DAO . 'notasFiscaisDao.php';
require_once DIR_VALIDACOES . 'itensValidacoes.php';
require_once DIR_VALIDACOES . 'estoquesValidacoes.php';
require_once DIR_CONEXAOBD . 'conexaoPDO.php';
require_once DIR_CONFIG . 'tratamentoDados.php';

class NotasFiscaisValidacoes {

    private $itensValidacoes;
    private $notasFiscaisDao;
    private $conexaoBD;
    private $tratamentoDados;
    private $estoquesValidacoes;

    public function __construct() {
        $this->notasFiscaisDao = new NotasfiscaisDao();
        $this->estoquesValidacoes = new estoquesValidacoes();
        $this->itensValidacoes = new ItensValidacoes();
        $this->conexaoBD = ConexaoPDO::getInstance();
        $this->tratamentoDados = new TratamentoDados();
    }

    public function pesquisar($post) {
        try {
            return $this->notasFiscaisDao->pesquisar($post); 
        } catch (Exception $e) {
            return 0;            
        }
    }

    public function quantidadeItensNota($id) {
        try {
            return $this->notasFiscaisDao->quantidadeItensNota($id);    
        } catch (Exception $e) {
            return 0;    
        }
    }

    public function cadastrar($post) {
        $post['st_cnpj'] = $this->tratamentoDados->ajustarCnpjCpfParaBanco($post['st_cnpj']);
        $post = $this->tratamentoDados->ajustarFormatosDeDadosParaBanco($post);

        $itensSelecionados = $this->itensSelecionadosParaNotaFiscal($post);

        $erros = $this->validacao($post, $itensSelecionados);

        if (count($erros) > 0) {
            return $erros;      
        } 

        try {
            //Inicia a transação para salvar
            $this->conexaoBD->beginTransaction();

            $nota_id = $this->notasFiscaisDao->cadastrar($post);
            $itens = $this->itensValidacoes->cadastrar($itensSelecionados, $nota_id);
            $this->conexaoBD->commit();
            return 1;

        } catch (PDOException $e) {
            $this->conexaoBD->rollback();
            return 0;
        }
    }

    public function editar($post, $id, $itensCadastrados) {
        $post['st_cnpj'] = $this->tratamentoDados->ajustarCnpjCpfParaBanco($post['st_cnpj']);
        $post = $this->tratamentoDados->ajustarFormatosDeDadosParaBanco($post);
        
        $itensSelecionados = $this->itensSelecionadosParaNotaFiscal($post);

        $erros = $this->validacao($post, $itensSelecionados);

        if (count($erros) > 0) {
            return $erros;
        }

        try {
            $this->conexaoBD->beginTransaction();

            $notaFiscal = $this->notasFiscaisDao->editar($post, $id);
            $itens = $this->itensValidacoes->editar($itensCadastrados, $itensSelecionados, $id);
            $this->conexaoBD->commit();
            return 1;

        } catch (PDOException $e) {
            $this->conexaoBD->rollback();
            return 0;
        }
    }

    public function confirmarNotaFiscal($id, $itensCadastrados) {
        $situacaoNotaFiscal = "C";
        $this->conexaoBD->beginTransaction();

        try {
            $notaFiscal = $this->notasFiscaisDao->confirmarNotaFiscal($id, $situacaoNotaFiscal);
            $esqoque = $this->estoquesValidacoes->verificaItemEstoque($itensCadastrados);
            $this->conexaoBD->commit();
            return 1;
        } catch (PDOException $e) {
            $this->conexaoBD->rollback();
            return 0;
        }
    }

    public function buscarNotaFiscal($id) {
        try {
            $notaFiscal = $this->notasFiscaisDao->buscarNotaFiscal($id);
            return $this->tratamentoDados->ajustarFormatosDeDadosParaTela($notaFiscal);
        } catch (Exception $e) {
            return 0;
        }
    }

    public function itensSelecionadosParaNotaFiscal($post) {
        $itens = array();
        $x = 0;

        foreach ($post as $k => $d) {
            $c = explode('-', $k);

            if ($c[0] == 'nr_quantidade') {
                $produto_id = $c[1];
                $nr_quatidade = $d;
                $x++;
            }

            if ($c[0] == 'vl_valor_unitario') {
                $vl_valor_unitario = $d;
                $x++;
            }

            if ($c[0] == 'vl_valor_total') {
                $vl_valor_total = $d;
                $x++;
            }

            if ($c[0] == 'st_produto') {
                $st_produto = $d;
                $x++;
            }

            if ($x == 4) {
                $itens[] = ['produto_id' => $produto_id, 'nr_quantidade' => $nr_quatidade, 'vl_valor_unitario' => $vl_valor_unitario, 'vl_valor_total' => $vl_valor_total, 'st_produto' => $st_produto];
                $x = 0;
            }
        }

        return $itens;
    }

    public function validacao($dados, $itensSelecionados) {
        $erros = array();


        //validação do ST_NOME_EMPRESA
        if (empty($dados['st_nome_empresa'])) {
            $erros[] = 'O nome da Empresa deve ser preenchido.';
        }

        if (strlen($dados['st_nome_empresa']) > 100) {
            $erros[] = 'O nome da Empresa não pode ser maior que 100 caracteres.';
        }

        if (!empty($dados['st_nome_empresa']) && strlen($dados['st_nome_empresa']) < 3) {
            $erros[] = 'O nome da Empresa não pode ser menor que 3 caracteres.';
        }

        if (is_numeric($dados['st_nome_empresa'])) {
            $erros[] = 'O nome da Empresa não pode ser numérico.';
        }

        //validação do ST_CNPJ
        if (empty($dados['st_cnpj'])) {
            $erros[] = 'O CNPJ deve ser preenchido.';
        }

        if (strlen($dados['st_cnpj']) > 14 || strlen($dados['st_cnpj']) < 14) {
            $erros[] = 'O CNPJ deve ter 14 digitos.';
        }

        if (!is_numeric($dados['st_cnpj'])) {
            $erros[] = 'O CNPJ deve ser numérico.';
        }

        //validação do NR_NOTA
        if (empty($dados['nr_nota'])) {
            $erros[] = 'O Número da Nota Fiscal deve ser preenchido.';
        }

        if (strlen($dados['nr_nota']) > 11) {
            $erros[] = 'O Número da Nota Fiscal não pode ser maior que 11 caracteres.';
        }

        if (!empty($dados['nr_nota']) && strlen($dados['nr_nota']) < 3) {
            $erros[] = 'O Número da Nota Fiscal não pode ser menor que 3 caracteres.';
        }

        if (!is_numeric($dados['nr_nota'])) {
            $erros[] = 'O Número da Nota Fiscal deve ser numérico.';
        }

        //validação do ST_OBSERVACAO
        if (strlen($dados['st_observacao']) > 200) {
            $erros[] = 'O campo Obeservação não pode ser maior que 200 caracteres.';
        }

        if (!empty($dados['st_observacao']) && strlen($dados['st_observacao']) < 3) {
            $erros[] = 'O campo Obeservação não pode ser menor que 3 caracteres.';
        }

        //validação do VL_VALOR_TOTAL_NOTA
        if (empty($dados['vl_valor_total_nota'])) {
            $erros[] = 'O Valor Total da Nota Fiscal deve ser preenchido.';
        }

        if (strlen($dados['vl_valor_total_nota']) > 11) {
            $erros[] = 'O Número da Nota Fiscal não pode ser maior que 11 caracteres.';
        }

        if (!empty($dados['vl_valor_total_nota']) && strlen($dados['nr_nota']) < 3) {
            $erros[] = 'O Valor Total da Nota Fiscal não pode ser menor que 3 dígitos.';
        }

        //validação do DT_COMPRA
        if (empty($dados['dt_compra'])) {
            $erros[] = 'A Data da Compra deve ser preenchido.';
        }

        if (strtotime($dados['dt_compra']) > strtotime($dados['dt_emissao_nota'])) {
            $erros[] = 'A Data da Compra não pode ser maior que a Data de Emissão.';
        }

        if (strtotime($dados['dt_compra']) > strtotime(date("Y-m-d"))) {
            $erros[] = 'A Data da Compra não pode ser maior que a Data de Atual.';
        }

        if (!empty($dados['dt_compra'])) {
            $dataCompraValidacao = $this->tratamentoDados->validacaoData($dados['dt_compra']);
            if ($dataCompraValidacao == 0) {
                $erros[] = 'A Data da Compra não é valida.';
            }
        }

        //validação do DT_EMISSAO_NOTA
        if (empty($dados['dt_emissao_nota'])) {
            $erros[] = 'A Data de Emissão da Nota Fiscal deve ser preenchido.';
        }

        if (strtotime($dados['dt_emissao_nota']) > strtotime(date("Y-m-d"))) {
            $erros[] = 'A Data de Emissão da Nota Fiscal não pode ser maior que a Data de Atual.';
        }

        if (!empty($dados['dt_emissao_nota'])) {
            $dataEmisaoValidacao = $this->tratamentoDados->validacaoData($dados['dt_emissao_nota']);
            if ($dataEmisaoValidacao == 0) {
                $erros[] = 'A Data de Emissão da Nota Fiscal não é valida.';
            }
        }

        //mandar para os itensValidacao
        $itensErros = $this->itensValidacoes->validacao($itensSelecionados);

        if (is_array($itensErros)) {
            foreach ($itensErros as $itemErro) {
                $erros[] = $itemErro;
            }
        }

        return $erros;
    }

}

?>
