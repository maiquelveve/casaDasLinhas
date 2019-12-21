<?php
	require_once '../../config/constantes.php';
    require_once DIR_VALIDACOES . 'produtosValidacoes.php';

    $produtosValidacoes = new ProdutosValidacoes();
    $produto = $produtosValidacoes->buscarProutoPeloCodigoBarras($_POST['st_codigo_barras']);
    echo $produto;
?>