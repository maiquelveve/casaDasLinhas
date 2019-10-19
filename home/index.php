<?php
    //includes da página
    require_once '../parts/header.php';
    require_once DIR_PARTS . 'menus.php';
    require_once DIR_VALIDACOES . 'vendasValidacoes.php';
    require_once DIR_CONFIG.'tratamentoDados.php';

    $vendasValidacao = new VendasValidacoes();
    $tratamentoDados = new TratamentoDados();
    $vendas = $vendasValidacao->buscarTodasVendasHoje();
?>
<!-- Pagina toda -->
<div class="container">
    <!-- Inicio da ROW da parte de cima -->
    <!--Espçao da tabela parte bem a direita-->
    <h1 class="my-4">Bem Vindos
        <small>Sistema de Vendas</small>
    </h1>
    <h4 class="my-4">Vendas de Hoje: <small><?php echo date('d/m/Y');?></small></h4>
    <div class="row">
        <?php if(count($vendas) > 0) {?>
        <?php foreach ($vendas as $venda):?>
            <?php
                $venda = $tratamentoDados->ajustarFormatosDeDadosParaTela($venda);
                switch ($venda['st_situacao']) {
                    case "C":
                        $cor = 'primary';
                        $situacao = "Venda Confirmada";
                        break;
                    case "Ca":
                        $cor = 'danger';
                        $situacao = "Venda Cancelada";
                        break;
                    default :
                        $cor = 'warning';
                        $situacao = "Venda Não Analisada";
                        break;
                }
            ?>
        <div class="col-md-3">
            <div class="card border-<?php echo $cor?> mb-3" style="max-width: 15rem;">
                <div class="card-header bg-transparent border-<?php echo $cor?>">
                    <?php echo $situacao?>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Valor: <?php echo $venda['vl_venda_valor_total']?></h5>
                    <p class="card-text">Item: <?php echo $vendasValidacao->quantidadeItensVenda($venda['id'])?></p>
                    <p class="card-text">Pagamento:
                        <?php
                            switch ($venda['st_pagamento']) {
                                case "D":
                                    echo "Dinheiro";
                                    break;
                                case "C":
                                    echo "Cartão";
                                    break;
                                case "M":
                                    echo "Mista";
                                    break;
                                default :
                                    echo "Não Paga";
                                    break;
                            }
                        ?>
                    </p>
                </div>
                <div class="card-footer bg-transparent border-<?php echo $cor?>  text-center">

                    <a class="btn btn-primary btn-visualizar-venda" name="" id="<?php echo $venda['id']?>" data-toggle="modal" data-target="#exampleModalCenter" href="#"><i class="fa fa-search"></i> Visualizar</a>
                </div>
            </div>
        </div>
        <?php endforeach;?>
        <?php } else { echo "Não há vendas até o momento."; }?>
    </div>
    <!-- Fim da ROW da parte de cima -->

    <!-- Inicio da ROW da parte de baixo -->
    <h3 class="my-4"></h3>
    <div class="row">
        <div class="col-md-3 col-sm-6 mb-4">

        </div>
        <div class="col-md-3 col-sm-6 mb-4">

        </div>
        <div class="col-md-3 col-sm-6 mb-4">

        </div>
        <div class="col-md-3 col-sm-6 mb-4">

        </div>
    </div>
  <!-- Fim da ROW da parte de baixo -->
</div>
<!-- fim da página -->
<?php
	require_once DIR_PARTS . 'footer.php';
?>


<!--Jquery para fazer o ajax e buscar o form do visualizarAjax.php e popula no modal-->
<script>
    $('.btn-visualizar-venda').click(function(){
        var venda_id = $(this).attr('id');
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