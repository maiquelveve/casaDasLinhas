<?php
	require_once "../../config/constantes.php";
	require_once DIR_VALIDACOES . "notasFiscaisValidacoes.php";
	require_once DIR_VALIDACOES . "itensValidacoes.php";

	$nota_id = $_POST['id'];

	$notasFiscaisValidacoes = new notasFiscaisValidacoes();
	$itensValidacoes = new itensValidacoes();

	$notaFiscal = $notasFiscaisValidacoes->buscarNotaFiscal($nota_id);
	$itensNotaFiscal = $itensValidacoes->buscarItensdaNotaFiscal($nota_id);


?>

<form method="post">
    <input type="hidden" id="nota_id" value="<?= $nota_id ?>"/>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label>Numero da Nota</label>
            <input class="form-control" id="nr_nota" name="nr_nota" value="<?php echo $notaFiscal['nr_nota'] ?>" disabled>
        </div>
        <div class="form-group col-md-4">
            <label>Situação da Nota</label>
            <input class="form-control" id="nr_nota" name="st_situação" value="<?php echo ($notaFiscal['st_situacao'] == 'C' ? 'Confirmada' : 'Solicitada') ?>" disabled>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-8">
            <label>Empresa</label>
            <input class="form-control" id="st_nome_empresa" name="st_nome_empresa" value="<?php echo $notaFiscal['st_nome_empresa'] ?>" disabled>
        </div>
    	<div class="form-group col-md-4">
            <label>CNPJ</label>
            <input class="form-control mask-cnpj-ajaxVisualizar" id="st_cnpj" name="st_cnpj" value="<?php echo $notaFiscal['st_cnpj'] ?>" disabled>
        </div>
    </div>
    <div class="form-row">
    	<div class="form-group col-md-4">
            <label>Valor</label>
            <input class="form-control" id="vl_valor_total_nota" name="vl_valor_total_nota" value="<?php echo $notaFiscal['vl_valor_total_nota'] ?>" disabled>
        </div>
        <div class="form-group col-md-4">
            <label>Data da Compra</label>
            <input class="form-control" id="dt_compra" name="dt_compra" value="<?php echo $notaFiscal['dt_compra'] ?>" disabled>
        </div>
        <div class="form-group col-md-4">
            <label>Data de Emissão</label>
            <input class="form-control" id="dt_emissao_nota" name="dt_emissao_nota" value="<?php echo $notaFiscal['dt_emissao_nota'] ?>" disabled>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label>Observação</label>
            <textarea class="form-control" rows="4" cols="15" placeholder="Observações!" name="st_observacao" disabled><?php echo $notaFiscal['st_observacao'] ?></textarea>
        </div>
    </div>

    <!--parte que mostra os itens selecionados da nota-->
    <div class="form-row">
        <div class="form-group col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title d-inline">Itens da Nota Fiscal</h6>
                </div>
                <div class="card-body">
                    <?php if(isset($itensNotaFiscal) && !empty($itensNotaFiscal)) {?>
                    	<table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Valor Unitário</th>
                                    <th>Valor Total</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-item">
                                <?php foreach ($itensNotaFiscal as $item) : ?>
                                    <tr class="text-center" id="<?php echo $item['id'] ?>">
                                        <td><?php echo $item['produto_id'] ?></td>
                                        <td><?php echo $item['st_produto'] ?></td>
                                        <td><?php echo $item['nr_quantidade'] ?></td>
                                        <td><?php echo $item['vl_valor_unitario'] ?></td>
                                        <td><?php echo $item['vl_valor_total'] ?></td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                    	</table>
                    <?php } else { ?>
                    	<p>Não há itens cadastrados neste nota fiscal.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(".mask-cnpj-ajaxVisualizar").mask("00.000.000/0000-00");
</script>

