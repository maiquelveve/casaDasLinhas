<?php
    require_once '../parts/header.php';
    require_once DIR_PARTS . 'menus.php';
    require_once DIR_CONFIG . 'alertsResultados.php';
    require_once DIR_VALIDACOES . 'marcasValidacoes.php';
    
    $id = $_GET['id'];

    $alertsResultados = new AlertsResultados();
    $marcasValidacoes = new MarcasValidacoes();
    $marca = $marcasValidacoes->buscarMarcas($id);
?>

<div class="container my-5">
    <!-- Inicio da ROW da parte de cima -->
    <!--Espçao da tabela parte bem a direita-->
    <h1 class="my-4">Marcas
        <small>Excluir</small>
    </h1>
    <?php 
        if (isset($_SESSION['excluir-menssagem']) && !empty($_SESSION['excluir-menssagem'])) {
            echo '<div id="div-mensagemResultados">'. $_SESSION['excluir-menssagem'] .'</div>';
            unset($_SESSION['excluir-menssagem']);
        } 
    ?>
    <form method="post" action="excluirMarca.php?id=<?=$id?>">
        <div class="form-row">
            <div class="form-group col-md-7">
                <label>Marca</label>
                <input class="form-control" id="st_marca" name="st_marca" value="<?php echo $marca['st_marca']?>" placeholder="Informe o Nome da Marca">
            </div>
        </div>    
        <button type='submit' class="btn btn-danger"> Excluir</button>
        <a href="pesquisar.php"><button type='button' id="button-novoProdutos" class="btn btn-info"> Voltar</button></a>
    </form>	
</div>

<?php
    require_once DIR_PARTS . 'footer.php';
?>

