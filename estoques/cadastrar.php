<?php
    require_once '../parts/header.php';
    require_once DIR_PARTS . 'menus.php';
    require_once DIR_CONFIG . 'alertsResultados.php';
    require_once DIR_VALIDACOES . 'estoquesValidacoes.php';

    $post = filter_input_array(INPUT_POST);

    $estoquesValidacoes = new EstoquesValidacoes();
    $alertsResultados = new AlertsResultados();

    if (isset($post) && !empty($post)) {
        $itens[] = ['produto_id' => $_GET['id'], 'nr_quantidade' => $post['nr_quantidade']];
        
        $estoque = $estoquesValidacoes->verificaItemEstoque($itens);
        $mensagem = $alertsResultados->mensagemResultados($estoque, 'Estoque', 'Cadastrar');
    }

    //variavel para analisar se já foi salvo o registro no banco, caso sim troca o botão salvar por criar no registro
    (isset($estoque) && !is_array($estoque) ?  $trocaBotao = 'cadastrado'  :  $trocaBotao = 'naoCadastrado');
?>

<div class="container my-5">
    <!-- Inicio da ROW da parte de cima -->
    <!--Espçao da tabela parte bem a direita-->
    <h1 class="my-4">Estoques
        <small>Cadastrar</small>
    </h1>
    <?php
        if (isset($mensagem) && !empty($mensagem)) {
            echo '<div id="div-mensagemResultados">'. $mensagem .'</div>';
        }
    ?>
    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Quantidade</label>
                <input class="form-control" id="nr_quantidade" name="nr_quantidade" value="<?php echo (isset($post['nr_quantidade']) && !empty($post['nr_quantidade']) ? $post['nr_quantidade'] : '')?>" placeholder="Informe a quantidade">
            </div>
            <div class="form-group col-md-12">
                <?php if ($trocaBotao != 'cadastrado') { ?>
                    <button type='submit' class="btn btn-success"> Salvar</button>
                <?php } else { ?>
                    <a href="cadastrar.php"><button type='button' class="btn btn-dark"><i class="fa fa-plus-circle"></i> Cadastra Uma Nova Marca</button></a>
                <?php } ?>
                <a href="pesquisar.php"><button type='button' id="button-novoProdutos" class="btn btn-info"> Voltar</button></a>
            </div>
        </div>
    </form>
</div>

<?php
    require_once DIR_PARTS . 'footer.php';
?>

