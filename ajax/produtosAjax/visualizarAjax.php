<?php
    require_once '../../config/constantes.php';
    require_once DIR_VALIDACOES. 'produtosValidacoes.php';
    require_once DIR_CONFIG . 'tratamentoDados.php';

    //id do produto
    $id = $_POST['id'];
    $produtosValidacoes = new ProdutosValidacoes();
    $tratamentoDados = new TratamentoDados();
    $produto = $produtosValidacoes->visualizar($id);
    $produto = $tratamentoDados->ajustarFormatosDeDadosParaTela($produto);
?>

<form method="post">
    <input type="hidden" id="produto_id" value="<?= $id ?>"/>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label>Produto</label>
            <input class="form-control" id="st_produto" name="st_produto" value="<?php echo $produto['st_produto'] ?>" placeholder="Informe o Nome do Produto" disabled>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label>Tamanho</label>
            <input class="form-control" id="st_tamanho" name="st_tamanho" value="<?php echo $produto['st_tamanho'] ?>" placeholder="Informe o Tamanho" disabled>
        </div>
        <div class="form-group col-md-4">
            <label>Medida</label>
            <select class="form-control" id="st_medida" name="st_medida" disabled>
                <option value="">Selecione</option>
                <option value="G"  <?= ($produto['st_medida'] == 'G' ? 'selected' : '') ?>>Grama</option>
                <option value="KG" <?= ($produto['st_medida'] == 'KG' ? 'selected' : '') ?>>Quilo</option>
                <option value="M"  <?= ($produto['st_medida'] == 'M' ? 'selected' : '') ?>>Metro</option>
                <option value="CM" <?= ($produto['st_medida'] == 'CM' ? 'selected' : '') ?>>Centimitro</option>
                <option value="TM" <?= ($produto['st_medida'] == 'TM'? 'selected' : '')?>>Tamanho</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label>Quantidade</label>
            <input class="form-control" id="nr_quatidade_estoque" name="nr_quatidade_estoque" value="<?php echo (is_null($produto['nr_quantidade']) ? 0 : $p['nr_quantidade']) ?>" placeholder="Informe a Quantidade" disabled>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label>Tipo de Produto</label>
            <input class="form-control" id="st_descricao" name="st_descricao" value="<?php echo $produto['st_descricao'] ?>" placeholder="Informe o Tipo de Produto" disabled>
        </div>
        <div class="form-group col-md-4">
            <label>Marca</label>
            <input class="form-control" id="st_marca" name="st_marca" value="<?php echo $produto['st_marca'] ?>" placeholder="Informe a Marca" disabled>
        </div>
        <div class="form-group col-md-4">
            <label>Valor para Venda</label>
            <input type="text" class="form-control" id="vl_valor_venda" name="vl_valor_venda" value="<?php echo $produto['vl_valor_venda'] ?>" placeholder="Informe o Valor" disabled>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label>Observação</label>
            <textarea class="form-control" rows="4" cols="15" placeholder="Observações!" name="st_observacao" disabled><?php echo $produto['st_observacao'] ?></textarea>
        </div>
    </div>

    <?php
    if (isset($produto['ch_informacao_adicionais'])) {
        if ($produto['ch_informacao_adicionais'] == 'S')  {
            echo '<input type=hidden name="ch_informacao_adicionais" id="ch_informacao_adicionais" value="S">';
            switch ($produto['tipo_produto_id']) {
                case 1: ?>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Código da Cor</label>
                            <input class="form-control" id="nr_codigo_cor" name="nr_codigo_cor" value="<?= (isset($produto['nr_codigo_cor']) && !empty($produto['nr_codigo_cor'])) ? $produto['nr_codigo_cor'] : '' ?>" placeholder="Informe a Código da Cor da Linha" disabled>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Cor</label>
                            <input class="form-control" id="st_cor" name="st_cor" value="<?= (isset($produto['st_cor']) && !empty($produto['st_cor'])) ? $produto['st_cor'] : '' ?>" placeholder="Informe a Cor da Linha" disabled>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Número da Linha</label>
                            <input type="text" class="form-control" id="nr_numero_linha" name="nr_numero_linha" value="<?= (isset($produto['nr_numero_linha']) && !empty($produto['nr_numero_linha'])) ? $produto['nr_numero_linha'] : '' ?>" placeholder="Informe o Número da Linha" disabled>
                        </div>
                    </div>
                <?php
                break;

                case 2:
                ?>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Espessura</label>
                            <input class="form-control" id="nr_esoessura_agulha" name="nr_esoessura_agulha" placeholder="Informe a Espessura" disabled>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Tamanho</label>
                            <input class="form-control" id="nr_tamanho_agulha" name="nr_tamanho_agulha" placeholder="Informe Tamanho" disabled>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Utilidade</label>
                            <input type="text" class="form-control" id="st_utilidade" name="st_utilidade" placeholder="Informe a Utilidade" disabled>
                        </div>
                    </div>
                <?php
                break;
            }
        }
    }
    ?>
</form>

