<?php
    require_once '../../config/constantes.php';
    require_once DIR_VALIDACOES . 'produtosValidacoes.php';

    $produtosValidacoes = new ProdutosValidacoes();
    $produto = $produtosValidacoes->BuscarProdutoParaVenda($_POST['produto_id']);
?>

<tr class="text-center row" id="<?php echo $produto['id']?>">
    <td class="col-md-1"><?php echo $produto['id']?></td>
    <td class="col-md-2"><?php echo $produto['st_produto']?></td>
    <td class="col-md-2" attr="vl_unitario_item"><?php echo $produto['vl_valor_venda']?></td>
    <td class="col-md-1"><?php echo $produto['nr_quantidade']?></td>
    <td class="col-md-2"><input type="number" class="form-control" name="nr_quantidade_venda-<?php echo $produto["id"]?>" id="nr_quantidade_venda_<?php echo $produto["id"]?>" value="0" <?php echo ($produto['nr_quantidade'] == 0 ? 'readonly' : '')?>></td>
    <td class="col-md-2"><input type="text" class="form-control alinha-venda-valor" name="vl_item_venda-<?php echo $produto["id"]?>" id="vl_item_venda_<?php echo $produto["id"]?>" value="0" readonly></td>
    <td class="col-md-2"><button type="button" id="btn-remover-item_<?php echo $produto['id']?>" class="btn btn-danger btn-sm btn-remover-item" value="0"><i class="fa fa-trash"></i> Remover</button></td>
    <!--input's servem para realizar validações dos itens. st_produto eh para contatenar o nome do item na mensagem e o nr_quantidade para não ser maior a solicitação do que tem em estoque -->
    <input type="hidden" name="st_produto-<?php echo $produto['id'] ?>" value="<?php echo $produto['st_produto'] ?>">
    <input type="hidden" name="nr_quantidade-<?php echo $produto['id'] ?>" value="<?php echo $produto['nr_quantidade'] ?>">

    <!--esta dentro da tr para quando remover o item(TR) apagar a tag script junto-->
    <script>
        $('#btn-remover-item_<?php echo $produto['id']?>').click(function() {
            var produto_id = $(this).parent().parent()[0].id;

            //ao remover um item, aqui diminui o valor total deste item do valor total da venda antes de excluir o item
            var valorTotalItensSalvo = $('#vl_item_venda_<?php echo $produto["id"]?>').val();
            var valorTotalVendaSalvo = $('#vl_venda_valor_total').val();
            var valorDiminuidoTotalVenda = diminuirValorTotalDosItemDoValorVendaTotal(valorTotalItensSalvo, valorTotalVendaSalvo);
            $('#vl_venda_valor_total').val(valorDiminuidoTotalVenda);

            removeItemArray(produto_id);
            $(this).parent().parent().remove();
        });

        $('#nr_quantidade_venda_<?php echo $produto["id"]?>').focusout(function() {
            //pega o valor total antigo do item e diminui do valor total da venda para deois somar novamente, assim pode haver troca das quantidade dos itens
            var valorTotalItensSalvo = $('#vl_item_venda_<?php echo $produto["id"]?>').val();
            var valorTotalVendaSalvo = $('#vl_venda_valor_total').val();
            var valorDiminuidoTotalVenda = diminuirValorTotalDosItemDoValorVendaTotal(valorTotalItensSalvo, valorTotalVendaSalvo);
            $('#vl_venda_valor_total').val(valorDiminuidoTotalVenda);

            //pega os dados para calcular os valores dos itens e da venda
            var qtItem = $('#nr_quantidade_venda_<?php echo $produto["id"]?>').val();
            var valorUnitarioItem = $(this).closest('tr').find('td[attr="vl_unitario_item"]').text();
            var valorTotalVenda = $('#vl_venda_valor_total').val();

            var novoValorTotalItens = somarValorTotalDosItem(qtItem, valorUnitarioItem);
            var novoValorTotalVenda = somarValorItemNoValorTotalVenda(novoValorTotalItens, valorTotalVenda);

            $('#vl_venda_valor_total').val(novoValorTotalVenda);
            $('#vl_item_venda_<?php echo $produto["id"]?>').val(novoValorTotalItens);
        });
    </script>

    <style>
        .alinha-venda-valor {
            text-align: right;
        }
    </style>
</tr>