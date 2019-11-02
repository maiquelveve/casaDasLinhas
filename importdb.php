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
		$linha[9] = explode(' ', $linha[0]); 

		/*****************************************************************************/

		/* SAIDA */
		echo '<pre>';
			print_r($linha);
		echo '</pre>';	
	}
	
	die;
?>