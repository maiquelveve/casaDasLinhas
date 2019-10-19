<?php
    require_once '../../config/constantes.php';
    require_once DIR_VALIDACOES.'vendasValidacoes.php';
    require_once DIR_VALIDACOES.'vendasProdutosValidacoes.php';
    require_once DIR_CONFIG.'tratamentoDados.php';

    $id = $_POST['id'];

    $vendasValidacao = new VendasValidacoes();
    $vendasProdutosValidacoes = new vendasProdutosValidacoes();
    $tratamentoDados = new TratamentoDados();

    $venda = $vendasValidacao->buscarVenda($id);
    $itensCadastrados = $vendasProdutosValidacoes->buscarItensVenda($id);
?>

<form>
    <div class="form-row">
        <div class="form-group col-md-5">
            <label>Situação da Venda</label>
            <input class="form-control" id="" name="" value="<?php switch ($venda['st_situacao']) {case 'C': echo'Venda Confirmada'; break; case 'Nc': echo'Venda Não Confirmada'; break; case 'Ca': echo'Venda Cancelada'; break;}?>" disabled>
            <input type="hidden" class="form-control" id="venda_id" name="venda_id" value="<?php echo $venda['id']?>">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-2">
            <label>Data</label>
            <input class="form-control" id="dt_venda" name="dt_venda" value="<?php echo $venda['dt_venda']?>" disabled>
        </div>
        <div class="form-group col-md-3">
            <label>Valor da Venda</label>
            <input class="form-control mask-dinheiro" id="vl_venda_valor_total" name="vl_venda_valor_total" value="<?php echo $venda['vl_venda_valor_total']?>" placeholder="Informe o Valor da Venda" disabled>
        </div>
    </div>

    <!--parte que mostra os itens selecionados da venda-->
    <div class="form-row">
        <div class="form-group col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title d-inline">Itens da Venda</h4>
                </div>
                <div class="card-body">
                    <table class="table" id="table-itens-venda">
                        <thead>
                            <tr class="text-center row">
                                <th class="col-md-1">#</th>
                                <th class="col-md-3">Produto</th>
                                <th class="col-md-4">Valor Unitário</th>
                                <th class="col-md-2">Quantidade</th>
                                <th class="col-md-2">Valor</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-item">
                        <?php foreach ($itensCadastrados as $item) :?>
                            <?php $item = $tratamentoDados->ajustarFormatosDeDadosParaTela($item); ?>
                            <tr class="text-center row" id="<?php echo $item['id']?>">
                                <td class="col-md-1"><?php echo $item['id']?></td>
                                <td class="col-md-3"><?php echo $item['st_produto']?></td>
                                <td class="col-md-4"><?php echo $item['vl_valor_venda']?></td>
                                <td class="col-md-2"><?php echo $item["nr_quantidade_venda"]?></td>
                                <td class="col-md-2"><?php echo $item["vl_item_venda"]?></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php if($venda['st_situacao'] == "Nc") : ?>
    <div class="form-row">
        <div class="form-group col-md-12">
        <label>Quer confirmar/cancelar esta venda?</label>
        <a href="../vendas/confirmarVenda.php?id=<?php echo$id?>" class="btn btn-success">Analisar Venda</a>
        </div>
    </div>
    <?php endif; ?>
</form>
