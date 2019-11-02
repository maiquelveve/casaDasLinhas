<?php
	$linhaArray = Array();
	$i = 0;
	$file = fopen('./arquivos/EstoquePHP.csv', 'r');
	while (($line = fgetcsv($file)) !== false)
	{
  		if($line[0] != ';;') {
	  		$linhaArray[] = $line;
	  	} 
	}
	fclose($file);

	foreach ($linhaArray as $linha) {
			
		if(count($linha) > 1) {
			$linha[0] = $linha[0]. ' ' . $linha[1];
			unset($linha[1]);
		}

		$linha = explode(';', $linha[0]);

		/*****************************************************************************/

		/*AJUSTANDO O NOME DO PRODUTO*/
		//Aqui retira os espaços em branco entre as palavras e deixa só um
		$linha[0] = preg_replace('/\s+/', ' ', $linha[0]);			

		//Apaga o numero no inicio do nome caso ele exista
		$nomeAux = explode(' ', $linha[0]);
		if(is_numeric($nomeAux[0])) {
			$newName = "";
			for($i = 1; $i < count($nomeAux); $i++){
				$newName .= $nomeAux[$i]. ' ';
			}

			$linha[0] = $newName;
		} 

		/*****************************************************************************/

		/*AJUSTANDO O CODIGO DE BARRA*/
		//Limpa o código de barras
		if(isset($linha[2]) && !empty($linha[2])) {
			$linha[2] = str_replace('.', '', $linha[2]);
		}	
		//Se não possuir código de barras ele atribui 1
		if(isset($linha[2]) && empty($linha[2])) { 
			$linha[2] = 1;
		}

		/*****************************************************************************/

		/*AJUSTANDO O TAMANHO*/
		//fiz na nes
		//Tamanhos
		$tamanho = explode(' ', $linha[0]);

		if($tamanho[1] == 500 || $tamanho[1] == 1000) {
			$linha['tamanho'] = $tamanho[1];
			$linha['medida'] = "M";
		}

		if($tamanho[0] == 'CLEA' && $tamanho[1] == '5' && $tamanho[2] == 'PRATICA') {
			$linha['tamanho'] = 1000;	
			$linha['medida'] = "M";
		}
		
		if(count($tamanho) == 7) {
			if($tamanho[5] == 'SUSI') {
				//$linha[0] = $tamanho[5]. ' ' . $tamanho[6];
				$linha['tamanho'] = 200;
				$linha['medida'] = "M";
			}

			if($tamanho[5] == 'MOLLET') {
				//$linha[0] = $tamanho[5]. ' ' . $tamanho[6];
				$auxT = explode('g', $tamanho[6]);
				$linha['tamanho'] = $auxT[0];
				$linha['medida'] = "G";
			}
		}

		$linha[9] = $tamanho;

		/*****************************************************************************/

		/* SAIDA */
		echo '<pre>';
			print_r($linha);
		echo '</pre>';	
	}
	
	die;
?>