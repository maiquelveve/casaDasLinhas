$('document').ready(function() {
    //variavel com recebera o valor total da soma dos itens
    valorTotalSomaItens = 0;

    //ao clicar no botão pesqusiar vai disparar o ajax
    $('#button-listarNotasFiscais').click(function() {
        var empresa = $('#st_nome_empresa').val();
        var cnpj = $('#st_cnpj').val();
        var situacao = $('#st_situacao').val();

        $.ajax({
            url: '../ajax/notasFiscaisAjax/pesquisarAjax.php',
            type: 'POST',
            data: {st_nome_empresa: empresa, st_cnpj: cnpj, st_situacao: situacao},
            success: function(resultado) {
                $('#resultadoPesquisarNotaFiscal').hide('fadeIn');
                $('#resultadoPesquisarNotaFiscal').html(resultado);
                $('#resultadoPesquisarNotaFiscal').show('fadeIn');
            },
            error: function() {
                alert('Houve um erro no Ajax das Notas Ficais');
            }
        });
    });

    //***************** JS para fazer as add dos itens na tela de cadastrar e editar ******************
    //*************************************************************************************************

    //variaveis que salvam os id dos itens cadastrados na Nota Fiscal e a quantidade de itens há nela.
    idProdutosSeleconadosNotaFiscal = [];
    qtdItens = $('#table-itens tbody tr').length;

    //salva os ID's do produtos ja cadastrados na nota fiscal para comparar com os novos que serão adicionados. isso ao carregar da página
    if (qtdItens > 0) {
        for (y = 0; y < qtdItens; y++) {
            idProdutosSeleconadosNotaFiscal[y] = $('#table-itens tbody tr')[y].id
        }
    }


    //desabilita o de adicionar na nota o item ate algum ser selecionado
    $('#addItem').prop("disabled", true);

    //quando fechar o modal de adicionar item o botão addItem volta a ficar disabled
    $('.btn-fechar-modal-addItem').click(function() {
        $('#addItem').prop("disabled", true);
    });

    //Carrega os produtos no modal para add itens na nota fiscal
    $('#addNovoItem').click(function() {
        $.ajax({
            url: '../ajax/notasFiscaisAjax/carregarItensParaSelecaoAjax.php',
            type: 'POST',
            success: function(resultado) {
                $('#body-modal-SelecionaItens').html(resultado);
            },
            error: function() {
                alert('Erro no Ajaxa para carregar os itens para seleção na Nota Fiscal.');
            }
        });
    });

    //adiciona uma iten, uma tr, com os dados do item na tabela de itens da nota fiscal, no cadastrar e editar
    $('#addItem').click(function() {
        produto_id = $("input[name='produto_id']:checked").val();

        if (verificaProdutoJaSelecionadoNotaFisca(produto_id, qtdItens)) {
            adicionarNoArrayItensJaNota(produto_id, idProdutosSeleconadosNotaFiscal.length);
            adicionarItemNotaFiscal(produto_id);
            qtdItens++;
        } else {
            alert("Item já cadastrado da Nota Fiscal. Olhe os Itens Novamente");
        }
    });

});

//verifica se o novo item a ser cadastrado já não está selecionado
function verificaProdutoJaSelecionadoNotaFisca(produto_id, qtdItens) {
    for (x = 0; x < qtdItens; x++) {
        if (idProdutosSeleconadosNotaFiscal[x] == produto_id) {
            return false;
        }
    }
    return true;
}

//add o id do ITEM no array para o controle do queja esta cadastrado
function adicionarNoArrayItensJaNota(produto_id, proxArray) {
    idProdutosSeleconadosNotaFiscal[proxArray] = produto_id;
}

//Remover a TR do iten da Nota Fiscal
function removerItem(produto_id) {
    for (x = 0; x < qtdItens; x++) {
        if (idProdutosSeleconadosNotaFiscal[x] == produto_id) {
            idProdutosSeleconadosNotaFiscal[x] = "removido";
        }
    }
    $("#" + produto_id).parent().parent().remove();
}

//função que busca os dados do novo item da nota fiscal os popula como mais uma TR e adiciona na tabela
function adicionarItemNotaFiscal(produto_id) {
    $.ajax({
        url: '../ajax/notasFiscaisAjax/AdicionarItemNotaFiscalAjax.php',
        type: 'POST',
        data: {id: produto_id},
        success: function(resultado) {
            $(resultado).appendTo("#tbody-item");
        },
        error: function() {
            alert('Erro no Ajax do Adicionar Item na Nota Fiscal.');
        }
    });
    //quando fechar o modal de adicionar item e o item ser incluido na nota, o botão addItem volta a ficar disabled
    $('#modalSelecionaItem').modal('hide');
    $('#addItem').prop("disabled", true);
}