$('document').ready(function() {


    //Listar os Relatórios de Vendas
    $('#button-relatoriosVendas').click(function() {
        let dataInicial = $('#dt_venda_inicial').val();
    });


    //ações referente a tela de confirmar venda
    //esconde a div do modal do confirmar o pagamento por cartão e misto
    $("#pagamentoCartao").hide();
    $("#pagamentoMisto").hide();

    //mantem o botão de confirmar a venda desabilitado até o valor pago ser maior que o valor total da venda
    $('#btn-ConfirmePagamentoVenda').prop("disabled", true);

    //troca o form conforme a opção de pagamento
    $('#pgtDinheiro').click(function() {
        $("#pagamentoDinheiro").show('fade');
        $("#pagamentoCartao").hide('fade');
        $("#pagamentoMisto").hide('fade');
        $("#vl_valor_pago_cliente").val('0,00');
        $("#vl_troco").val('0,00');
        $('#btn-ConfirmePagamentoVenda').prop("disabled", true);
    });

    $('#pgtCartao').click(function() {
        $("#pagamentoDinheiro").hide('fade');
        $("#pagamentoCartao").show('fade');
        $("#pagamentoMisto").hide('fade');
        $('#btn-ConfirmePagamentoVenda').prop("disabled", false);
    });

    $('#pgtMisto').click(function() {
        $("#pagamentoDinheiro").hide('fade');
        $("#pagamentoCartao").hide('fade');
        $("#pagamentoMisto").show('fade');
        $("#vl_valor_pago_cliente").val('0,00');
        $("#vl_troco").val('0,00');
        $('#btn-ConfirmePagamentoVenda').prop("disabled", true);
    });

    //vai calcular o troco modo de pagamento dinheiro
    $("#btn-calcular").click(function() {
        var troco = 0.00;
        var valorVenda = $("#vl_venda_valor_total").val();
        var valorPgtCliente = $("#vl_valor_pago_cliente").val();

        valorVenda = tratarValorBackEnd(valorVenda);
        valorPgtCliente = tratarValorBackEnd(valorPgtCliente);

        troco = valorPgtCliente - valorVenda;

        if (troco < 0) {
            alert("A Valor pago pelo cliente é menor que o valor TOTAL da venda.");
        } else {
            troco = tratarValorFrontEnd(troco);
            $('#btn-ConfirmePagamentoVenda').prop("disabled", false);
            $('#vl_troco').val(troco);

            //validação pq da um erro no campo troco fica NaN quando o campo $("#vl_venda_valor_total") fica em branco e uma ganbi
            if ($('#vl_troco').val() == 'NaN') {
                $('#btn-ConfirmePagamentoVenda').prop("disabled", true);
                $('#vl_troco').val('0,00');
                alert('Informe o valor pago pelo cliente');
            }

        }
    });

    //caso hover qualquer troca de valor no campo valor pago pelo cliente desabilita o botão confirmar venda até que ele seja analisado denovo
    $("#vl_valor_pago_cliente").focus(function() {
        $('#btn-ConfirmePagamentoVenda').prop("disabled", true);
    });


    //calcula o troco para o modo de pagamento MISTO
    $('#btn-calcular-m').click(function() {
        var dinheiro = $('#vl_valor_pago_cliente_dinheiro_m').val();
        var cartao = $('#vl_valor_pago_cliente_cartao_m').val();
        var valorVenda = $('#vl_valor_venda_total_m').val();
        var troco = 0.00;

        dinheiro = tratarValorBackEnd(dinheiro);
        cartao = tratarValorBackEnd(cartao);
        valorVenda = tratarValorBackEnd(valorVenda);

        troco = (cartao + dinheiro) - valorVenda;

        if (troco < 0) {
            alert('O valor da venda ainda não foi quitado!');
        } else {
            troco = tratarValorFrontEnd(troco);
            $('#btn-ConfirmePagamentoVenda').prop("disabled", false);
            $('#vl_troco_m').val(troco);
        }

        //validação pq da um erro no campo troco fica NaN quando o campo $("#vl_venda_valor_total") fica em branco e uma ganbi
        if ($('#vl_troco_m').val() == 'NaN') {
            $('#btn-ConfirmePagamentoVenda').prop("disabled", true);
            $('#vl_troco_m').val('0,00');
            alert('Informe o valor pago pelo cliente');
        }
    });

    //caso hover qualquer troca de valor nos campos valor pago pelo cliente desabilita o botão confirmar venda até que ele seja analisado denovo
    $("#vl_valor_pago_cliente_dinheiro_m").focus(function() {
        $('#btn-ConfirmePagamentoVenda').prop("disabled", true);
    });

    $("#vl_valor_pago_cliente_cartao_m").focus(function() {
        $('#btn-ConfirmePagamentoVenda').prop("disabled", true);
    });


    //ações referente a tela de pesquisar
    //botão de pesquisar vendas
    $("#button-listarVendas").click(function() {

        var data_inicial = $('#dt_venda_inicial').val();
        var data_final = $('#dt_venda_final').val();
        var situacao = $('#st_situacao').val();
        var pagamento = $('#st_pagamento').val();

        switch (situacao) {
            case 'Confirmada':
                situacao = 'C';
                break;
            case 'Não Confirmada':
                situacao = 'NC';
                break;
            case 'Cancelada':
                situacao = 'CA';
                break;
        }

        switch (pagamento) {
            case 'Cartão':
                pagamento = 'C';
                break;
            case 'Dinheiro':
                pagamento = 'D';
                break;
            case 'Misto':
                pagamento = 'M';
                break;
            case 'Não Paga':
                pagamento = 'NP';
                break;
        }

        $.ajax({
            type: 'POST',
            data: {dt_venda_inicial: data_inicial, dt_venda_final: data_final, st_situacao: situacao, st_pagamento: pagamento},
            url: '../ajax/vendasAjax/pesquisarAjax.php',
            success: function(resultado) {
                $('.div-resultado').hide();
                $('#resultadoPesquisarVendas').html(resultado);
                $('.div-resultado').show('fadein');
            },
            error: function() {
                alert('Erro no Ajax Vendas pesquisar.');
            }
        });
    });

    //***************************************************************//
    //Ações referente ao itens da venda das telas de cadastrar/Editar//
    //***************************************************************//

    //Array que vai conter os itens da venda para que ele não se repitam
    itensVenda = [];
    qtdItensVenda = $('#table-itens-venda tbody tr').length;

    //quando for a tela de editar e já tiver itens selecionados aqui eles, os itens, são cadastrados no array.
    if (qtdItensVenda > 0) {
        for (x = 0; x < qtdItensVenda; x++) {
            itensVenda[x] = $('#table-itens-venda tbody tr')[x].id;
        }
    }

    //botão que busca a lista de itens para ser selecionados do cadastrar/editar vendas
    $('#addNovoItemVenda').click(function() {
        $.ajax({
            type: 'POST',
            url: '../ajax/vendasAjax/carregarItemSelecaoVendaAjax.php',
            success: function(resultado) {
                $("#modalBodyItensSelecaoVenda").html(resultado);
            },
            erro: function() {
                alert('Erro no Ajax das Vendas.');
            }
        });
    });

    //Ativa o disable do botão de adicionar o item da venda depois de fechar o modal
    $('.btn-fechar-modal-addItem-venda').click(function() {
        $('#addItem-venda').prop("disabled", true);
    });

    //Quando clicar no botao "adicionar" eh verificado se o item esta ou não selecionado. E se necessario adiciona o item.
    $('#addItem-venda').click(function() {
        var produto_id = $("input[name='id']:checked").val();
        var verificaItem = verificarItemJaSelecionado(produto_id);

        if (verificaItem == false) {
            addItemArray(produto_id);
            addNovoItemVendaAjax(produto_id);
        } else {
            alert("O item escolhido já está selecionado. Revise os items selecionados.");
        }

        $('#addItem-venda').prop("disabled", true);
    });

    //****************************** Código de Add Item a Venda Só pelo Código de Barras ***************************************// 
    
    //Dá focus no campo do código de barras ao carregar a página de Pesquisar
    $('#st_codigo_barra').focus();

    //Aqui quando o Código de Barra for lido pela pistola executa o enter automaticamente, executado no Pesquisar Produto
    $('#st_codigo_barra').keyup(function(e) {
        if(e.keyCode == 13) {
            let st_codigo_barra = $(this).val();

            $.ajax({
                type:'POST',
                url: '../ajax/vendasAjax/buscarProdutoIdPeloCodeBarAjax.php',
                data:{st_codigo_barra: st_codigo_barra},
                success: function(resultado) {
                    let produto_id = parseInt(resultado);
                    if(produto_id > 0) {
                        var verificaItem = verificarItemJaSelecionado(produto_id);

                        if (verificaItem == false) {
                            addItemArray(produto_id);
                            addNovoItemVendaAjax(produto_id);
                        } else {
                            alert("O item escolhido já está selecionado. Revise os items selecionados.");
                        }
                    } else {
                        alert('Produto não encontrado pelo código de barras informados.');
                    }
                },
                error: function() {
                    alert('Erro no Ajax Vendas pesquisar.');
                }
            });    
        }
    });

    //**********************************************************************************************************//
    //Ações referente ao valor total da venda soma dos valores dos itens da venda das telas de cadastrar/Editar//
    //*********************************************************************************************************//
});

//Função que vai add um novo item a venda, função chamada ao clicar no botão "#addItem-venda".
function addNovoItemVendaAjax(produto_id) {
    $.ajax({
        type: 'POST',
        url: '../ajax/vendasAjax/addNovoItemVendaAjax.php',
        data: {produto_id: produto_id},
        success: function(resultado) {
            $(resultado).appendTo("#tbody-item");
            $('#modalSelecionaItemVenda').modal('hide');
        },
        error: function() {
            alert('Erro noa AJAX ao ADICIONAR uma novo item na venda.')
        }
    });
}

//Função que vai remover do array o item do array dos itens já selecionados, função chamada ao click no botão "remover" item, o <script> eh populado com a tr do item via ajax
function removeItemArray(produto_id) {
    for (x = 0; x <= qtdItensVenda; x++) {
        if (itensVenda[x] == produto_id) {
            itensVenda[x] = "";
        }
    }

}

//Função que Adiciona o item escolhido no array itensVenda, função chamada ao clicar no botão "#addItem-venda".
function addItemArray(produto_id) {

    if (qtdItensVenda > 0) {
        qtdItensVenda++;
        itensVenda[qtdItensVenda] = produto_id;
    } else {
        itensVenda[qtdItensVenda] = produto_id;
        qtdItensVenda++;
    }
}

//Função que verifica se o item escolhido já não está escolhido, função chamada ao clicar no botão "#addItem-venda".
function verificarItemJaSelecionado(produto_id) {
    for (x = 0; x <= qtdItensVenda; x++) {
        if (itensVenda[x] == produto_id) {
            return true;
        }
    }
    return false;
}

//***************************************//
//FUNÇÔES REFERENTE AOS VALORES DA VENDA//
//**************************************//

//Função que vai somar o valor total dos itens da venda com o valor total da venda, esse função eh chamada pelo SCRIPT da tr adicionada pelo "#addItem-venda"
function somarValorItemNoValorTotalVenda(novoValorTotalItens, valorTotalVenda) {

    novoValorTotalItens = tratarValorBackEnd(novoValorTotalItens);
    valorTotalVenda = tratarValorBackEnd(valorTotalVenda);

    var NovoValorTotalVenda = valorTotalVenda + novoValorTotalItens;
    NovoValorTotalVenda = tratarValorFrontEnd(NovoValorTotalVenda);

    return NovoValorTotalVenda;
}

//Função que vai multiplicar o valor unitario do item pelo qt da venda desse tal item, esse função eh chamada pelo SCRIPT da tr adicionada pelo "#addItem-venda"
function somarValorTotalDosItem(qtItem, valorUnitarioItem) {

    valorUnitarioItem = tratarValorBackEnd(valorUnitarioItem);

    var valorTotalItens = qtItem * valorUnitarioItem;
    valorTotalItens = tratarValorFrontEnd(valorTotalItens);

    return valorTotalItens
}

function diminuirValorTotalDosItemDoValorVendaTotal(valorTotalItensSalvo, valorTotalVendaSalvo) {

    valorTotalItensSalvo = tratarValorBackEnd(valorTotalItensSalvo);
    valorTotalVendaSalvo = tratarValorBackEnd(valorTotalVendaSalvo);

    var valorTotalVenda = valorTotalVendaSalvo - valorTotalItensSalvo;
    valorTotalVenda = tratarValorFrontEnd(valorTotalVenda);

    return valorTotalVenda;
}

function tratarValorBackEnd(valor) {
    valor = valor.replace(".", "");
    valor = valor.replace(",", ".");
    valor = parseFloat(valor);
    return valor;
}

function tratarValorFrontEnd(valor) {
    valor = valor.toFixed(2)
    valor = valor.replace(".", ",");
    return valor;
}