<?php
    require_once '../parts/header.php';
    require_once DIR_PARTS . 'menus.php';
?>
<div class="container my-5">
    <!-- Inicio da ROW da parte de cima -->
    <!--Espçao da tabela parte bem a direita-->
    <h1 class="my-4">Vendas
        <small>Relatórios</small>
    </h1>
    <form>
        <div class="form-row">
            <div class="form-group col-md-2">
                <label>Data Inicial</label>
                <input type="date" class="form-control" id="dt_venda_inicial" name="dt_venda_inicial" placeholder="">
            </div>
            <div class="form-group col-md-2">
                <label>Data Final</label>
                <input type="date" class="form-control" id="dt_venda_final" name="dt_venda_final" placeholder="">
            </div>
        </div>
        <button type='button' id="button-relatoriosVendas" class="btn btn-primary"><i class="fa fa-search"></i> Relatórios</button>
        <a href="pesquisar.php"><button type='button' id="button-pesquisarVendas" class="btn btn-info"> Voltar</button></a>
    </form>
    <div class="resultadoRelatoriosVendas div-resultado" id="resultadoRelatoriosVendas"></div>
</div>

<?php
    require_once DIR_PARTS . 'footer.php';
?>