<?php
    require_once '../../config/constantes.php';
    require_once DIR_VALIDACOES . 'produtosValidacoes.php';

    //$post = $_POST;
    $produtosValidacoes = new ProdutosValidacoes();
    $produtos = $produtosValidacoes->BuscarTodosProdutos();

?>
<br>
<div>
    <?php if(!empty($produtos)) :?>
        <table class="table table-striped table-hover ">
            <thead class="thead-light">
                <th class="text-center">#</th>
                <th class="text-center">Produto</th>
                <th class="text-center">Marca</th>
                <th class="text-center">Tipo</th>
                <th class="text-center">Ações</th>
            </thead>
            <tbody>
                <?php foreach($produtos as $p) :?>
                    <tr class="text-center" id="<?php echo $p['id']?>">
                        <td><input type="radio" value="<?php echo $p['id']?>" id="produto_id" name="produto_id"></td>
                        <td><?php echo $p['st_produto']?></td>
                        <td><?php echo $p['st_marca']?></td>
                        <td><?php echo $p['st_descricao']?></td>
                        <td class="text-center">
                            <a class="btn btn-primary btn-visualizar-produto" name="" data-toggle="modal" data-target="#visualizar-produto" href="#"><i class="fa fa-search"></i></a>
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    <?php else : echo "Nenhuma Nota encontrada na pesquisa."; ?>
    <?php endif; ?>
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
    $("input[name='produto_id']").click(function(){
        $('#addItem').prop("disabled", false);
    });
</script>

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

