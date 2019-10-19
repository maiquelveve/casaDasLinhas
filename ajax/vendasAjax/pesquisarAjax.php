<?php
    require_once '../../config/constantes.php';
    require_once DIR_CONFIG.'tratamentoDados.php';
    require_once DIR_VALIDACOES.'vendasValidacoes.php';

    $post = $_POST;

    $tratamentoDados = new TratamentoDados();
    $vendasValidacoes = new VendasValidacoes();
    $vendas = $vendasValidacoes->pesquisar($post);
?>
<br>
<div>
    <?php if(!empty($vendas)) :?>
        <table class="table table-striped table-hover ">
            <thead class="thead-light">
                <th class="text-center">#</th>
                <th class="text-center">Data</th>
                <th class="text-center">Valor</th>
                <th class="text-center">Quantidade Itens</th>
                <th class="text-center">Pagamento</th>
                <th class="text-center">Situação</th>
                <th class="text-center">Ações</th>
            </thead>
            <tbody>
                <?php foreach ($vendas as $v) : ?>
                    <?php $v = $tratamentoDados->ajustarFormatosDeDadosParaTela($v)?>
                    <tr id="<?php echo $v['id']?>">
                        <td class="text-center"><?php echo $v['id']?></td>
                        <td class="text-center"><?php echo $v['dt_venda']?></td>
                        <td class="text-center"><?php echo $v['vl_venda_valor_total']?></td>
                        <td class="text-center"><?php echo $vendasValidacoes->quantidadeItensVenda($v['id']) ?></td>
                        <td class="text-center">
                            <?php
                                switch ($v['st_pagamento']) {
                                    case 'C':
                                        echo 'Cartão';
                                        break;
                                    case 'D':
                                        echo 'Dinheiro';
                                        break;
                                    case 'M':
                                        echo 'Misto';
                                        break;
                                    default :
                                        echo 'Não Paga';
                                        break;
                                }?>
                        </td>
                        <td class="text-center">
                            <?php
                                switch ($v['st_situacao']) {
                                    case'Nc':
                                        echo 'Venda Não Confirmada';
                                        break;

                                    case'C':
                                        echo 'Venda Confirmada';
                                        break;

                                    case'Ca':
                                        echo 'Venda Cancelada';
                                        break;
                                }
                            ?>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-primary btn-visualizar-venda" name="" data-toggle="modal" data-target="#exampleModalCenter" href="#"><i class="fa fa-search"></i></a>
                            <?php if($v['st_situacao'] == 'C') :?>
                            <a class="btn btn-info btn-imprimir-NotaFiscal" name="" data-toggle="modal" data-target="#ImprimirNodalNotaFiscal" href="#"><i class="fa fa-print"></i></a>
                            <?php endif;?>
                            <?php if($v['st_situacao'] == 'Nc') :?>
                            <a class="btn btn-success" name="" href="../vendas/editar.php?id=<?php echo $v['id']?>"><i class="fa fa-pencil-alt"></i></a>
                            <a class="btn btn-info" name="" href="../vendas/confirmarVenda.php?id=<?php echo $v['id']?>"><i class="fa fa-handshake"></i></a>
                            <?php endif;?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : echo "Nenhuma venda encontrada na pesquisa."; ?>
    <?php endif; ?>
</div>

<!--Jquery para fazer o ajax e buscar o form do visualizarAjax.php e popula no modal-->
<script>
    $('.btn-visualizar-venda').click(function(){
        var venda_id = $(this).closest('tr').attr('id');

        $.ajax({
            type: 'POST',
            url: '../ajax/vendasAjax/visualizarAjax.php',
            data:{id: venda_id},
            success: function(resultado){
                $('#body-modal-visualizarVenda').html(resultado);
            },
            error: function(){
                alert("Erro no Ajax do Visualizar Venda");
            }
        });
    });
</script>

<!--Modal do Visualizar vendas-->
<div class="modal fade " id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Visualizar Venda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="body-modal-visualizarVenda">
                <!--Popula o formulario montado do visualizarAjax-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


<!--Jquery para fazer o ajax e buscar o form do ImprimirNotaFiscalAjax.php e popula no modal-->
<script>
    $('.btn-imprimir-NotaFiscal').click(function(){
        var venda_id = $(this).closest('tr').attr('id');

        $.ajax({
            type: 'POST',
            url: '../ajax/nrNotasFiscaisAjax/imprimirNotaFiscalAjax.php',
            data:{id: venda_id},
            success: function(resultado){
                $('#body-modal-NotaFiscal').html(resultado);
            },
            error: function(){
                alert("Erro no Ajax do Visualizar Venda");
            }
        });
    });
</script>
<!--Modal do Nota Fiscal vendas-->
<div class="modal fade " id="ImprimirNodalNotaFiscal" tabindex="-1" role="dialog" aria-labelledby="ImprimirNodalNotaFiscalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Nota Fiscal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="body-modal-NotaFiscal">
                <!--Popula o formulario montado do notaFiscalAjax-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info">Imprimir</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>