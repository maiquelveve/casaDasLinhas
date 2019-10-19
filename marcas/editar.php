<?php
    require_once '../parts/header.php';
    require_once DIR_PARTS . 'menus.php';
    require_once DIR_CONFIG . 'alertsResultados.php';
    require_once DIR_VALIDACOES . 'marcasValidacoes.php';
    
    $id = $_GET['id'];
    $post = filter_input_array(INPUT_POST);
    
    $marcasValidacoes = new MarcasValidacoes();
    $alertsResultados = new AlertsResultados();
    
    if (isset($post) && !empty($post)) {
        $marcas = $marcasValidacoes->editar($post, $id);
        $mensagem = $alertsResultados->mensagemResultados($marcas, 'Marca', 'Editar');
    }
    
    $marca = $marcasValidacoes->buscarMarcas($id);
?>

<div class="container my-5">
    <!-- Inicio da ROW da parte de cima -->
    <!--Espçao da tabela parte bem a direita-->
    <h1 class="my-4">Marcas
        <small>Editar</small>
    </h1>
    <?php 
        if (isset($mensagem) && !empty($mensagem)) {
            echo '<div id="div-mensagemResultados">'. $mensagem .'</div>';
        } 
    ?>
    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-7">
                <label>Marca</label>
                <input class="form-control" id="st_marca" name="st_marca" value="<?php echo $marca['st_marca']?>" placeholder="Informe o Nome da Marca">
            </div>
        </div>    
        <button type='submit' class="btn btn-success"> Salvar</button>
        <a href="pesquisar.php"><button type='button' id="button-novoProdutos" class="btn btn-info"> Voltar</button></a>
    </form>	
</div>

<?php
    require_once DIR_PARTS . 'footer.php';
?>

