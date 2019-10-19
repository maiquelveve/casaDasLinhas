<?php
    require_once '../parts/header.php';
    require_once DIR_PARTS.'menus.php';
    require_once DIR_VALIDACOES.'vendasValidacoes.php';
    require_once DIR_VALIDACOES.'vendasProdutosValidacoes.php';
    require_once DIR_CONFIG.'alertsResultados.php';
    require_once DIR_CONFIG.'tratamentoDados.php';

    $post = filter_input_array(INPUT_POST);
    $id = $_GET['id'];

    $vendasValidacao = new VendasValidacoes();
    $alertsResultados = new AlertsResultados();
    $vendasProdutosValidacoes = new vendasProdutosValidacoes();
    $tratamentoDados = new TratamentoDados();

    if(isset($post) && !empty($post)) {
        if (isset($post['btn-confirmarVenda'])) {
            $vendas = $vendasValidacao->confirmarVenda($id,$post);
            $mensagem = $alertsResultados->mensagemResultados($vendas, 'Venda', 'Confirmada');
        } else {
            $vendas = $vendasValidacao->cancelarVenda($id);
            $mensagem = $alertsResultados->mensagemResultados($vendas, 'Venda', 'Cancelada');
        }
    }

    $venda = $vendasValidacao->buscarVenda($id);
    $itensCadastrados = $vendasProdutosValidacoes->buscarItensVenda($id);
?>

<div class="container my-5">
    <!-- Inicio da ROW da parte de cima -->
    <!--Espçao da tabela parte bem a direita-->
    <h1 class="my-4">Vendas
        <small>Confirmar</small>
    </h1>
    <?php
        if (isset($mensagem) && !empty($mensagem)) {
            echo '<div id="div-mensagemResultados">'. $mensagem .'</div>';
        }
    ?>
    <form method="post">
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
                <input class="form-control" id="vl_venda_valor_total" name="vl_venda_valor_total" value="<?php echo $venda['vl_venda_valor_total']?>" placeholder="Informe o Valor da Venda" disabled>
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
                                    <th class="col-md-3">Valor Unitário</th>
                                    <th class="col-md-1">Estoque</th>
                                    <th class="col-md-2">Quantidade</th>
                                    <th class="col-md-2">Valor</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-item">
                            <!--fazer o forech dos $itensCadastrados e os seus SCRIPTS -->
                            <?php foreach ($itensCadastrados as $item) :?>
                                <?php $item = $tratamentoDados->ajustarFormatosDeDadosParaTela($item); ?>
                                <tr class="text-center row" id="<?php echo $item['id']?>">
                                    <td class="col-md-1"><?php echo $item['id']?></td>
                                    <td class="col-md-3"><?php echo $item['st_produto']?></td>
                                    <td class="col-md-3"><?php echo $item['vl_valor_venda']?></td>
                                    <td class="col-md-1"><?php echo $item['nr_quantidade']?></td>
                                    <td class="col-md-2"><?php echo $item["nr_quantidade_venda"]?></td>
                                    <td class="col-md-2"><?php echo $item["vl_item_venda"]?></td>
                                </tr>
                            <?php endforeach;?>

                            <!--tr é carregada via ajax-->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php echo ($venda['st_situacao'] == 'Nc' ? "<button type='button' data-toggle='modal' data-target='#' href='#modalPagamento' class='btn btn-success'> Confirmar Venda</button> <button type='submit' name='btn-cancelarVenda' class='btn btn-danger'> Cancelar Venda</button>" : "" )?>
        <a href="pesquisar.php"><button type='button' id="button-pesquisarVendas" class="btn btn-info"> Voltar</button></a>

        <!--Modal para calcular o troco da venda-->
        <div class="modal fade" id="modalPagamento" tabindex="-1" role="dialog" aria-labelledby="modalPagamento" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pagamento</h5>
                        <button type="button" class="close btn-fechar-modal-pagamento" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modalBodyPagamentoVenda">
                        <!--form para Escolher a forma de pagamento Dinheiro/Cartão-->
                        <div id="escolhaModoPagamento col-md-12">
                            <div class="card bg-light mb-3">
                                <div class="card-header">Modo de Pagamento</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col col-4">
                                            <label class="radio">
                                                <input type="radio" name="st_pagamento" class="pagamento" value="D" id="pgtDinheiro" checked="checked"><i></i> Dinheiro
                                            </label>
                                            <label class="radio">
                                                <input type="radio" name="st_pagamento" class="pagamento" value="C" id="pgtCartao"><i></i> Cartão
                                            </label>
                                            <label class="radio">
                                                <input type="radio" name="st_pagamento" class="pagamento" value="M" id="pgtMisto"><i></i> Misto
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--form para pagamento Dinheiro-->
                        <fieldset>
                            <section>
                                <div id="pagamentoDinheiro">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Valor da Venda</label>
                                            <input type="text" class="form-control alinha-venda-valor" name="vl_venda_valor_total" id="vl_venda_valor_total" value="<?php echo $venda['vl_venda_valor_total']?>" disabled>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Dinheiro</label>
                                            <input type="text" class="form-control mask-dinheiro" name="vl_valor_pago_cliente" id="vl_valor_pago_cliente" value="" placeholder="R$ 0,00">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>TROCO</label>
                                            <input type="text" class="form-control alinha-venda-valor" name="vl_troco" id="vl_troco" value="0,00" disabled>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <button type="button" class="btn btn-warning col-md-12" id="btn-calcular">Calcular</button>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </fieldset>
                        <!--form para pagamento cartão-->
                        <div id="pagamentoCartao">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Valor da Venda</label>
                                    <input type="text" class="form-control mask-dinheiro" name="" id="" value="<?php echo $venda['vl_venda_valor_total']?>" disabled>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Dinheiro</label>
                                    <input type="text" class="form-control mask-dinheiro" name="" id="" value="<?php echo $venda['vl_venda_valor_total']?>" disabled>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>TROCO</label>
                                    <input type="text" class="form-control mask-dinheiro" name="" id="" value="0,00" disabled>
                                </div>
                            </div>
                        </div>
                        <!--form para pagamento misto-->
                        <div id="pagamentoMisto">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Valor da Venda</label>
                                    <input type="text" class="form-control mask-dinheiro" name="" id="vl_valor_venda_total_m" value="<?php echo $venda['vl_venda_valor_total']?>" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Cartão</label>
                                    <input type="text" class="form-control mask-dinheiro" name="" id="vl_valor_pago_cliente_cartao_m" value="" placeholder="R$ 0,00">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Dinheiro</label>
                                    <input type="text" class="form-control mask-dinheiro" name="" id="vl_valor_pago_cliente_dinheiro_m" value="" placeholder="R$ 0,00">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>TROCO</label>
                                    <input type="text" class="form-control mask-dinheiro" name="" id="vl_troco_m" value="0,00" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <button type="button" class="btn btn-warning col-md-12" id="btn-calcular-m">Calcular</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn-ConfirmePagamentoVenda" name='btn-confirmarVenda' class="btn btn-success">confirme</button>
                        <button type="button" id="btn-fechar-modal-pagamento" class="btn btn-dark btn-fechar-modal-pagamento" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<?php
    require_once DIR_PARTS.'footer.php';
?>