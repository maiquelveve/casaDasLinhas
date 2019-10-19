<?php
    require_once '../parts/header.php';
    require_once DIR_PARTS.'menus.php';
    require_once DIR_CONFIG.'alertsResultados.php';
    require_once DIR_VALIDACOES.'notasFiscaisValidacoes.php';
    require_once DIR_VALIDACOES.'itensValidacoes.php';

    //dados do post
    $post = filter_input_array(INPUT_POST);

    //instancia das classes
    $notasFiscaisValidacoes = new NotasFiscaisValidacoes();
    $alertsResultados = new AlertsResultados();
    $itensValidacoes = new ItensValidacoes();

    if(isset($post) && !empty($post)) {
        $notasFiscais = $notasFiscaisValidacoes->cadastrar($post);
        $mensagem = $alertsResultados->mensagemResultados($notasFiscais, 'nota fiscal','Cadastrar');
        $itensSelecionados = $notasFiscaisValidacoes->itensSelecionadosParaNotaFiscal($post);
    }

    //variavel para analisar se já foi salvo o registro no banco, caso sim troca o botão salvar por criar no registro
    (isset($notasFiscais) && !is_array($notasFiscais) ?  $trocaBotao = 'cadastrado'  :  $trocaBotao = 'naoCadastrado');
?>

<div class="container my-5">
    <!-- Inicio da ROW da parte de cima -->
    <!--Espçao da tabela parte bem a direita-->
    <h1 class="my-4">Notas Fiscais
        <small>Cadastrar</small>
    </h1>
    <?php
        if (isset($mensagem) && !empty($mensagem)) {
            echo '<div id="div-mensagemResultados">'. $mensagem .'</div>';
        }
    ?>
    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label>Número da Nota</label>
                <input class="form-control" id="nr_nota" name="nr_nota"  value="<?= ((isset($post['nr_nota']) && !empty($post['nr_nota'])) ? $post['nr_nota'] : '')?>" placeholder="Informe o Número da Notas">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-8">
                <label>Empresa</label>
                <input class="form-control" id="st_nome_empresa" name="st_nome_empresa" value="<?= ((isset($post['st_nome_empresa']) && !empty($post['st_nome_empresa'])) ? $post['st_nome_empresa'] : '')?>" placeholder="Informe o Nome da Empresa">
            </div>
            <div class="form-group col-md-4">
                <label>CNPJ</label>
                <input class="form-control mask-cnpj" id="st_cnpj" name="st_cnpj" value="<?= ((isset($post['st_cnpj']) && !empty($post['st_cnpj'])) ? $post['st_cnpj'] : '')?>" placeholder="Informe o CNPJ da Empresa">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Data da Compra</label>
                <input class="form-control mask-data" id="dt_compra" name="dt_compra" value="<?= ((isset($post['dt_compra']) && !empty($post['dt_compra'])) ? $post['dt_compra'] : '')?>" placeholder="Informe a Data da Compra">
            </div>
            <div class="form-group col-md-4">
                <label>Data de Emissão</label>
                <input class="form-control mask-data" id="dt_emissao_nota" name="dt_emissao_nota" value="<?= ((isset($post['dt_emissao_nota']) && !empty($post['dt_emissao_nota'])) ? $post['dt_emissao_nota'] : '')?>" placeholder="Informe a Data de Emissão">
            </div>
            <div class="form-group col-md-4">
                <label>Valor</label>
                <input class="form-control mask-dinheiro"  id="vl_valor_total_nota" name="vl_valor_total_nota" value="<?= ((isset($post['vl_valor_total_nota']) && !empty($post['vl_valor_total_nota'])) ? $post['vl_valor_total_nota'] : '')?>" placeholder="R$ 0,00"/>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Observação</label>
                <textarea class="form-control" rows="4" cols="15" placeholder="Observações!" name="st_observacao"><?= ((isset($post['st_observacao']) && !empty($post['st_observacao'])) ? $post['st_observacao'] : '')?></textarea>
            </div>
        </div>

        <!--parte que mostra os itens selecionados da nota-->
        <div class="form-row">
            <div class="form-group col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title d-inline">Itens da Nota Fiscal</h4>
                        <button type="button" class="btn btn-primary btn-sm" style="float: right" id="addNovoItem" data-toggle="modal" data-target="#modalSelecionaItem" href="#">
                            <i class="fa fa-plus"></i> Adicionar Novo Item
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Valor Unitário</th>
                                    <th>Valor Total</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-item">
                                <!-- As tr com os itens vem via ajax do carregarItensParaSelecaoAjax.php-->
                                <!--só será executado essa parte depois do post e ser houver um erro-->
                                <?php if(isset($itensSelecionados) && !empty($itensSelecionados)) {?>
                                    <?php foreach ($itensSelecionados as $item) : ?>
                                        <tr class="text-center" id="<?php echo $item['id'] ?>">
                                            <td><?php echo $item['produto_id'] ?></td>
                                            <td><?php echo $item['st_produto'] ?></td>
                                            <td><input type="text" class="form-control form-control-sm" name="nr_quantidade-<?php echo $item['produto_id'] ?>" value="<?php echo $item['nr_quantidade']?>" placeholder="Informe a Quantidade"></td>
                                            <td><input type="text" class="form-control form-control-sm" name="vl_valor_unitario-<?php echo $item['produto_id'] ?>" value="<?php echo $item['vl_valor_unitario']?>" placeholder="Informe o valor unitário"></td>
                                            <td><input type="text" class="form-control form-control-sm" name="vl_valor_total-<?php echo $item['produto_id'] ?>" value="<?php echo $item['vl_valor_total']?>" placeholder="Informe o valor total"></td>
                                            <td><button type="button" class="btn btn-danger btn-sm btn-remover-item"><i class="fa fa-trash-alt"></i> Remover Item</button></td>
                                        </tr>
                                        <input type="hidden" class="form-control form-control-sm" name="st_produto-<?php echo $item['id']?>" value="<?php echo $item['st_produto']?>">
                                    <?php endforeach;?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($trocaBotao != 'cadastrado') { ?>
            <button type='submit' class="btn btn-success"> Salvar</button>
        <?php } else { ?>
            <a href="cadastrar.php"><button type='button' id="button-novoProdutos" class="btn btn-dark"><i class="fa fa-plus-circle"></i> Cadastra Um Nova Nota Fiscal</button></a>
        <?php } ?>
        <a href="pesquisar.php"><button type='button' class="btn btn-info"> Voltar</button></a>
    </form>
</div>
<?php
    require_once DIR_PARTS.'footer.php';
?>

<!--Modal para selecionar o produto da nota fiscal-->
<div class="modal fade" id="modalSelecionaItem" tabindex="-1" role="dialog" aria-labelledby="modalSelecionaItem" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Adicionar um Item</h5>
                <button type="button" class="close btn-fechar-modal-addItem" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="body-modal-SelecionaItens">
                <!--Popula o formulario montado do visualizarAjax-->
            </div>
            <div class="modal-footer">
                <button type="button" id="addItem" class="btn btn-success">Adicionar Item</button>
                <button type="button" id="btn-fechar-modal-addItem" class="btn btn-dark btn-fechar-modal-addItem" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
