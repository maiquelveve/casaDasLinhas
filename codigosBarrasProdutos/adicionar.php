<?php
    require_once '../parts/header.php';
    require_once DIR_PARTS . 'menus.php';
    require_once DIR_VALIDACOES . 'tiposProdutosValidacoes.php';
    require_once DIR_VALIDACOES . 'produtosValidacoes.php';
    require_once DIR_VALIDACOES . 'marcasValidacoes.php';
    require_once DIR_VALIDACOES . 'estoquesValidacoes.php';
    require_once DIR_VALIDACOES . 'produtosCodigoBarrasValidacoes.php';
    require_once DIR_CONFIG . 'alertsResultados.php';
    require_once DIR_CONFIG . 'tratamentoDados.php';


    //dados do POST
    $post = filter_input_array(INPUT_POST);
    $id = $_GET['id'];

    //combo
    $tiposProdutosValidacoes = new TiposProdutosValidacoes();
    $marcasValidacoes = new MarcasValidacoes();
    $estoqueValidacoes = new EstoquesValidacoes();
    $tratamentoDados = new TratamentoDados();

    $tiposProdutos = $tiposProdutosValidacoes->buscarTiposProdutosCombo();
    $marcas = $marcasValidacoes->buscarMarcasCombo();

    //Produtos
    $produtosValidacoes = new ProdutosValidacoes();
    $produtosCodigoBarrasValidacoes = new ProdutosCodigoBarrasValidacoes();

    if(isset($post) && !empty($post)) {
        $codigosBarrasProdutos = $produtosCodigoBarrasValidacoes->adicionarCodigosBarras($post, $id);
        $alertsResultados = new AlertsResultados();
        $mensagem = $alertsResultados->mensagemResultados($codigosBarrasProdutos, 'Códigos de Barras', 'Salvos');
    }

    //busca o produto selecionado conforme o id
    $produto = $produtosValidacoes->buscarProduto($id);
    $estoque = $estoqueValidacoes->buscarItemDoEstoque($produto['id']);
    $codigosBarras = $produtosCodigoBarrasValidacoes->buscarCodigosBarrasProduto($id);

    $produto = $tratamentoDados->ajustarFormatosDeDadosParaTela($produto);
?>

<div class="container my-5">
    <!-- Inicio da ROW da parte de cima -->
    <!--Espçao da tabela parte bem a direita-->
    <h1 class="my-4">Produtos
        <small>Adicionar Códigos de Barras</small>
    </h1>
    <?php
        if (isset($mensagem) && !empty($mensagem)) {
            echo '<div id="div-mensagemResultados">'. $mensagem .'</div>';
        }
    ?>
    <form method="post">
        <input type="hidden" id="produto_id" value="<?= $id ?>"/>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Produto</label>
                <input class="form-control" id="st_produto" name="st_produto" value="<?php echo $produto['st_produto']?>" placeholder="Informe o Nome do Produto" disabled>
                <input type="hidden" name="produto_id" id="produto_id" value="<?= $id ?>" >                                                
            </div>
            <div class="form-group col-md-3">
                <label>Tamanho</label>
                <input class="form-control" id="st_tamanho" name="st_tamanho" value="<?php echo $produto['st_tamanho']?>" placeholder="Informe o Tamanho" disabled>
            </div>
            <div class="form-group col-md-2">
                <label>Medida</label>
                <select class="form-control" id="st_medida" name="st_medida" disabled>
                    <option value="">Selecione</option>
                    <option value="G"  <?= ($produto['st_medida'] == 'G' ? 'selected' : '')?>>Grama</option>
                    <option value="KG" <?= ($produto['st_medida'] == 'KG'? 'selected' : '')?>>Quilo</option>
                    <option value="M"  <?= ($produto['st_medida'] == 'M' ? 'selected' : '')?>>Metro</option>
                    <option value="CM" <?= ($produto['st_medida'] == 'CM'? 'selected' : '')?>>Centimitro</option>
                    <option value="TM" <?= ($produto['st_medida'] == 'TM'? 'selected' : '')?>>Tamanho</option>
                    <option value="PC" <?= ($produto['st_medida'] == 'TM'? 'selected' : '')?>>Pacote</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Quantidade</label>
                <input class="form-control" id="nr_quatidade_estoque" name="nr_quatidade_estoque" value="<?php echo $estoque['nr_quantidade']?>" placeholder="Informe a Quantidade" disabled>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Tipo de Produto</label>
                <select class="form-control" id="tipo_produto_id" name="tipo_produto_id" disabled>
                    <option value="">Selecione o Tipo</option>
                    <?php foreach($tiposProdutos as $tipo) : ?>
                        <option value="<?php echo $tipo['id']?>" <?= ($produto['tipo_produto_id'] == $tipo['id'] ? ' selected' : '')?>><?php echo $tipo['st_descricao']?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="form-group col-md-5">
                <label>Marca</label>
                <select class="form-control" id="marca_id" name="marca_id" disabled>
                    <option value="">Escolha a Marca</option>
                    <?php foreach($marcas as $marca) : ?>
                        <option value="<?php echo $marca['id']?>" <?php echo ($produto['marca_id'] == $marca['id'] ? 'selected' : '')?>><?php echo $marca['st_marca']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Valor para Venda</label>
                <input type="text" class="form-control mask-dinheiro" id="vl_valor_venda" name="vl_valor_venda" value="<?php echo $produto['vl_valor_venda']?>" placeholder="R$ 0,00" disabled/>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Observação</label>
                <textarea class="form-control" rows="4" cols="15" placeholder="Observações!" name="st_observacao" disabled><?php echo $produto['st_observacao']?></textarea>
            </div>
        </div>
        <div id="informacoesAdicionaisDisabled"></div>

        <!--parte que mostra os códigos de barras cadastrados-->
        <div class="form-row">
            <div class="form-group col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title d-inline">Códigos de Barras</h4>
                        <button type="button" class="btn btn-primary btn-sm" style="float: right" id="addNovoCod" data-toggle="modal" data-target="#modaladdNovoCod" href="#">
                            <i class="fa fa-plus"></i> Adicionar Novo Código
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Código de Barra</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-codigo-barra">
                                <?php $i = 1; ?>
                                <?php if(isset($codigosBarras) && !empty($codigosBarras)) {?>
                                    <?php foreach ($codigosBarras as $cb) : ?>
                                        <tr class="text-center">
                                            <td><?= $i ?></td>            
                                            <td><?= $cb['st_codigo_barra'] ?></td>            
                                            <td style="text-align: right;"><button type="button" class="btn btn-danger btn-sm btn-remover-codBarra"><i class="fa fa-trash-alt"></i> Remover </button></td>                                                
                                            <input type="hidden" name="st_codigo_barra-<?= $i ?>" value="<?= $cb['st_codigo_barra'] ?>" >                                                
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach;?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <button type='submit' class="btn btn-success"> Salvar</button>
        <a href="../produtos/pesquisar.php"><button type='button' id="button-novoProdutos" class="btn btn-info"> Voltar</button></a>
    </form>
</div>

<?php
    require_once DIR_PARTS . 'footer.php';
?>

<!--Modal para add novo código de barra no produto -->
<div class="modal fade" id="modaladdNovoCod" tabindex="-1" role="dialog" aria-labelledby="modaladdNovoCod" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Adicionar um Código de Barra</h5>
                <button type="button" class="close btn-fechar-modal-addItem" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="body-modal-SelecionaItens">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Código de Barra</label>
                        <input class="form-control" id="st_codigo_barra" name="st_codigo_barra" value="" placeholder="Informe o Código de Barra">
                    </div>
                </div>    
            </div>
            <div class="modal-footer">
                <button type="button" id="addCodigoBarra" class="btn btn-success">Adicionar</button>
                <button type="button" id="btn-fechar-modal-addCodigoBarra" class="btn btn-dark btn-fechar-modal-addItem" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    contCodBarra = <?= $i ?>
</script>

<script type="text/javascript">
    let tipoProdutos = $('#tipo_produto_id').val();
    let produto_id = $('#produto_id').val();
    
    buscaInformacaoAdicionaisCamposDisabled(produto_id, tipoProdutos);

</script>