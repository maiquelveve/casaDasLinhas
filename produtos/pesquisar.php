<?php
    require_once '../parts/header.php';
    require_once DIR_PARTS . 'menus.php';
?>

<div class="container my-5">
    <!-- Inicio da ROW da parte de cima -->
    <!--Espçao da tabela parte bem a direita-->
    <h1 class="my-4">Produtos
        <small>Pesquisar</small>
    </h1>
    <form>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Produto</label>
                <input class="form-control" id="st_produto" name="st_produto" placeholder="Informe o produto">
            </div>
            <div class="form-group col-md-6">
                <label>Marca</label>
                <input class="form-control" id="st_marca" name="st_marca" placeholder="Informe a marca">
            </div>
        </div>
        <button type='button' id="button-listarProdutos" class="btn btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
        <a href="cadastrar.php"><button type='button' id="button-novoProdutos" class="btn btn-dark"><i class="fa fa-plus-circle"></i> Novo Produto</button></a>
    </form>
    <div class="resultadoPesquisarProduto div-resultado" id="resultadoPesquisarProduto"></div>
</div>

<?php
    require_once DIR_PARTS . 'footer.php';
?>

