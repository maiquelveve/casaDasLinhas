$('document').ready(function() {

    //quano clica no botão pesquisar das marcas ele busca as marcas pelo ajaxs
    $('#button-listarMarcas').click(function() {
        $('.div-resultado').hide();

        st_marca = $('#st_marca').val();
        tipo_produto_id = $('#tipo_produto_id').val();

        $.ajax({
            type: 'POST',
            url: '../ajax/marcasAjax/pesquisarAjax.php',
            data: {st_marca: st_marca, tipo_produto_id: tipo_produto_id},
            success: function(resultado) {
                $('.div-resultado').html(resultado);
                $('.div-resultado').show('fadeIn');
            },
            error: function() {
                alert('Erro no Ajax PesquisarAjax marcas');
            }
        });
    });
});


