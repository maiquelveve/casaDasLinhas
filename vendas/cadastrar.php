<?php
    require_once '../parts/header.php';
    require_once DIR_PARTS.'menus.php';
    require_once DIR_VALIDACOES.'vendasValidacoes.php';
    require_once DIR_CONFIG.'alertsResultados.php';

    $post = filter_input_array(INPUT_POST);

    $vendasValidacao = new VendasValidacoes();
    $alertsResultados = new AlertsResultados();

    $itensSelecionados = array();

    if(isset($post) && !empty($post)) {
        $vendas = $vendasValidacao->cadastrar($post);
        $mensagem = $alertsResultados->mensagemResultados($vendas, 'Venda', 'Cadastrada');
    }

    //variavel para analisar se já foi salvo o registro no banco, caso sim troca o botão salvar por criar no registro
    (isset($vendas) && !is_array($vendas) ?  $trocaBotao = 'cadastrado'  :  $trocaBotao = 'naoCadastrado');
?>

<div class="container my-5">
    <!-- Inicio da ROW da parte de cima -->
    <!--Espçao da tabela parte bem a direita-->
    <h1 class="my-4">Vendas
        <small>Cadastrar</small>
    </h1>
    <?php
        if (isset($mensagem) && !empty($mensagem)) {
            echo '<div id="div-mensagemResultados">'. $mensagem .'</div>';
        }
    ?>
    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-2">
                <label>Data</label>
                <input class="form-control" id="dt_venda" name="dt_venda" value="<?php echo date('d/m/Y')?>" disabled>
            </div>
            <div class="form-group col-md-3">
                <label>Valor da Venda</label>
                <input class="form-control mask-dinheiro" id="vl_venda_valor_total" name="vl_venda_valor_total" value="0,00" placeholder="" readonly>
            </div>
        </div>

        <!--parte que mostra os itens selecionados da venda-->
        <div class="form-row">
            <div class="form-group col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title d-inline">Itens da Venda</h4>                                                
                        <div class="row mt-2">
                            <input class="col-md-10 mx-3 form-control" id="st_codigo_barra" name="st_codigo_barra" value="st_codigo_barra" placeholder="Código de Barras" >
                            <button type="button" class="btn btn-primary mx-4 col-md-1" id="addNovoItemVenda" data-toggle="modal" data-target="#modalSelecionaItemVenda" href="#">
                               <i class="fa fa-search"></i>
                            </button>                            
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table" id="table-itens-venda">
                            <thead>
                                <tr class="text-center row">
                                    <th class="col-md-1">#</th>
                                    <th class="col-md-2">Produto</th>
                                    <th class="col-md-2">Valor Unitário</th>
                                    <th class="col-md-1">Estoque</th>
                                    <th class="col-md-2">Quantidade</th>
                                    <th class="col-md-2">Valor</th>
                                    <th class="col-md-2">Ações</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-item">
                            <!--tr é carregada via ajax-->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!--botoes-->
        <?php if ($trocaBotao != 'cadastrado') { ?>
            <button type='submit' class="btn btn-success"> Salvar</button>
        <?php } else { ?>
            <a href="cadastrar.php"><button type='button' id="button-novaVenda" class="btn btn-dark"><i class="fa fa-plus-circle"></i> Cadastra Uma Nova Venda</button></a>
            <a href="editar.php?id=<?php echo $vendas?>"><button type='button' id="button-editarVenda" class="btn btn-success"><i class="fa fa-pencil-alt"></i> Editar Sua Ultima Venda</button></a>
            <a href="confirmarVenda.php?id=<?php echo $vendas?>"><button type='button' id="button-confirmarVenda" class="btn btn-warning"><i class="fa fa-handshake"></i> Confirmar/Cancelar Sua Ultima Venda</button></a>
        <?php } ?>
        <a href="pesquisar.php"><button type='button' id="button-pesquisarVendas" class="btn btn-info"> Voltar</button></a>
    </form>
</div>

<?php
    require_once DIR_PARTS.'footer.php';
?>

<!--Modal para selecionar o produto da venda-->
<div class="modal fade" id="modalSelecionaItemVenda" tabindex="-1" role="dialog" aria-labelledby="modalSelecionaItem" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Adicionar um Item</h5>
                <button type="button" class="close btn-fechar-modal-addItem-venda" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBodyItensSelecaoVenda">
                <!--Popula o a relação dos produtos para seleção-->
            </div>
            <div class="modal-footer">
                <button type="button" id="addItem-venda" class="btn btn-success" disabled>Adicionar Item</button>
                <button type="button" id="btn-fechar-modal-addItem-venda" class="btn btn-dark btn-fechar-modal-addItem-venda" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>