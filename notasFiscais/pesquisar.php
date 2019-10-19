<?php
    require_once '../parts/header.php';
    require_once DIR_PARTS.'menus.php';
    require_once DIR_VALIDACOES .'notasFiscaisValidacoes.php';


?>
<div class="container my-5">
    <!-- Inicio da ROW da parte de cima -->
    <!--Espçao da tabela parte bem a direita-->
    <h1 class="my-4">Notas Fiscais
        <small>Pesquisar</small>
    </h1>
    <form>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Empresa</label>
                <input class="form-control" id="st_nome_empresa" name="st_nome_empresa" placeholder="Informe o nome da Empresa">
            </div>
            <div class="form-group col-md-3">
                <label>CNPJ</label>
                <input class="form-control" id="st_cnpj" name="st_cnpj" placeholder="Informe o CNPJ">
            </div>
            <div class="form-group col-md-3">
                <label>Situação da Nota Fiscal</label>
                <select class="form-control" id="st_situacao" name="st_situacao">
                    <option value="">Selecione a Situação</option>
                    <option value="S">Solicitadas</option>
                    <option value="C">Confirmadas</option>
                </select>
            </div>
        </div>
        <button type='button' id="button-listarNotasFiscais" class="btn btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
        <a href="cadastrar.php"><button type='button' id="button-novaNotaFiscal" class="btn btn-dark"><i class="fa fa-plus-circle"></i> Cadastrar Nota Fiscal</button></a>
    </form>
    <div class="resultadoPesquisarNotaFiscal div-resultado" id="resultadoPesquisarNotaFiscal"></div>
</div>
<?php
    require_once DIR_PARTS.'footer.php';
?>

