<?php
    require_once '../parts/header.php';
    require_once DIR_PARTS . 'menus.php';
    require_once DIR_CONFIG . 'alertsResultados.php';
    require_once DIR_VALIDACOES . 'tiposProdutosValidacoes.php';

    $post = filter_input_array(INPUT_POST);

    $tiposProdutosValidacoes = new TiposProdutosValidacoes();
    $alertsResultados = new AlertsResultados();

    if (isset($post) && !empty($post)) {
        $tiposProdutos = $tiposProdutosValidacoes->cadastrar($post);
        $mensagem = $alertsResultados->mensagemResultados($tiposProdutos, 'Tipo Produto', 'Cadastrar');
        $trocaBotao = 'cadastrado';
    }

    //variavel para analisar se já foi salvo o registro no banco, caso sim troca o botão salvar por criar no registro
    (isset($tiposProdutos) && !is_array($tiposProdutos) ?  $trocaBotao = 'cadastrado'  :  $trocaBotao = 'naoCadastrado'  );
?>

<div class="container my-5">
    <!-- Inicio da ROW da parte de cima -->
    <!--Espçao da tabela parte bem a direita-->
    <h1 class="my-4">Tipos de Produtos
        <small>Cadastrar</small>
    </h1>
    <?php
        if (isset($mensagem) && !empty($mensagem)) {
            echo '<div id="div-mensagemResultados">'. $mensagem .'</div>';
        }
    ?>
    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-7">
                <label>Tipo de Produto</label>
                <input class="form-control" id="st_descricao" name="st_descricao" value="<?php echo (isset($post['st_descricao']) && !empty($post['st_descricao']) ? $post['st_descricao'] : '')?>" placeholder="Informe o Tipo de Produto">
            </div>
            <div class="form-group col-md-5">
                <label>Informações Adicionais</label>
                <select class="form-control" id="ch_informacao_adicionais" name="ch_informacao_adicionais">
                    <option value="">Selecione o Tipo de Produto</option>
                    <option value="S" <?php echo ($post['ch_informacao_adicionais'] == 'S' ? 'selected' : '')?>>SIM</option>
                    <option value="N" <?php echo ($post['ch_informacao_adicionais'] == 'N' ? 'selected' : '')?>>NÃO</option>
                </select>
            </div>
        </div>
        <?php if ($trocaBotao != 'cadastrado') { ?>
            <button type='submit' class="btn btn-success"> Salvar</button>
        <?php } else { ?>
            <a href="cadastrar.php"><button type='button' class="btn btn-dark"><i class="fa fa-plus-circle"></i> Cadastra Um Novo Tipo de Produto</button></a>
        <?php } ?>
        <a href="pesquisar.php"><button type='button' id="button-novoProdutos" class="btn btn-info"> Voltar</button></a>
    </form>
</div>

<?php
    require_once DIR_PARTS . 'footer.php';
?>

