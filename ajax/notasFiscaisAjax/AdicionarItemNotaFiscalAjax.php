<?php
    require_once '../../config/constantes.php';
    require_once DIR_VALIDACOES . 'produtosValidacoes.php';

    $produtosValidacoes = new ProdutosValidacoes();
    $produto = $produtosValidacoes->buscarProduto($_POST['id']);
?>

<tr class="text-center" id="<?php echo $produto['id']?>">
    <td><?php echo $produto['id']?></td>
    <td><?php echo $produto['st_produto']?></td>
    <td><input class="form-control form-control-sm" name="nr_quantidade-<?php echo $produto['id']?>" placeholder="Informe a Quantidade"></td>
    <td><input class="form-control form-control-sm mask-dinheiro_<?php echo $produto['id']?>" name="vl_valor_unitario-<?php echo $produto['id']?>" placeholder="R$ 0,00"></td>
    <td><input class="form-control form-control-sm mask-dinheiro_<?php echo $produto['id']?>" name="vl_valor_total-<?php echo $produto['id']?>" placeholder="R$ 0,00"></td>
    <td><button type="button" id="btn-remover-item_<?php echo $produto['id']?>" class="btn btn-danger btn-sm btn-remover-item"><i class="fa fa-trash-alt"></i> Remover Item</button></td>

    <input type="hidden" class="form-control form-control-sm" name="st_produto-<?php echo $produto['id']?>" value="<?php echo $produto['st_produto']?>">

    <script>
        $('#btn-remover-item_<?php echo $produto['id']?>').click(function() {
            $(this).parent().parent().remove();
            produto_id = $(this).parent().parent()[0].id;
            removerItem(produto_id);
        });

        $(".mask-dinheiro_<?php echo $produto['id']?>").maskMoney({prefix: 'R$ ', allowNegative: true, thousands: '.', decimal: ',', affixesStay: false});
    </script>
    <style>
        .mask-dinheiro_<?php echo $produto['id']?> {
            text-align: right;
        }
    </style>
</tr>