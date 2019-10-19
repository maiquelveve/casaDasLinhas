<?php
    require_once '../parts/header.php';
    require_once DIR_PARTS . 'menus.php';
    require_once DIR_VALIDACOES . 'tiposProdutosValidacoes.php';
    require_once DIR_VALIDACOES . 'produtosValidacoes.php';
    require_once DIR_VALIDACOES . 'marcasValidacoes.php';
    require_once DIR_VALIDACOES . 'estoquesValidacoes.php';
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

    if(isset($post) && !empty($post)) {
        $produto = $produtosValidacoes->editar($post, $id);
        $alertsResultados = new AlertsResultados();
        $mensagem = $alertsResultados->mensagemResultados($produto, 'produto', 'Editar');
    }

    //busca o produto selecionado conforme o id
    $produto = $produtosValidacoes->buscarProduto($id);
    $estoque = $estoqueValidacoes->buscarItemDoEstoque($produto['id']);

    $produto = $tratamentoDados->ajustarFormatosDeDadosParaTela($produto);
?>

<div class="container my-5">
    <!-- Inicio da ROW da parte de cima -->
    <!--Espçao da tabela parte bem a direita-->
    <h1 class="my-4">Produtos
        <small>Editar</small>
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
                <input class="form-control" id="st_produto" name="st_produto" value="<?php echo $produto['st_produto']?>" placeholder="Informe o Nome do Produto">
            </div>
            <div class="form-group col-md-3">
                <label>Tamanho</label>
                <input class="form-control" id="st_tamanho" name="st_tamanho" value="<?php echo $produto['st_tamanho']?>" placeholder="Informe o Tamanho">
            </div>
            <div class="form-group col-md-2">
                <label>Medida</label>
                <select class="form-control" id="st_medida" name="st_medida">
                    <option value="">Selecione</option>
                    <option value="G"  <?= ($produto['st_medida'] == 'G' ? 'selected' : '')?>>Grama</option>
                    <option value="KG" <?= ($produto['st_medida'] == 'KG'? 'selected' : '')?>>Quilo</option>
                    <option value="M"  <?= ($produto['st_medida'] == 'M' ? 'selected' : '')?>>Metro</option>
                    <option value="CM" <?= ($produto['st_medida'] == 'CM'? 'selected' : '')?>>Centimitro</option>
                    <option value="TM" <?= ($produto['st_medida'] == 'TM'? 'selected' : '')?>>Tamanho</option>
                    <option value="ML" <?= ($produto['st_medida'] == 'ML'? 'selected' : '')?>>Ml</option>
                    <option value="PC" <?= ($produto['st_medida'] == 'PC'? 'selected' : '')?>>Pacote</option>
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
                <select class="form-control" id="tipo_produto_id" name="tipo_produto_id">
                    <option value="">Selecione o Tipo</option>
                    <?php foreach($tiposProdutos as $tipo) : ?>
                        <option value="<?php echo $tipo['id']?>" <?= ($produto['tipo_produto_id'] == $tipo['id'] ? ' selected' : '')?>><?php echo $tipo['st_descricao']?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="form-group col-md-5">
                <label>Marca</label>
                <select class="form-control" id="marca_id" name="marca_id">
                    <option value="">Escolha a Marca</option>
                    <?php foreach($marcas as $marca) : ?>
                        <option value="<?php echo $marca['id']?>" <?php echo ($produto['marca_id'] == $marca['id'] ? 'selected' : '')?>><?php echo $marca['st_marca']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Valor para Venda</label>
                <input type="text" class="form-control mask-dinheiro" id="vl_valor_venda" name="vl_valor_venda" value="<?php echo $produto['vl_valor_venda']?>" placeholder="R$ 0,00"/>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Observação</label>
                <textarea class="form-control" rows="4" cols="15" placeholder="Observações!" name="st_observacao"><?php echo $produto['st_observacao']?></textarea>
            </div>
        </div>
        <div id="informacoesAdicionais"></div>

        <button type='submit' class="btn btn-success"> Salvar</button>
        <a href="pesquisar.php"><button type='button' id="button-novoProdutos" class="btn btn-info"> Voltar</button></a>
    </form>
</div>

<?php
    require_once DIR_PARTS . 'footer.php';
?>