<?php
    require_once '../parts/header.php';
    require_once DIR_PARTS . 'menus.php';
    require_once DIR_VALIDACOES . 'tiposProdutosValidacoes.php';
    require_once DIR_CONFIG . 'alertsResultados.php';

    $alertsResultados = new AlertsResultados();
?>

<div class="container my-5">
    <!-- Inicio da ROW da parte de cima -->
    <!--Espçao da tabela parte bem a direita-->
    <h1 class="my-4">Tipos de Produtos
        <small>Pesquisar</small>
    </h1>
    <?php 
        if (isset($_SESSION['excluir-menssagem']) && !empty($_SESSION['excluir-menssagem'])) {
            echo '<div id="div-mensagemResultados">'. $_SESSION['excluir-menssagem'] .'</div>';
            unset($_SESSION['excluir-menssagem']);
        } 
    ?>
    <form>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Tipo de Produto</label>
                <input type="text" class="form-control" id="st_descricao" name="st_descricao" placeholder="Informe o nome do Tipo de produto"/>
            </div>
        </div>
        <button type='button' id="button-listarTiposProdutos" class="btn btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
        <a href="cadastrar.php"><button type='button' id="button-novoProdutos" class="btn btn-dark"><i class="fa fa-plus-circle"></i> Novo Tipo de Produto</button></a>
    </form>	
    <div class="resultadoPesquisarTiposProdutos div-resultado" id="resultadoPesquisarTiposProdutos"></div>
</div>

<?php
    require_once DIR_PARTS . 'footer.php';
?>

