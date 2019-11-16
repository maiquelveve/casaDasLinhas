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
        <!-- escolher o tipo da pesquisa -->
        <div class="from-row mb-2">
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="ch_pesquisar_codigo_barras" name="ch_tipo_pesquisa" checked>
                <label class="custom-control-label" for="ch_pesquisar_codigo_barras">Pesquisa Código de Barras</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="ch_pesquisar_manual" name="ch_tipo_pesquisa">
                <label class="custom-control-label" for="ch_pesquisar_manual">Pesquisa Manual</label>
            </div>
        </div>

        <!-- pesquisar por codigo de barras -->
        <div class="form-row" id="pesquisar-codigo_barra">
            <div class="form-group col-md-12">
                <label>Código de Barra</label>
                <input class="form-control" id="st_codigo_barra" name="st_codigo_barra" value="" placeholder="Informe o Código de Barra">
            </div>
        </div>

        <!-- pesquisar manualmente -->
        <div class="form-row" id="pesquisar-manual" style="display: none">
            <div class="form-group col-md-5">
                <label>Produto</label>
                <input class="form-control" id="st_produto" name="st_produto" placeholder="Informe o produto">
            </div>
            <div class="form-group col-md-5">
                <label>Marca</label>
                <input class="form-control" id="st_marca" name="st_marca" placeholder="Informe a marca">
            </div>
            <div class="form-group col-md-2">
                <label>Tem Código Barra?</label>
                <select class="form-control" id="ch_codeBarra" name="ch_codeBarra">
                    <option value="T">Todos</option>
                    <option value="N">Não</option>
                    <option value="S">Sim</option>
                </select>
            </div>
        </div>

        <button type='button' id="button-listarProdutos" class="btn btn-primary" style="display: none"><i class="fa fa-search"></i> Pesquisar</button>
        <button type='button' id="button-listarProdutosCodigoBarras" class="btn btn-warning ch_pesquisar_codigo_barras"><i class="fa fa-barcode"></i> Pesquisar</button>
        <a href="cadastrar.php"><button type='button' id="button-novoProdutos" class="btn btn-dark"><i class="fa fa-plus-circle"></i> Novo Produto</button></a>
    </form>
    <div class="resultadoPesquisarProduto div-resultado" id="resultadoPesquisarProduto"></div>
</div>

<?php
    require_once DIR_PARTS . 'footer.php';
?>