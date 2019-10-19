<?php
	require_once '../config/constantes.php';
    require_once DIR_CONFIG . 'alertsResultados.php';
    require_once DIR_VALIDACOES . 'marcasValidacoes.php';
    
    $id = $_GET['id'];
    
    $marcasValidacoes = new MarcasValidacoes();
    $alertsResultados = new AlertsResultados();
    
    $marcas = $marcasValidacoes->excluir($id);
    $mensagem = $alertsResultados->mensagemResultados($marcas, 'Marca', 'Excluido');
    
    session_start();
    $_SESSION['excluir-menssagem'] = $mensagem;


    if($marcas == 1) {
    	//retorna OK
    	header('LOCATION: pesquisar.php');
    } else {
    	//retorna ERRO
    	header('LOCATION: excluir.php?id='.$id);
    }
?>