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

    $itensSelecionados = array();

    if(isset($post) && !empty($post)) {
        $vendas = $vendasValidacao->editar($id, $post);
        $mensagem = $alertsResultados->mensagemResultados($vendas, 'Venda', 'Alterada');
    }

    $venda = $vendasValidacao->buscarVenda($id);
    $itensCadastrados = $vendasProdutosValidacoes->buscarItensVenda($id);
?>

<div class="container my-5">
    <!-- Inicio da ROW da parte de cima -->
    <!--Espçao da tabela parte bem a direita-->
    <h1 class="my-4">Vendas
        <small>Cadastrar</small>
    </h1>
    <?php
        if (isset($mensagem) && !empty($mensagem)) {
            echo '<div id="div-mensagemResultados">'. $mensagem .'</div>';
        }
    ?>
    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-2">
                <label>Data</label>
                <input class="form-control" id="dt_venda" name="dt_venda" value="<?php echo $venda['dt_venda']?>" readonly>
            </div>
            <div class="form-group col-md-3">
                <label>Valor da Venda</label>
                <input class="form-control mask-dinheiro" id="vl_venda_valor_total" name="vl_venda_valor_total" value="<?php echo $venda['vl_venda_valor_total']?>" placeholder="" readonly>
            </div>
        </div>

        <!--parte que mostra os itens selecionados da venda-->
        <div class="form-row">
            <div class="form-group col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title d-inline">Itens da Venda</h4>                                                
                        <div class="row mt-2">
                            <input class="col-md-10 mx-3 form-control codigo_barra" id="st_codigo_barra" name="st_codigo_barra" value="" placeholder="Código de Barras" >
                            <button type="button" class="btn btn-primary mx-4 col-md-1" id="addNovoItemVenda" data-toggle="modal" data-target="#modalSelecionaItemVenda" href="#">
                               <i class="fa fa-search"></i>
                            </button>                            
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table" id="table-itens-venda">
                            <thead>
                                <tr class="text-center row">
                                    <th class="col-md-1">#</th>
                                    <th class="col-md-2">Produto</th>
                                    <th class="col-md-2">Valor Unitário</th>
                                    <th class="col-md-1">Estoque</th>
                                    <th class="col-md-2">Quantidade</th>
                                    <th class="col-md-2">Valor</th>
                                    <th class="col-md-2">Ações</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-item">
                            <!--fazer o forech dos $itensCadastrados e os seus SCRIPTS -->
                            <?php foreach ($itensCadastrados as $item) :?>
                                <?php $item = $tratamentoDados->ajustarFormatosDeDadosParaTela($item); ?>
                                <tr class="text-center row" id="<?php echo $item['id']?>">
                                    <td class="col-md-1"><?php echo $item['id']?></td>
                                    <td class="col-md-2"><?php echo $item['st_produto']?></td>
                                    <td class="col-md-2" attr="vl_unitario_item"><?php echo $item['vl_valor_venda']?></td>
                                    <td class="col-md-1"><?php echo $item['nr_quantidade']?></td>
                                    <td class="col-md-2"><input type="number" class="form-control" name="nr_quantidade_venda-<?php echo $item["id"]?>" id="nr_quantidade_venda_<?php echo $item["id"]?>" value="<?php echo $item["nr_quantidade_venda"]?>" <?php echo ($item['nr_quantidade'] == 0 ? 'readonly' : '')?>></td>
                                    <td class="col-md-2"><input type="text" class="form-control alinha-venda-valor" name="vl_item_venda-<?php echo $item["id"]?>" id="vl_item_venda_<?php echo $item["id"]?>" value="<?php echo $item["vl_item_venda"]?>" readonly></td>
                                    <td class="col-md-2"><button type="button" id="btn-remover-item_<?php echo $item['id']?>" class="btn btn-danger btn-sm btn-remover-item" value="0"><i class="fa fa-trash"></i> Remover</button></td>
                                    <!--input's servem para realizar validações dos itens. st_produto eh para concatenar o nome do item na mensagem e o nr_quantidade para não ser maior a solicitação do que tem em estoque -->
                                    <input type="hidden" name="st_produto-<?php echo $item['id'] ?>" value="<?php echo $item['st_produto'] ?>">
                                    <input type="hidden" name="nr_quantidade-<?php echo $item['id'] ?>" value="<?php echo $item['nr_quantidade'] ?>">

                                    <!--esta dentro da tr para quando remover o item(TR) apagar a tag script junto-->
                                    <script>
                                        $('#btn-remover-item_<?php echo $item['id']?>').click(function() {
                                            var produto_id = $(this).parent().parent()[0].id;

                                            //ao remover um item, aqui diminui o valor total deste item do valor total da venda antes de excluir o item
                                            var valorTotalItensSalvo = $('#vl_item_venda_<?php echo $item["id"]?>').val();
                                            var valorTotalVendaSalvo = $('#vl_venda_valor_total').val();
                                            var valorDiminuidoTotalVenda = diminuirValorTotalDosItemDoValorVendaTotal(valorTotalItensSalvo, valorTotalVendaSalvo);
                                            $('#vl_venda_valor_total').val(valorDiminuidoTotalVenda);

                                            removeItemArray(produto_id);
                                            $(this).parent().parent().remove();
                                        });

                                        $('#nr_quantidade_venda_<?php echo $item["id"]?>').focusout(function() {
                                            //pega o valor total antigo do item e diminui do valor total da venda para deois somar novamente, assim pode haver troca das quantidade dos itens
                                            var valorTotalItensSalvo = $('#vl_item_venda_<?php echo $item["id"]?>').val();
                                            var valorTotalVendaSalvo = $('#vl_venda_valor_total').val();
                                            var valorDiminuidoTotalVenda = diminuirValorTotalDosItemDoValorVendaTotal(valorTotalItensSalvo, valorTotalVendaSalvo);
                                            $('#vl_venda_valor_total').val(valorDiminuidoTotalVenda);

                                            //pega os dados para calcular os valores dos itens e da venda
                                            var qtItem = $('#nr_quantidade_venda_<?php echo $item["id"]?>').val();
                                            var valorUnitarioItem = $(this).closest('tr').find('td[attr="vl_unitario_item"]').text();
                                            var valorTotalVenda = $('#vl_venda_valor_total').val();

                                            var novoValorTotalItens = somarValorTotalDosItem(qtItem, valorUnitarioItem);
                                            var novoValorTotalVenda = somarValorItemNoValorTotalVenda(novoValorTotalItens, valorTotalVenda);

                                            $('#vl_venda_valor_total').val(novoValorTotalVenda);
                                            $('#vl_item_venda_<?php echo $item["id"]?>').val(novoValorTotalItens);
                                        });
                                    </script>
                                </tr>
                            <?php endforeach;?>

                            <!--tr é carregada via ajax-->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <button type='submit' class="btn btn-success"> Salvar</button>
        <a href="confirmarVenda.php?id=<?php echo $id?>"><button type='button' id="button-confirmarVenda" class="btn btn-warning"><i class=""></i> Confirmar/Cancelar Venda</button></a>
        <a href="pesquisar.php"><button type='button' id="button-pesquisarVendas" class="btn btn-info"> Voltar</button></a>
    </form>
</div>

<?php
    require_once DIR_PARTS.'footer.php';
?>

<!--Modal para selecionar o produto da venda-->
<div class="modal fade" id="modalSelecionaItemVenda" tabindex="-1" role="dialog" aria-labelledby="modalSelecionaItem" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Adicionar um Item</h5>
                <button type="button" class="close btn-fechar-modal-addItem-venda" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBodyItensSelecaoVenda">
                <!--Popula o a relação dos produtos para seleção-->
            </div>
            <div class="modal-footer">
                <button type="button" id="addItem-venda" class="btn btn-success" disabled>Adicionar Item</button>
                <button type="button" id="btn-fechar-modal-addItem-venda" class="btn btn-dark btn-fechar-modal-addItem-venda" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

