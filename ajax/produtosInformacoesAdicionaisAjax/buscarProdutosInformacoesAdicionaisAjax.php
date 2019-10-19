<?php
    require_once '../../config/constantes.php';
    require_once DIR_VALIDACOES.'tiposProdutosValidacoes.php';
    require_once DIR_VALIDACOES.'produtosInformacoesAdicionaisValidacoes.php';
    
    $tiposProdutosValidacoes = new TiposProdutosValidacoes();    
    $tiposProdutos = $tiposProdutosValidacoes->buscarTiposProdutos($_POST['tipo_produto_id']);
    
    //se for o EDITAR produtos o Id do produto vem junto e pesquisa as informações adicionais que ele pode ter
    if (isset($_POST['produto_id']) && !empty($_POST['produto_id'])) {
        $produtosInformacoesAdicionais = new ProdutosInformcoesAdicionaisValidacoes();
        $informacoesAdicionais = $produtosInformacoesAdicionais->buscarInformacoesAdicionais($_POST['produto_id']);
    }
    
    if (isset($tiposProdutos['ch_informacao_adicionais'])) { 
        if ($tiposProdutos['ch_informacao_adicionais'] == 'S')  {    
            echo '<input type=hidden name="ch_informacao_adicionais" id="ch_informacao_adicionais" value="S">';       
            switch ($tiposProdutos['id']) { 
                //case da LINHA
                case 6: ?>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Código da Cor</label>
                            <input class="form-control" id="nr_codigo_cor" name="nr_codigo_cor" value="<?= (isset($informacoesAdicionais['nr_codigo_cor']) && !empty($informacoesAdicionais['nr_codigo_cor'])) ? $informacoesAdicionais['nr_codigo_cor'] : '' ?>" placeholder="Informe a Código da Cor da Linha">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Cor</label>
                            <input class="form-control" id="st_cor" name="st_cor" value="<?= (isset($informacoesAdicionais['st_cor']) && !empty($informacoesAdicionais['st_cor'])) ? $informacoesAdicionais['st_cor'] : '' ?>" placeholder="Informe a Cor da Linha">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Número da Linha</label>
                            <input type="text" class="form-control" id="nr_numero_linha" name="nr_numero_linha" value="<?= (isset($informacoesAdicionais['nr_numero_linha']) && !empty($informacoesAdicionais['nr_numero_linha'])) ? $informacoesAdicionais['nr_numero_linha'] : '' ?>" placeholder="Informe o Número da Linha"/>
                        </div>
                    </div>
                <?php
                break;

                //case do BARBANTE
                case 7: ?>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Código da Cor</label>
                            <input class="form-control" id="nr_codigo_cor" name="nr_codigo_cor" value="<?= (isset($informacoesAdicionais['nr_codigo_cor']) && !empty($informacoesAdicionais['nr_codigo_cor'])) ? $informacoesAdicionais['nr_codigo_cor'] : '' ?>" placeholder="Informe a Código da Cor da Linha">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Cor</label>
                            <input class="form-control" id="st_cor" name="st_cor" value="<?= (isset($informacoesAdicionais['st_cor']) && !empty($informacoesAdicionais['st_cor'])) ? $informacoesAdicionais['st_cor'] : '' ?>" placeholder="Informe a Cor da Linha">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Número da Linha</label>
                            <input type="text" class="form-control" id="nr_numero_linha" name="nr_numero_linha" value="<?= (isset($informacoesAdicionais['nr_numero_linha']) && !empty($informacoesAdicionais['nr_numero_linha'])) ? $informacoesAdicionais['nr_numero_linha'] : '' ?>" placeholder="Informe o Número da Linha"/>
                        </div>
                    </div>
                <?php
                break;    

                //case do LINHA
                case 14: ?>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Espessura</label>
                            <input class="form-control" id="nr_esoessura_agulha" name="nr_esoessura_agulha" placeholder="Informe a Espessura">                
                        </div>
                        <div class="form-group col-md-4">
                            <label>Tamanho</label>
                            <input class="form-control" id="nr_tamanho_agulha" name="nr_tamanho_agulha" placeholder="Informe Tamanho">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Utilidade</label>
                            <input type="text" class="form-control" id="st_utilidade" name="st_utilidade" placeholder="Informe a Utilidade"/>
                        </div>
                    </div>
                <?php
                break;

                //Case da Tinta
                case 8: ?>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Código da Cor</label>
                            <input class="form-control" id="nr_codigo_cor" name="nr_codigo_cor" value="<?= (isset($informacoesAdicionais['nr_codigo_cor']) && !empty($informacoesAdicionais['nr_codigo_cor'])) ? $informacoesAdicionais['nr_codigo_cor'] : '' ?>" placeholder="Informe a Código da Cor da Linha">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Cor</label>
                            <input class="form-control" id="st_cor" name="st_cor" value="<?= (isset($informacoesAdicionais['st_cor']) && !empty($informacoesAdicionais['st_cor'])) ? $informacoesAdicionais['st_cor'] : '' ?>" placeholder="Informe a Cor da Linha">
                        </div>
                    </div>
                <?php
                break; 
            }
        }  
    }
?>

