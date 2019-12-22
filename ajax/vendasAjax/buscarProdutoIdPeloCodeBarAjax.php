<?php
	require_once '../../config/constantes.php';
    require_once DIR_VALIDACOES . 'produtosCodigoBarrasValidacoes.php';

    $produtosCodigoBarrasValidacoes = new produtosCodigoBarrasValidacoes();
    $produto = $produtosCodigoBarrasValidacoes->buscarProutoPeloCodigoBarras($_POST['st_codigo_barra']);
    echo $produto['produto_id'];
?>