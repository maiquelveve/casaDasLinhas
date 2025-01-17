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
        
        $estoque = $estoquesValidacoes->adicionarQuantidadeEstoque($itens);
        $mensagem = $alertsResultados->mensagemResultados($estoque, 'Estoque', 'Cadastrar');
    }

    $estoque = $estoquesValidacoes->buscarItemDoEstoque($_GET['id']);
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
                <label>Quantidade em Estoque</label>
                <input class="form-control" id="nr_quantidade_atual" name="nr_quantidade_atual" value="<?php echo (!isset($estoque['nr_quantidade']) ? '0' : $estoque['nr_quantidade']) ?>" placeholder="" disabled>
            </div>
            <div class="form-group col-md-6">
                <label>Adicionar no Estoque</label>
                <input class="form-control" id="nr_quantidade" name="nr_quantidade" value="" placeholder="Informe a quantidade">
            </div>
            <div class="form-group col-md-12">
                <button type='submit' class="btn btn-success"> Salvar</button>
                <a href="../produtos/pesquisar.php"><button type='button' id="button-novoProdutos" class="btn btn-info"> Voltar</button></a>
            </div>
        </div>
    </form>
</div>

<?php
    require_once DIR_PARTS . 'footer.php';
?>

