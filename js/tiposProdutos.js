$('document').ready(function() {
    
    $('#button-listarTiposProdutos').click(function() {
        $('.div-resultado').hide();
        st_descricao = $('#st_descricao').val();
        
        $.ajax({
            type: 'POST',
            url: '../ajax/tiposProdutosAjax/pesquisarAjax.php',
            data: {st_descricao: st_descricao},
            success: function(resultado) {
                $('#resultadoPesquisarTiposProdutos').html(resultado);
                $('.div-resultado').show('fadein');
            },
            error: function() {
                alert('Erro do Ajax dos Tipos do Produto');
            }
        });
        
    });
});