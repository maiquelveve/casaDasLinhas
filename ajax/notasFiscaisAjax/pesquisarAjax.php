<?php
    require_once '../../config/constantes.php';
    require_once DIR_CONFIG.'tratamentoDados.php';
    require_once DIR_VALIDACOES . 'notasFiscaisValidacoes.php';

    $post = $_POST;
    $tratamentoDados = new TratamentoDados();
    $notasFiscaisValidacoes = new NotasFiscaisValidacoes();
    $notas = $notasFiscaisValidacoes->pesquisar($post);

?>
<br>
<div>
    <?php if(!empty($notas)) :?>
        <table class="table table-striped table-hover ">
            <thead class="thead-light">
                <th class="text-center">Nota</th>
                <th class="text-center">Empresa</th>
                <th class="text-center">CNPJ</th>
                <th class="text-center">Itens</th>
                <th class="text-center">Valor</th>
                <th class="text-center">Situação</th>
                <th class="text-center">Ações</th>
            </thead>
            <tbody>
                <?php foreach ($notas as $n) : ?>
                    <?php $n = $tratamentoDados->ajustarFormatosDeDadosParaTela($n)?>
                    <tr id="<?php echo $n['id']?>">
                        <td class="text-center"><?php echo $n['nr_nota']?></td>
                        <td class="text-center"><?php echo $n['st_nome_empresa']?></td>
                        <td class="text-center mask-cnpj-ajaxPesquisar"><?php echo $n['st_cnpj']?></td>
                        <td class="text-center"><?php echo $notasFiscaisValidacoes->quantidadeItensNota($n['id'])?></td>
                        <td class="text-center"><?php echo $n['vl_valor_total_nota']?></td>
                        <td class="text-center"><?php echo ($n['st_situacao'] == 'C' ? 'Confirmada' : 'Solicitada')?></td>
                        <td class="text-center">
                            <a class="btn btn-primary btn-visualizar-nota" name="" data-toggle="modal" data-target="#exampleModalCenter" href="#"><i class="fa fa-search"></i></a>
                            <?php if ($n['st_situacao'] != 'C') { ?>
                                <a class="btn btn-success" href="editar.php?id=<?php echo $n['id']?>"><i class="fa fa-pencil-alt"></i></a>
                                <a class="btn btn-info" href="confirmarNotasFiscais.php?id=<?php echo $n['id']?>"><i class="fas fa-handshake"></i></a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : echo "Nenhuma Nota encontrada na pesquisa."; ?>
    <?php endif; ?>
</div>

<!--Aciona o modal do vizualizar-->
<script>
    //Depois de clicar no botao de vsualizar o produto ele buscar por ajax o produto conforme o ID adaptar PARA NOTAS FISCAIS
    $('.btn-visualizar-nota').click(function(){
        var id = $(this).closest('tr').attr('id');
        $.ajax({
            type: 'POST',
            url: '../ajax/notasFiscaisAjax/visualizarAjax.php',
            data: {id: id},
            success: function(resultado) {
                $('#body-modal-visualizarProduto').html(resultado);
            },
            error: function(){
                alert('Erro no Ajax do Visualizar Produtos');
            }
        });
    });

    $(".mask-cnpj-ajaxPesquisar").mask("00.000.000/0000-00");
</script>

<div class="modal fade " id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Visualizar Nota Fiscal</h5>
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

