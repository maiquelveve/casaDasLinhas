$(document).ready(function(){
	
	//Aqui add um tr com o novo Código de barra
	$('#addCodigoBarra').click(function(){
		let newCodBarra = $('#st_codigo_barra').val();
		let html =  `<tr class="text-center">
                        <td>${contCodBarra}</td>            
                        <td>${newCodBarra}</td>            
                        <td style="text-align: right;"><button type="button" class="btn btn-danger btn-sm btn-remover-codBarra"><i class="fa fa-trash-alt"></i> Remover </button></td>                                                
                    </tr>
                    <input type="hidden" name="st_codigo_barra-${contCodBarra}" value="${newCodBarra}" >`

		$('#tbody-codigo-barra').append(html);
		$('#st_codigo_barra').val('');
		$('#btn-fechar-modal-addCodigoBarra').trigger('click');
		contCodBarra++;
	});

	//Aqui remover até as tr criadas em tempo de execução
	$(document).on('click', '.btn-remover-codBarra', function(){
    	//contCodBarra--;
		$(this).closest('tr').remove();
	});

	//Aqui quando o Código de Barra for lido pela pistola, o jquery executa o clique no botão addCodigoBarra e ja insere na tabela
	$('#st_codigo_barra').keyup(function(e) {
        if(e.keyCode == 13) {
        	$('#addCodigoBarra').trigger('click');
        }   
    });

    //Quando clica no botão para abrir o modal de add codigo de barra, aqui da o focus no campo st_codigo_barra 
    $('#modaladdNovoCod').on('shown.bs.modal', function () {
    	$('#st_codigo_barra').focus();
	}); 


	//***************************************************************************************************************//
	//Consulta Produtos Por Código de Barras

	//Dá focu no campo st_codigo_barras assim que abrir o modal
	$('#modalConsultaCodigoBarras').on('shown.bs.modal', function () {
    	$('#st_codigo_barra').focus();
	}); 	

	//Aqui quando o Código de Barra for lido pela pistola, o jquery executa o clique no botão addCodigoBarra e ja insere na tabela
	$('#st_codigo_barra').keyup(function(e) {
        if(e.keyCode == 13) {
        	$('#consultaProdutoCodigoBarra').trigger('click');
        }   
    });

    //Quando clica no botão $('#consultaProdutoCodigoBarra') pesquisa o produto pelo codigo de barras
    $('#consultaProdutoCodigoBarra').click(function(){
    	let st_codigo_barra = $('#st_codigo_barra').val();

    	$.ajax({
            type:'POST',
            url: '../ajax/produtosAjax/pesquisarProdutosCodigoBarrasAjax.php',
            data:{st_codigo_barra: st_codigo_barra},
            success: function(resultado) {
                $('#resultadoPesquisarProduto').html(resultado);
                $('.div-resultado').show('fadein');
                $('#modalConsultaCodigoBarras').modal('hide');
                $('#st_codigo_barra').val('')
            },
            error: function() {
                alert('Erro no Ajax Produtos pesquisar.');
            }
        });
    	
    });
});