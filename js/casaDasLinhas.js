$('document').ready(function() {

    //esconde a div com a menssagem de Sucesso ou falha na operação(ex. mensagem de "Sucesso! O produto foi cadastrado com sucesso")
    $('#div-mensagemResultados').click(function() {
        $('#div-mensagemResultados').hide('fadein');
    });

    //mascaras para o sitemas
    $(".mask-cnpj").mask("00.000.000/0000-00");
    $(".mask-data").mask('00/00/0000');
    $(".mask-dinheiro").maskMoney({prefix: 'R$ ', allowNegative: true, thousands: '.', decimal: ',', affixesStay: false});

    //Bloqueia a tecla enter, não faz o submit quando apertar o enter.
    $('input').keypress(function (e) {
        var code = null;
        code = (e.keyCode ? e.keyCode : e.which);                
        return (code == 13) ? false : true;
    });

    //Quando clicar no campo de codigo de barra se houver codigo ele será apagado, usado no editar e cadastrar produto
    $('.codigo_barra').keyup(function(e) {
        if(e.keyCode == 13) {
            $(this).prop('readonly', true);
        }   
    });

    $('.codigo_barra').focusin(function() {
        $(this).prop('readonly', false);
        $(this).val('');
    });


})