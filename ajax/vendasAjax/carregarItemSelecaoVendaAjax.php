<?php
    require_once '../../config/constantes.php';
    require_once DIR_VALIDACOES . 'produtosValidacoes.php';
    require_once DIR_CONFIG . 'tratamentoDados.php';

    $tratamentoDados = new TratamentoDados(); 
    $produtosValidacoes = new ProdutosValidacoes();
    $produtosVendas = $produtosValidacoes->buscarTodosProdutosParaVenda();
?>
<div class="form-row">
    <div class="form-group col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title d-inline">Itens da Venda</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Produto</th>
                            <th>Valor</th>
                            <th>Estoque</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-item">
                        <?php foreach($produtosVendas as $item) : 
                            $item = $tratamentoDados->ajustarFormatosDeDadosParaTela($item);
                        ?>
                        <tr class="text-center" id="<?php echo $item['id']?>">
                            <td><input type="radio" value="<?php echo $item['id']?>" name="id"></td>
                            <td><?php echo $item['st_produto']?></td>
                            <td><?php echo $item['vl_valor_venda']?></td>
                            <td><?php echo $item['nr_quantidade']?></td>
                            <td>
                                <button class="btn btn-primary btn-visualizar-produto" id="btn-visualizar-produto" data-toggle="modal" data-target="#visualizar-produto" href="#">
                                    <i class="fa fa-search"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!--modal do visualizar produto-->
<div class="modal fade" id="visualizar-produto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Visualizar Produto</h5>
                <button type="button" class="close fecha-modal-visualizar" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="body-modal-visualizarProduto">
                <!--Popula o formulario montado do visualizarAjax-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark fecha-modal-visualizar">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    //Depois de clicar no botao de vsualizar o produto ele buscar por ajax o produto conforme o ID
    $('.btn-visualizar-produto').click(function(){
        var id = $(this).closest('tr').attr('id');
        $.ajax({
            type: 'POST',
            url: '../ajax/produtosAjax/visualizarAjax.php',
            data: {id: id},
            success: function(resultado) {
                $('#body-modal-visualizarProduto').html(resultado);
            },
            error: function(){
                alert('Erro no Ajax do Visualizar Produtos');
            }
        });
    });

    //fecha só o modal do visualzar do produto
    $('.fecha-modal-visualizar').click(function() {
       $('#visualizar-produto').modal('hide');
    });

    //verifica se foi ecolhido algum produto e libera o botão de adicionar o item seleceionado
    $("input[name='id']").click(function(){
        $('#addItem-venda').prop("disabled", false);
    });
</script>