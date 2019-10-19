<?php
    require_once '../parts/header.php';
    require_once DIR_PARTS . 'menus.php';
    require_once DIR_CONFIG . 'alertsResultados.php';
    require_once DIR_VALIDACOES . 'tiposProdutosValidacoes.php';
    
    $id = $_GET['id'];
    
    $tiposProdutosValidacoes = new TiposProdutosValidacoes();
    $alertsResultados = new AlertsResultados();
    $tipoProduto = $tiposProdutosValidacoes->buscarTiposProdutos($id);
?>

<div class="container my-5">
    <!-- Inicio da ROW da parte de cima -->
    <!--Espçao da tabela parte bem a direita-->
    <h1 class="my-4">Tipos de Produtos
        <small>Excluir</small>
    </h1>
    <?php 
        if (isset($_SESSION['excluir-menssagem']) && !empty($_SESSION['excluir-menssagem'])) {
            echo '<div id="div-mensagemResultados">'. $_SESSION['excluir-menssagem'] .'</div>';
            unset($_SESSION['excluir-menssagem']);
        } 
    ?>
    <form method="post" action="excluirTipoProduto.php?id=<?=$id?>">
        <div class="form-row">
            <div class="form-group col-md-7">
                <label>Tipo de Produto</label>
                <input class="form-control" id="st_descricao" name="st_descricao" value="<?php echo $tipoProduto['st_descricao']?>" placeholder="Informe o Tipo de Produto">
            </div>
            <div class="form-group col-md-5">
                <label>Informações Adicionais</label>
                <select class="form-control" id="ch_informacao_adicionais" name="ch_informacao_adicionais">   
                    <option value="">Selecione o Tipo de Produto</option>
                    <option value="S" <?php echo ($tipoProduto['ch_informacao_adicionais'] == 'S' ? 'selected' : '')?>>SIM</option>
                    <option value="N" <?php echo ($tipoProduto['ch_informacao_adicionais'] == 'N' ? 'selected' : '')?>>NÃO</option>
                </select>    
            </div>
        </div>    
        <button type='submit' class="btn btn-danger"> Excluir</button>
        <a href="pesquisar.php"><button type='button' id="button-novoProdutos" class="btn btn-info"> Voltar</button></a>
    </form>	
</div>

<?php
    require_once DIR_PARTS . 'footer.php';
?>

