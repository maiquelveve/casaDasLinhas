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
	$cont = 0;
	$r = 0;
	$registros = array();

	foreach ($linhaArray as $linha) {
		
		if($cont > 3694) {
			$cont++;
			continue;
		}

		if($cont >= 3501 && $cont <= 3628) {
			$cont++;
			continue;
		}

		if($cont >= 928 && $cont <= 963) {
			$cont++;
			continue;
		}

		if($cont >= 551 && $cont <= 591) {
			$cont++;
			continue;
		}

		if($cont >= 409 && $cont <= 451) {
			$cont++;
			continue;
		}

		if($cont >= 2044 && $cont <= 2061) {
			$cont++;
			continue;
		}

		if($cont >= 1030 && $cont <= 1108) {
			$cont++;
			continue;
		}

		if($cont >= 1292 && $cont <= 1342) {
			$cont++;
			continue;
		}

		if($cont >= 1352 && $cont <= 1419) {
			$cont++;
			continue;
		}

		if($cont >= 1714 && $cont <= 1717) {
			$cont++;
			continue;
		}

		if($cont >= 1838 && $cont <= 1872) {
			$cont++;
			continue;
		}

		if($cont >= 1873 && $cont <= 1891) {
			$cont++;
			continue;
		}

		if($cont >=  2006 && $cont <= 2043) {
			$cont++;
			continue;
		}

		if($cont >=  2063 && $cont <= 2063) {
			$cont++;
			continue;
		}

		if($cont >= 2064  && $cont <= 2093) {
			$cont++;
			continue;
		}

		if($cont >= 2094  && $cont <= 2116) {
			$cont++;
			continue;
		}

		if($cont >= 2127  && $cont <= 2127) {
			$cont++;
			continue;
		}

		if($cont >= 2141  && $cont <= 2146) {
			$cont++;
			continue;
		}

		if($cont >= 2822  && $cont <= 2836) {
			$cont++;
			continue;
		}

		if($cont >= 3078  && $cont <= 3078) {
			$cont++;
			continue;
		}

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
		
		/*TIRA AS AG*/
		$ag = explode(' ', $linha[0]); 
		if($ag[0] == 'AG' || $ag[1] == 'AG') {
			continue;	
		}

		if(isset($ag[2])) {
			if($ag[2] == 'AG') {
				continue;	
			}
		}

		if($linha[0] == 'SACOLA PROMOCIONAL (50/PCT) ') {
			continue;
		}

		if($linha[0] == 'AGULHA DE BORDADO ') {
			$cont++;
			continue;
		}

		if($linha[0] == 'VAGONITE - 1 METRO ') {
			$cont++;
			continue;
		}

		if($linha[0] == 'VAGONITE ( 1 40x5m ) ') {
			$cont++;
			continue;
		}

		if($linha[0] == 'PANO DE COPA - 1 METRO ') {
			$cont++;
			continue;
		}
		
		if($linha[0] == 'ENTRETELA MAX APLIC 30M ') {
			$cont++;
			continue;
		}

		if($linha[0] == 'PANO DE COPA(70cmx5m) ') {
			$cont++;
			continue;
		}

		if($linha[0] == 'EXPOSITOR MAXI MOULINE-GAVETA ') {
			$cont++;
			continue;
		}

		if($linha[0] == 'ENCANTO ') {
			$cont++;
			continue;
		}

		if($linha[0] == 'ENCANTO SLIM ') {
			$cont++;
			continue;
		}

		if($linha[0] == 'KIT MAXI 300 CORES ') {
			$cont++;
			continue;
		}

		if($linha[0] == 'VERANO ') {
			$cont++;
			continue;
		}

		if($linha[0] == 'PARIS ') {
			$cont++;
			continue;
		}

		if($linha[0] == 'FITA CETIM ROLO N0-4 0MM ') {
			$cont++;
			continue;
		}

		if($linha[0] == 'FITA CETIM ROLO N1-7 0MM ') {
			$cont++;
			continue;
		}

		if($linha[0] == 'FITA CETIM MEADA N1-7 0MM ') {
			$cont++;
			continue;
		}

		if($linha[0] == 'FITA CETIM MEADA N3-15 0MM ') {
			$cont++;
			continue;
		}

		if($linha[0] == 'FITA CETIM MEADA N2-10 5MM ') {
			$cont++;
			continue;
		}

		if($linha[0] == 'FITA CETIM MEADA N5-22 0MM ') {
			$cont++;
			continue;
		}

		if($linha[0] == 'FITA CETIM MEADA N9-38 0MM ') {
			$cont++;
			continue;
		}

		if($linha[0] == 'BASE DE CORTE PATCH 90cm VERD ') {
			$cont++;
			continue;
		}

		if($linha[0] == 'KIT MAXXI RETROS 200 CORES ') {
			$cont++;
			continue;
		}

		if($linha[0] == 'KIT MAXI 300 CORES (6 MEADAS) ') {
			$cont++;
			continue;
		}

		if($linha[0] == 'GUIPURE-5 50cm ') {
			$cont++;
			continue;
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
		//Tamanhos
		$tamanho = explode(' ', $linha[0]);

		if($tamanho[0] == 'FITA') {
			$cont++;
			continue;
		}

		if($tamanho[0] == 'RENDA' && $tamanho[1] == 'ELEGANCE') {
			$cont++;
			continue;
		}

		if($tamanho[0] == 'TECIDO') {
			$cont++;
			continue;
		}

		if($tamanho[0] == 'REVISTA') {
			$cont++;
			continue;
		}

		if($tamanho[0] == 'COLA') {
			$cont++;
			continue;
		}

		if($tamanho[0] == 'RESINA') {
			$cont++;
			continue;
		}

		if($tamanho[0] == 'ALFINETE') {
			$cont++;
			continue;
		}

		if($tamanho[0] == 'BASE') {
			$cont++;
			continue;
		}

		if($tamanho[0] == 'CANETA') {
			$cont++;
			continue;
		}

		if($tamanho[0] == 'CORTADOR') {
			$cont++;
			continue;
		}

		if($tamanho[0] == 'BATIK') {
			$cont++;
			continue;
		}

		if($tamanho[0] == 'CLEINHA') {
			$cont++;
			continue;
		}

		if($tamanho[1] == 500 || $tamanho[1] == 1000 || $tamanho[1] == 125 || $tamanho[1] == 250 || $tamanho[1] == 65) {
			$linha['tamanho'] = $tamanho[1];
			$linha['medida'] = "M";
		}

		if($tamanho[0] == 'CLEA' && $tamanho[1] == '5' && $tamanho[2] == 'PRATICA') {
			$linha['tamanho'] = 1000;	
			$linha['medida'] = "M";
		}

		//ver tamanho
		if($tamanho[0] == 'CHARME') {
			$linha['tamanho'] = 460;	
			$linha['medida'] = "M";
		}

		if($tamanho[0] == 'DUNA') {
			$linha['tamanho'] = 500;	
			$linha['medida'] = "M";
		}
		
		if($tamanho[0] == 'FOFURA') {
			
			$linha['tamanho'] = 1000;
			$linha['medida'] = "M";
		}

		if(count($tamanho) == 3) {
			//ver ines
			if($tamanho[0] == 'SUSI') {
				$linha['tamanho'] = 200;
				$linha['medida'] = "M";
			}

			if($tamanho[0] == 'MOLLET') {
				$auxT = explode('g', $tamanho[1]);
				$linha['tamanho'] = $auxT[0];
				$linha['medida'] = "G";
			}

			
			if($tamanho[0] == 'ANNE' && $tamanho[1] == 'BRILHO') {
				$linha['tamanho'] = 500;
				$linha['medida'] = "M";
			}

			
			if($tamanho[0] == 'RUBI' && $tamanho[1] == '5') {
				$linha['tamanho'] = 500;
				$linha['medida'] = "M";
			}

			//ver tamanho
			if($tamanho[0] == 'LIZA' && $tamanho[1] == 'FINA') {
				$linha['tamanho'] = 500;
				$linha['medida'] = "M";
			}

			//ver tamanho
			if($tamanho[0] == 'LIZA' && $tamanho[1] == 'GROSSA') {
				$linha['tamanho'] = 500;
				$linha['medida'] = "M";
			}
		}

		if(count($tamanho) == 4) {
			if($tamanho[0] == 'MAXI' && $tamanho[1] == 'MOULINE' && $tamanho[2] == 'CIRCULO') {
				$linha[2] = 'Setar na mão o codebar';
				$linha['tamanho'] = 8;
				$linha['medida'] = "M";
			}

			if($tamanho[0] == 'CLARA' && $tamanho[1] == 'BRILHANTE' && $tamanho[2] == 'MULTICOLOR') {
				$linha['tamanho'] = 500;
				$linha['medida'] = "M";
			}

			if($tamanho[0] == 'LIZA' && $tamanho[1] == 'BRILHO' && $tamanho[2] == 'GROSSA') {
				$linha['tamanho'] = 500;
				$linha['medida'] = "M";
			}

			if($tamanho[0] == 'BARROCO' && $tamanho[1] == 'DECORE' && $tamanho[2] == 'MULTICOLOR(ARO') {
				$linha['tamanho'] = 500;
				$linha['medida'] = "M";
			}

			if($tamanho[0] == 'BARROCO' && $tamanho[1] == 'DECORE' && $tamanho[2] == '(ARO)') {
				$linha['tamanho'] = 500;
				$linha['medida'] = "M";
			}

			if($tamanho[0] == 'BARROCO' && $tamanho[1] == 'DECORE' && $tamanho[2] == '(ARO)') {
				$linha['tamanho'] = 500;
				$linha['medida'] = "M";
			}

			if($tamanho[0] == 'MAIS' && $tamanho[1] == 'BEBE' ) {
				$linha['tamanho'] = 500;
				$linha['medida'] = "M";
			}

			if($tamanho[0] == 'BARROCO' && $tamanho[1] == 'NATURAL' && $tamanho[2] == '6' ) {
				$linha['tamanho'] = 500;
				$linha['medida'] = "M";
			}

			if($tamanho[0] == 'BARROCO' && $tamanho[1] == 'MULT.PREMIUM' && $tamanho[2] == '200g' ) {
				$linha['tamanho'] = 200;
				$linha['medida'] = "G";
			}

			if($tamanho[0] == 'BARROCO' && $tamanho[1] == 'NATURAL' && $tamanho[2] == '4' ) {
				$linha['tamanho'] = 400;
				$linha['medida'] = "M";
			}

			if($tamanho[0] == 'BARROCO' && $tamanho[1] == 'NATURAL' && $tamanho[2] == '8' ) {
				$linha['tamanho'] = 800;
				$linha['medida'] = "M";
			}

			if($tamanho[0] == 'BARROCO' && $tamanho[1] == 'NATURAL' && $tamanho[2] == '10' ) {
				$linha['tamanho'] = 1000;
				$linha['medida'] = "M";
			}

			if($tamanho[0] == 'BARROCO' && $tamanho[1] == 'DECORE' && $tamanho[2] == 'LUXO' ) {
				$linha['tamanho'] = 500;
				$linha['medida'] = "M";
			}
		}

		if(count($tamanho) == 5) {

			if($tamanho[0] == 'BARROCO' && $tamanho[1] == 'MULTICOLOR' && $tamanho[2] == '4/6' && $tamanho[3] == '(200g)') {
				$linha['tamanho'] = 200;
				$linha['medida'] = "G";
			}

			//ver ines OURO e PRATA são mesmo tamanho
			if($tamanho[0] == 'ANNE' && $tamanho[1] == 'BRILHO' && $tamanho[2] == 'MULTICOLOR') {
				$linha['tamanho'] = 500;
				$linha['medida'] = "M";
			}

			if($tamanho[0] == 'LINHA' && $tamanho[1] == 'POLIESTER' && $tamanho[2] == 'COSTURA' && $tamanho[3] == '1500J') {
				$linha['tamanho'] = 1371;
				$linha['medida'] = "M";
			}

			if($tamanho[0] == 'ROLO' && $tamanho[1] == 'JUTA' && ($tamanho[2] == 'F9' || $tamanho[2] == 'P9')) {
				$linha['tamanho'] = 20;
				$linha['medida'] = "M";
			}

			if($tamanho[0] == 'BARROCO' && $tamanho[1] == 'MULT.' && $tamanho[2] == 'PREMIUM' && $tamanho[3] == '400g') {
				$linha['tamanho'] = 400;
				$linha['medida'] = "G";
			}

			if($tamanho[0] == 'BARROCO' && $tamanho[1] == 'DECORE' && $tamanho[2] == 'LUXO' && $tamanho[3] == '(MULTI)') {
				$linha['tamanho'] = 500;
				$linha['medida'] = "M";
			}

			if($tamanho[0] == 'BARROCO' && $tamanho[1] == 'MAXCOLOR' && $tamanho[2] == '6' && $tamanho[3] == '(200G)') {
				$linha['tamanho'] = 200;
				$linha['medida'] = "G";
			}

			if($tamanho[0] == 'BARROCO' && $tamanho[1] == 'MAXCOLOR' && $tamanho[2] == 'BRILHO' && $tamanho[3] == '(200G') {
				$linha['tamanho'] = 200;
				$linha['medida'] = "G";
			}

			if($tamanho[0] == 'BARROCO' && $tamanho[1] == 'MAXCOLOR' && $tamanho[2] == '4' && $tamanho[3] == '(200G)') {
				$linha['tamanho'] = 200;
				$linha['medida'] = "G";
			}
		}

		if(count($tamanho) == 6) {

			if($tamanho[0] == 'BARROCO' && $tamanho[1] == 'NATURAL' && $tamanho[2] == '6' && $tamanho[3] == 'BRILHO') {
				$linha['tamanho'] = 500;
				$linha['medida'] = "M";
			}

			if($tamanho[0] == 'BARROCO' && $tamanho[1] == 'MAX' && $tamanho[2] == 'COLOR' && $tamanho[3] == '6' &&  $tamanho[4] == '(400g)') {
				$linha['tamanho'] = 400;
				$linha['medida'] = "G";
			}
		}

		if(count($tamanho) == 7) {

			if($tamanho[0] == 'APOLO' && $tamanho[1] == 'ECO' && $tamanho[2] == '6' && $tamanho[3] == 'REF.600') {
				$linha['tamanho'] = 627;
				$linha['medida'] = "M";
			}

			if($tamanho[0] == 'APOLO' && $tamanho[1] == 'ECO' && $tamanho[2] == '4' && $tamanho[3] == 'REF.600') {
				$linha['tamanho'] = 941;
				$linha['medida'] = "M";
			}

			if($tamanho[0] == 'APOLO' && $tamanho[1] == 'ECO' && $tamanho[2] == '8' && $tamanho[3] == 'REF.600') {
				$linha['tamanho'] = 470;
				$linha['medida'] = "M";
			}
		}

		$linha[9] = $tamanho;
		$linha[10] = $cont++;
		/*****************************************************************************/

		if(trim($linha[0]) == 'BARROCO MAXCOLOR 4 (200G)') {
			$nr_linha = 4;
		} else if(trim($linha[0]) == 'BARROCO MAX COLOR 6 (400g)' || trim($linha[0]) == 'BARROCO MAXCOLOR 6 (200G)') {
			$nr_linha = 6;
		} else {
			$nr_linha = NULL;
		}
		

		$registros[$r]['st_produto'] = $linha[0];
		$registros[$r]['st_codigo_cor'] = $linha[1];
		$registros[$r]['st_codigo_barra'] = $linha[2];
		$registros[$r]['st_tamanho'] = (isset($linha['tamanho']) ? $linha['tamanho'] : NULL);
		$registros[$r]['st_medida'] = (isset($linha['medida']) ? $linha['medida'] : NULL);
		$registros[$r]['nr_numero_linha'] = $nr_linha;
			
		$r++;	

	}

	require_once './config/constantes.php';
	require_once DIR_DAO .'produtosDao.php';
	require_once DIR_VALIDACOES .'produtosInformacoesAdicionaisValidacoes.php';
    require_once DIR_VALIDACOES .'produtosCodigoBarrasValidacoes.php';
    require_once DIR_CONEXAOBD.'conexaoPDO.php';

	$produtosDao = new ProdutosDao();
	$produtosInfoAddValidacao = new ProdutosInformcoesAdicionaisValidacoes();
	$produtosCodigoBarrasValidacoes = new ProdutosCodigoBarrasValidacoes();
	$connexaoDB = ConexaoPDO::getInstance();
	$rig = 0;
		
	try {
		$connexaoDB->beginTransaction();
		set_time_limit(300);
		foreach($registros as $registro) {		
			//cadastro do produto na tabela produto
			$prod = array();
			$prod['st_produto'] = $registro['st_produto'];
			$prod['vl_valor_venda'] = 0;
			$prod['marca_id'] = 12;
			$prod['tipo_produto_id'] = 6;
			$prod['st_observacao'] = '';
			$prod['st_tamanho'] = $registro['st_tamanho'];
			$prod['st_medida'] = $registro['st_medida'];

			$produto = $produtosDao->cadastrar($prod);

			//cadastro da informacoes add do produto na tabela produtos_inforamacoes
			$prodInfAdd = array();
			$prodInfAdd['st_cor'] = 'Não Informado';
			$prodInfAdd['nr_codigo_cor'] = $registro['st_codigo_cor'];
			$prodInfAdd['nr_numero_linha'] = $registro['nr_numero_linha'];

			$produtosInfoAddValidacao->cadastrar($prodInfAdd, $produto);

			//cadastro da informacoes add do produto na tabela produtos_codigo_barra
			$codeBar = $registro['st_codigo_barra'];
			$produtosCodigoBarrasValidacoes->cadastrar($codeBar, $produto);
			$rig++;

			echo '<pre>';
				print_r($registro);
			echo '</pre><br>'. $rig;

			//commit
			if($rig >= 2072) {
				$connexaoDB->commit();
			}
		} 	

	} catch (Exception $e) {
		$connexaoDB->rollback();
		echo 'Houve um erro';
	}
?>