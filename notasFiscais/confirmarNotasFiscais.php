<?php
require_once '../parts/header.php';
require_once DIR_PARTS . 'menus.php';
require_once DIR_CONFIG . 'alertsResultados.php';
require_once DIR_VALIDACOES . 'notasFiscaisValidacoes.php';
require_once DIR_VALIDACOES . 'itensValidacoes.php';

//dados do post
$post = filter_input_array(INPUT_POST);

//ID da nota fiscal
$id = $_GET['id'];

//instancia das classes
$notasFiscaisValidacoes = new NotasFiscaisValidacoes();
$alertsResultados = new AlertsResultados();
$itensValidacoes = new ItensValidacoes();

if (isset($post) && !empty($post)) {
    $itensCadastrados = $itensValidacoes->buscarItensdaNotaFiscal($id);
    $notasFiscais = $notasFiscaisValidacoes->confirmarNotaFiscal($id, $itensCadastrados);
    $mensagem = $alertsResultados->mensagemResultados($notasFiscais, 'nota fiscal', 'Editar');
}

//busca a nota fiscal e seus itens
$notaFiscal = $notasFiscaisValidacoes->buscarNotaFiscal($id);
$itensCadastrados = $itensValidacoes->buscarItensdaNotaFiscal($id);
?>

<div class="container my-5">
    <!-- Inicio da ROW da parte de cima -->
    <!--Espçao da tabela parte bem a direita-->
    <h1 class="my-4">Notas Fiscais
        <small>Cadastrar</small>
    </h1>
    <?php
    if (isset($mensagem) && !empty($mensagem)) {
        echo '<div id="div-mensagemResultados">' . $mensagem . '</div>';
    }
    ?>
    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-2">
                <label>Número da Nota</label>
                <input class="form-control" id="nr_nota" name="nr_nota" value="<?php echo $notaFiscal['nr_nota'] ?>" placeholder="Informe o Número da Notas" disabled>
            </div>
            <div class="form-group col-md-2">
                <label>Situação da Nota</label>
                <input class="form-control" id="nr_nota" name="st_situação" value="<?php echo ($notaFiscal['st_situacao'] == 'C' ? 'Confirmada' : 'Solicitada') ?>" disabled>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-8">
                <label>Empresa</label>
                <input class="form-control" id="st_nome_empresa" name="st_nome_empresa" value="<?php echo $notaFiscal['st_nome_empresa'] ?>" placeholder="Informe o Nome da Empresa" disabled>
            </div>
            <div class="form-group col-md-4">
                <label>CNPJ</label>
                <input class="form-control" id="st_cnpj" name="st_cnpj" value="<?php echo $notaFiscal['st_cnpj'] ?>" placeholder="Informe o CNPJ da Empresa" disabled>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Data da Compra</label>
                <input class="form-control" id="dt_compra" name="dt_compra" value="<?php echo $notaFiscal['dt_compra'] ?>" placeholder="Informe a Data da Compra" disabled>
            </div>
            <div class="form-group col-md-4">
                <label>Data de Emissão</label>
                <input class="form-control" id="dt_emissao_nota" name="dt_emissao_nota" value="<?php echo $notaFiscal['dt_emissao_nota'] ?>" placeholder="Informe a Data de Emissão" disabled>
            </div>
            <div class="form-group col-md-4">
                <label>Valor</label>
                <input type="text" class="form-control" id="vl_valor_total_nota" name="vl_valor_total_nota" value="<?php echo $notaFiscal['vl_valor_total_nota'] ?>" placeholder="Informe o Valor Total da Nota" disabled>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Observação</label>
                <textarea class="form-control" rows="4" cols="15" placeholder="Observações!" name="st_observacao" disabled><?php echo $notaFiscal['st_observacao'] ?></textarea>
            </div>
        </div>

        <!--parte que mostra os itens selecionados da nota-->
        <div class="form-row">
            <div class="form-group col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title d-inline">Itens da Nota Fiscal</h4>
                    </div>
                    <div class="card-body">
                        <table class="table" id="table-itens">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Valor Unitário</th>
                                    <th>Valor Total</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-item">
                                <?php foreach ($itensCadastrados as $item) : ?>
                                    <tr class="text-center" id="<?php echo $item['produto_id'] ?>">
                                        <td><?php echo $item['produto_id'] ?></td>
                                        <td><?php echo $item['st_produto'] ?></td>
                                        <td><input type="text" class="form-control form-control-sm" name="nr_quantidade-<?php echo $item['produto_id'] ?>" value="<?php echo $item['nr_quantidade'] ?>" placeholder="Informe a Quantidade" disabled></td>
                                        <td><input type="text" class="form-control form-control-sm" name="vl_valor_unitario-<?php echo $item['produto_id'] ?>" value="<?php echo $item['vl_valor_unitario'] ?>" placeholder="Informe o valor unitário" disabled></td>
                                        <td><input type="text" class="form-control form-control-sm" name="vl_valor_total-<?php echo $item['produto_id'] ?>" value="<?php echo $item['vl_valor_total'] ?>" placeholder="Informe o valor total" disabled></td>
                                    </tr>
                                <input type="hidden" class="form-control form-control-sm" name="st_produto-<?php echo $item['id'] ?>" value="<?php echo $item['st_produto'] ?>">
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($notaFiscal['st_situacao'] != 'C') { ?>
            <button type='submit' class="btn btn-success"> Confirmar</button>
        <?php } ?>
        <a href="pesquisar.php"><button type='button' class="btn btn-info"> Voltar</button></a>
    </form>
</div>
<?php
require_once DIR_PARTS . 'footer.php';
?>
