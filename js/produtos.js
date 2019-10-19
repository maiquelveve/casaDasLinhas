$('document').ready(function(){

    $('#informacoesAdicionais').hide('fadeIn');
    
    //verifica se esta selecionado o tipo de produto e busca as informações adicionais se houver e as marcas (mais usado no EDITAR esta parte, para o cadastrar tem no CHANGE)
    tipo_produto_id = $('#tipo_produto_id').val()
    produto_id = $('#produto_id').val();
    buscaInformacaoAdicionais(produto_id, tipo_produto_id);
    
    //quando clica no botão de pesquisar da página dos produtos
    $('#button-listarProdutos').click(function(){
        $('.div-resultado').hide();
        var produto = $('#st_produto').val();
        var marca = $('#st_marca').val();
        var codeBarra = $('#ch_codeBarra').val()
        
        $.ajax({
            type:'POST',
            url: '../ajax/produtosAjax/pesquisarAjax.php',
            data:{st_produto: produto, st_marca: marca, ch_codeBarra: codeBarra},
            success: function(resultado) {
                $('#resultadoPesquisarProduto').html(resultado);
                $('.div-resultado').show('fadein');
            },
            error: function() {
                alert('Erro no Ajax Produtos pesquisar.');
            }
        });
    });
    
    //Depois de escolher um tipo de produto traz as marcas que ele esta associado e as informações adicionais se houver
    $('#tipo_produto_id').change(function(){
        tipo_produto_id = $('#tipo_produto_id').val();
        produto_id = "";
        buscaInformacaoAdicionais(produto_id,tipo_produto_id);
    });
});

/***************************************************/
/**** FUNÇÕES QUE BUSCA DADOS POR AJAX *************/
/***************************************************/

function buscaInformacaoAdicionais(produto_id, tipo_produto_id) {
    if(tipo_produto_id > 0) {
        //Ajax que busca as informações adicionais e mostra o form delas
        $.ajax({
            type: 'POST',
            url: '../ajax/produtosInformacoesAdicionaisAjax/buscarProdutosInformacoesAdicionaisAjax.php',
            data: {produto_id: produto_id, tipo_produto_id: tipo_produto_id},
            success: function (resultado) {
                $('#informacoesAdicionais').hide('fadeIn');
                $('#informacoesAdicionais').html(resultado);
                $('#informacoesAdicionais').show('fadeIn');
            },
            error: function () {
                alert('Erro no Ajax Tipos Produtos Busca das Informações adicionais do produto.');
            }
        });
    } else {
        $('#informacoesAdicionais').hide('fadeIn');
    }    
}
