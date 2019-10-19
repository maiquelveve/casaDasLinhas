<?php
    require_once '../parts/header.php';
    require_once DIR_PARTS . 'menus.php';
?>

<div class="container my-5">
    <!-- Inicio da ROW da parte de cima -->
    <!--Espçao da tabela parte bem a direita-->
    <h1 class="my-4">Vendas
        <small>Pesquisar</small>
    </h1>
    <form>
        <div class="form-row">
            <div class="form-group col-md-2">
                <label>Data da Inicial</label>
                <input type="date" class="form-control" id="dt_venda_inicial" name="dt_venda_inicial" placeholder="">
            </div>
            <div class="form-group col-md-2">
                <label>Data da Final</label>
                <input type="date" class="form-control" id="dt_venda_final" name="dt_venda_final" placeholder="">
            </div>
            <div class="form-group col-md-3">
                <label>Pagamento</label>
                <select class="form-control" name="st_pagamento" id="st_pagamento">
                    <option class="st_situacao" value="" selected>Escolha uma Modo</option>
                    <option class="st_situacao" valeu="C">Cartão</option>
                    <option class="st_situacao" valeu="D">Dinheiro</option>
                    <option class="st_situacao" valeu="M">Misto</option>
                    <option class="st_situacao" valeu="NP">Não Paga</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Situação</label>
                <select class="form-control" name="st_situacao" id="st_situacao">
                    <option class="st_situacao" value="" selected>Escolha uma Situação</option>
                    <option class="st_situacao" valeu="C">Confirmada</option>
                    <option class="st_situacao" valeu="NC">Não Confirmada</option>
                    <option class="st_situacao" valeu="CA">Cancelada</option>
                </select>
            </div>
        </div>
        <button type='button' id="button-listarVendas" class="btn btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
        <a href="cadastrar.php"><button type='button' id="button-novaVenda" class="btn btn-dark"><i class="fa fa-plus-circle"></i> Nova Venda</button></a>
    </form>
    <div class="resultadoPesquisarVendas div-resultado" id="resultadoPesquisarVendas"></div>
</div>

<?php
    require_once DIR_PARTS . 'footer.php';
?>

