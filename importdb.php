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

		if(isset($linha[2]) && !empty($linha[2])) {
			$linha[2] = str_replace('.', '', $linha[2]);
		}	

		if(isset($linha[2]) && empty($linha[2])) { 
			$linha[2] = 1;
		}

		echo '<pre>';
			print_r($linha);
		echo '</pre>';	
	}
	
	die;
?>