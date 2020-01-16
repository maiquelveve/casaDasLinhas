<?php
	require_once './config/constantes.php';
	require_once DIR_VALIDACOES . 'produtosValidacoes.php';
	require_once DIR_VALIDACOES . 'estoquesValidacoes.php';
	require_once DIR_CONEXAOBD  . 'conexaoPDO.php';

	$produtosValidacoes = new ProdutosValidacoes();
	$estoquesValidacoes = new EstoquesValidacoes();	
	$connexaoDB = ConexaoPDO::getInstance();

	$produtosIds = $produtosValidacoes->buscarProdutosIds(3297);

	$qt = 25;
	$item = array();	

	try {
		$connexaoDB->beginTransaction();
		set_time_limit(300);

		foreach ($produtosIds as $produtos_id) {
			$item['produto_id'] = $produtos_id['id'];
			$item['nr_quantidade'] = $qt;

			$estoquesValidacoes->cadastrar($item);
		}

		$connexaoDB->commit();
		echo 'OK';		

	} catch (Exception $e) {
		$connexaoDB->rollback();
		echo 'Houve um erro';		
	}
?>