<?php
    require_once '../parts/header.php';
    require_once DIR_PARTS . 'menus.php';
    require_once DIR_CONFIG . 'alertsResultados.php';
    require_once DIR_VALIDACOES . 'marcasValidacoes.php';

    $post = filter_input_array(INPUT_POST);

    $marcasValidacoes = new MarcasValidacoes();
    $alertsResultados = new AlertsResultados();

    if (isset($post) && !empty($post)) {
        $marcas = $marcasValidacoes->cadastrar($post);
        $mensagem = $alertsResultados->mensagemResultados($marcas, 'Marca', 'Cadastrar');
    }

    //variavel para analisar se já foi salvo o registro no banco, caso sim troca o botão salvar por criar no registro
    (isset($marcas) && !is_array($marcas) ?  $trocaBotao = 'cadastrado'  :  $trocaBotao = 'naoCadastrado');
?>

<div class="container my-5">
    <!-- Inicio da ROW da parte de cima -->
    <!--Espçao da tabela parte bem a direita-->
    <h1 class="my-4">Marcas
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
                <label>Marca</label>
                <input class="form-control" id="st_marca" name="st_marca" value="<?php echo (isset($post['st_marca']) && !empty($post['st_marca']) ? $post['st_marca'] : '')?>" placeholder="Informe o Nome da Marca">
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

