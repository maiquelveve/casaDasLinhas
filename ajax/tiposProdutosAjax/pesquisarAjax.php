<?php
    require_once '../../config/constantes.php';
    require_once DIR_VALIDACOES . 'tiposProdutosValidacoes.php';
    
    $tiposProdutosValidades = new TiposProdutosValidacoes();
    $tiposProdutos = $tiposProdutosValidades->pesquisar($_POST);
    
?>
<br>
<div>
    <?php if(!empty($tiposProdutos)) :?>
        <table class="table table-striped table-hover ">
            <thead class="thead-light">
                <th class="text-center">#</th>
                <th class="text-center">Nome</th>
                <th class="text-center">Informações Adicionais</th>
                <th class="text-center">Ações</th>
            </thead>
            <tbody>
                <?php foreach ($tiposProdutos as $tipoProduto) : ?>
                    <tr>
                        <td class="text-center"><?php echo $tipoProduto['id']?></td>
                        <td class="text-center"><?php echo $tipoProduto['st_descricao']?></td>
                        <td class="text-center"><?php echo ($tipoProduto['ch_informacao_adicionais'] == 'S' ? 'SIM' : 'NÃO')?></td>
                        <td class="text-center">
                            <a class="btn btn-success" href="editar.php?id=<?php echo $tipoProduto['id']?>"><i class="fa fa-pencil-alt"></i></a>
                            <a class="btn btn-danger" href="excluir.php?id=<?php echo $tipoProduto['id']?>"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr> 
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : echo "Nenhum produto encontra na pesquisa."; ?>
    <?php endif; ?>
</div>