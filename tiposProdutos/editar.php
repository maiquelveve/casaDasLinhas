<?php
    require_once '../parts/header.php';
    require_once DIR_PARTS . 'menus.php';
    require_once DIR_CONFIG . 'alertsResultados.php';
    require_once DIR_VALIDACOES . 'tiposProdutosValidacoes.php';
    
    $post = filter_input_array(INPUT_POST);
    $id = $_GET['id'];
    
    $tiposProdutosValidacoes = new TiposProdutosValidacoes();
    $alertsResultados = new AlertsResultados();
    
    if (isset($post) && !empty($post)) {
        $tiposProdutos = $tiposProdutosValidacoes->editar($post, $id);
        $mensagem = $alertsResultados->mensagemResultados($tiposProdutos, 'Tipo Produto', 'Editar');
    }
    
    $tipoProduto = $tiposProdutosValidacoes->buscarTiposProdutos($id);
?>

<div class="container my-5">
    <!-- Inicio da ROW da parte de cima -->
    <!--Espçao da tabela parte bem a direita-->
    <h1 class="my-4">Tipos de Produtos
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
        <button type='submit' class="btn btn-success"> Salvar</button>
        <a href="pesquisar.php"><button type='button' id="button-novoProdutos" class="btn btn-info"> Voltar</button></a>
    </form>	
</div>

<?php
    require_once DIR_PARTS . 'footer.php';
?>

