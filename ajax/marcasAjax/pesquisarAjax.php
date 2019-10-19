<?php
    require_once '../../config/constantes.php';
    require_once DIR_VALIDACOES . 'marcasValidacoes.php';
    
    $marcasValidacoes = new MarcasValidacoes();
    $marcas = $marcasValidacoes->pesquisar($_POST);
?>
<br>
<div>
    <?php if(!empty($marcas)) :?>
        <table class="table table-striped table-hover ">
            <thead class="thead-light">
                <th>#</th>
                <th>Marcas</th>
                <th class="text-center" >Ações</th>
            </thead>
            <tbody>
                <?php foreach ($marcas as $m) : ?>
                    <tr>
                        <td><?php echo $m['id']?></td>
                        <td><?php echo $m['st_marca']?></td>
                        <td class="text-center">
                            <a class="btn btn-success" href="editar.php?id=<?php echo $m['id']?>"><i class="fa fa-pencil-alt"></i></a>
                            <a class="btn btn-danger" href="excluir.php?id=<?php echo $m['id']?>"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr> 
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : echo "Nenhum produto encontra na pesquisa."; ?>
    <?php endif; ?>
</div>
