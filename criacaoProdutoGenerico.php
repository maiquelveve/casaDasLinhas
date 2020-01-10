<?php
	$valor = 0.00;
	$nomeProduto = 'Produto Genérico';
	$array = array();	

	//for dos reais
	for($r = 0; $r < 50; $r++) {
		//for dos centavos
		for($c = 0; $c < 20; $c++) {
			$valor = number_format($valor, 2, '.', ',');
			$array[] = [
							'st_produto' => 'Produto Genérico', 
							'vl_valor_venda' => $valor, 
							'st_codigo_barra' => '99' . str_replace('.', '', $valor)
					   ];
			
			$valor += 0.05;
		}
	}	

	//Add o R$ 50,00
	$valor = 50.00;
	$valor = number_format($valor, 2, '.', ',');
	$array[] = [
					'st_produto' => 'Produto Genérico', 
					'vl_valor_venda' => $valor, 
					'st_codigo_barra' => '99' . str_replace('.', '', $valor)
			   ];
			
			

	echo '<pre>';  print_r($array); echo '</pre></br>';		
?>