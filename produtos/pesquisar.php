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
        <button type='button' id="button-listarProdutos" class="btn btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
        <button type='button' id="button-listarProdutosCodigoBarras" class="btn btn-warning" data-toggle="modal" data-target="#modalConsultaCodigoBarras" href="#">
            <i class="fa fa-barcode"></i> Consulta Código de Barras
        </button>
        <a href="cadastrar.php"><button type='button' id="button-novoProdutos" class="btn btn-dark"><i class="fa fa-plus-circle"></i> Novo Produto</button></a>
    </form>
    <div class="resultadoPesquisarProduto div-resultado" id="resultadoPesquisarProduto"></div>
</div>

<?php
    require_once DIR_PARTS . 'footer.php';
?>

<!--Modal para consultar por código de barra o produto -->
<div class="modal fade" id="modalConsultaCodigoBarras" tabindex="-1" role="dialog" aria-labelledby="modalConsultaCodigoBarras" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Código de Barra</h5>
                <button type="button" class="close btn-fechar-modal-addItem" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="body-modal-SelecionaItens">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Código de Barra</label>
                        <input class="form-control" id="st_codigo_barra" name="st_codigo_barra" value="" placeholder="Informe o Código de Barra">
                    </div>
                </div>    
            </div>
            <div class="modal-footer">
                <button type="button" id="consultaProdutoCodigoBarra" class="btn btn-success">Adicionar</button>
                <button type="button" id="btn-fechar-modal-consutaCodigoBarra" class="btn btn-dark" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>