<?php
    require_once '../../config/constantes.php';
    require_once DIR_VALIDACOES . 'produtosValidacoes.php';
    require_once DIR_CONFIG . 'tratamentoDados.php';

    $post = $_POST;
    $produtosValidacoes = new produtosValidacoes();
    $produtos = $produtosValidacoes->pesquisar($post);
    $tratamentoDados = new TratamentoDados();
?>
<br>
<div>
    <?php if(!empty($produtos)) :?>
        <table class="table table-striped table-hover ">
            <thead class="thead-light">
                <th class="text-center">#</th>
                <th class="text-center">Nome</th>
                <th class="text-center">Marca</th>
                <th class="text-center">Tipo</th>
                <th class="text-center">Valor</th>
                <th class="text-center">Quantidade</th>
                <th class="text-center">Ações</th>
            </thead>
            <tbody>
                <?php foreach ($produtos as $p) : ?>
                <?php $p = $tratamentoDados->ajustarFormatosDeDadosParaTela($p);?>
                    <tr id="<?php echo $p['id']?>">
                        <td class="text-center"><?php echo $p['id']?></td>
                        <td class="text-center"><?php echo $p['st_produto']?></td>
                        <td class="text-center"><?php echo $p['st_marca']?></td>
                        <td class="text-center"><?php echo $p['st_descricao']?></td>
                        <td class="text-center"><?php echo $p['vl_valor_venda']?></td>
                        <td class="text-center"><?php echo (is_null($p['nr_quantidade']) ? 0 : $p['nr_quantidade'])?></td>
                        <td class="text-center">
                            <a class="btn btn-success" href="editar.php?id=<?php echo $p['id']?>"><i class="fa fa-pencil-alt"></i></a>
                            <a class="btn btn-primary btn-visualizar-produto" name="" data-toggle="modal" data-target="#exampleModalCenter" href="#"><i class="fa fa-search"></i></a>
                            <a class="btn btn-warning" href="../codigosBarrasProdutos/adicionar.php?id=<?php echo $p['id']?>"><i class="fa fa-barcode"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : echo "Nenhum produto encontra na pesquisa."; ?>
    <?php endif; ?>
</div>

<script>
    //Depois de clicar no botao de vsualizar o produto ele buscar por ajax o produto conforme o ID
    $('.btn-visualizar-produto').click(function(){
        //fazer o ajax pro visualizarAjax o validações e dao estão prontos.
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
</script>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Visualizar Produto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="body-modal-visualizarProduto">
                <!--Popula o formulario montado do visualizarAjax-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>