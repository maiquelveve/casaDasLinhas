<?php
	//Para criar novos registros, altere esse valor para o valor inicial.
	$valor = 0.05;
	$array = array();	

	//for dos reaiscentavos
	for($r = 0; $r < 50; $r++) {
		//for dos 
		for($c = 0; $c < 20; $c++) {
			$valor = number_format($valor, 2, '.', ',');
			$array[] = [
							'st_produto' => 'Produto Genérico - '.'99' . str_replace('.', '', $valor), 
							'vl_valor_venda' => $valor, 
							'marca_id' => 23,
							'tipo_produto_id' => 34,
							'st_observacao' => '',
							'st_tamanho' => '',
							'st_medida' => '',
							'st_codigo_barra' => '99' . str_replace('.', '', $valor)
					   ];
			
			$valor += 0.05;
		}
	}	

	echo '<pre>';  print_r($array); echo '</pre></br>';		
?>