<?php
    require_once '../parts/header.php';
    require_once DIR_PARTS . 'menus.php';
    require_once DIR_VALIDACOES . 'tiposProdutosValidacoes.php';
    require_once DIR_VALIDACOES . 'produtosValidacoes.php';
    require_once DIR_VALIDACOES . 'marcasValidacoes.php';
    require_once DIR_CONFIG . 'alertsResultados.php';

    //dados do POST
    $post = filter_input_array(INPUT_POST);

    //combo
    $tiposProdutosValidacoes = new TiposProdutosValidacoes();
    $tiposProdutos = $tiposProdutosValidacoes->buscarTiposProdutosCombo();
    $marcasValidacoes = new MarcasValidacoes();
    $marcas = $marcasValidacoes->buscarMarcasCombo();

    //Produtos
    $produtosValidacoes = new ProdutosValidacoes();

    //Mensagens dos Resultados
    $alertsResultados = new AlertsResultados ();

    if(isset($post) && !empty($post)) {
        $produtos = $produtosValidacoes->cadastrar($post);
        $mensagem = $alertsResultados->mensagemResultados($produtos, 'produto','Cadastrar');
    }

    //variavel para analisar se já foi salvo o registro no banco, caso sim troca o botão salvar por criar no registro
    (isset($produtos) && !is_array($produtos) ?  $trocaBotao = 'cadastrado'  :  $trocaBotao = 'naoCadastrado'  );
?>

<div class="container my-5">
    <!-- Inicio da ROW da parte de cima -->
    <!--Espçao da tabela parte bem a direita-->
    <h1 class="my-4">Produtos
        <small>Cadastrar</small>
    </h1>
    <?php
        if (isset($mensagem) && !empty($mensagem)) {
            echo '<div id="div-mensagemResultados">'. $mensagem .'</div>';
        }
    ?>
    <form method="post">
        <div class="form-row">
            <input type="hidden" id="produto_id" value=""/>
            <div class="form-group col-md-4">
                <label>Produto</label>
                <input class="form-control" id="st_produto" name="st_produto" value="<?php echo (isset($post['st_produto']) && !empty($post['st_produto']) ? $post['st_produto'] : '')?>" placeholder="Informe o Nome do Produto">
            </div>
            <div class="form-group col-md-3">
                <label>Tamanho</label>
                <input class="form-control" id="st_tamanho" name="st_tamanho" value="<?php echo (isset($post['st_tamanho']) && !empty($post['st_tamanho']) ? $post['st_tamanho'] : '')?>" placeholder="Informe o Tamanho">
            </div>
            <div class="form-group col-md-2">
                <label>Medida</label>
                <select class="form-control" id="st_medida" name="st_medida">
                    <option value="">Selecione</option>
                    <option value="G"  <?php echo ($post['st_medida'] == 'G' ? 'selected' : '')?>>Grama</option>
                    <option value="KG" <?php echo ($post['st_medida'] == 'KG' ? 'selected' : '')?>>Quilo</option>
                    <option value="M"  <?php echo ($post['st_medida'] == 'M' ? 'selected' : '')?>>Metro</option>
                    <option value="CM" <?php echo ($post['st_medida'] == 'CM' ? 'selected' : '')?>>Centimitro</option>
                    <option value="TM" <?php echo ($post['st_medida'] == 'TM' ? 'selected' : '')?>>Tamanho</option>
                    <option value="ML" <?php echo ($post['st_medida'] == 'ML' ? 'selected' : '')?>>Ml</option>
                    <option value="PC" <?php echo ($post['st_medida'] == 'PC' ? 'selected' : '')?>>Pacote</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Código de Barras</label>
                <input type="text" class="form-control codigo_barra" id="st_codigo_barra" name="st_codigo_barra" value="<?php echo (isset($post['st_codigo_barra']) && !empty($post['st_codigo_barra']) ? $post['st_codigo_barra'] : '')?>" placeholder="Informe o Código de Barra"/>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Tipo de Produto</label>
                <select class="form-control" id="tipo_produto_id" name="tipo_produto_id">
                    <option value="">Selecione o Tipo</option>
                    <?php foreach($tiposProdutos as $tipo) : ?>
                        <option value="<?php echo $tipo['id']?>" <?php echo ($post['tipo_produto_id'] == $tipo['id'] ? 'selected' : '')?>><?php echo $tipo['st_descricao']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-md-5">
                <label>Marca</label>
                <select class="form-control" id="marca_id" name="marca_id">
                    <option value="">Escolha a Marca</option>
                    <?php foreach($marcas as $marca) : ?>
                        <option value="<?php echo $marca['id']?>" <?php echo ($post['marca_id'] == $marca['id'] ? 'selected' : '')?>><?php echo $marca['st_marca']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Valor para Venda</label>
                <input type="text" class="form-control mask-dinheiro" id="vl_valor_venda" name="vl_valor_venda" value="<?php echo (isset($post['vl_valor_venda']) && !empty($post['vl_valor_venda']) ? $post['vl_valor_venda'] : '')?>" placeholder="R$ 0,00"/>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Observação</label>
                <textarea class="form-control" rows="4" cols="15" placeholder="Observações!" name="st_observacao"><?php echo (isset($post['st_observacao']) && !empty($post['st_observacao']) ? $post['st_observacao'] : '')?></textarea>
            </div>
        </div>

        <div id="informacoesAdicionais"></div>

        <?php if ($trocaBotao != 'cadastrado') { ?>
            <button type='submit' class="btn btn-success"> Salvar</button>
        <?php } else { ?>
            <a href="cadastrar.php"><button type='button' id="button-novoProdutos" class="btn btn-dark"><i class="fa fa-plus-circle"></i> Cadastra Um Novo Produto</button></a>
        <?php } ?>
        <a href="pesquisar.php"><button type='button' id="button-novoProdutos" class="btn btn-info"> Voltar</button></a>
    </form>
</div>
<?php
    require_once DIR_PARTS . 'footer.php';
?>