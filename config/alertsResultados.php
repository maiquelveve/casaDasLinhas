<?php
    class AlertsResultados {
        
        public function mensagemResultados($resultado, $objeto, $tipo) {
            //ve qual o tipo de operação se eh cadastra ou editar,etc...
            switch ($tipo) {
                case 'Cadastrar':
                    $tipo = 'cadastrado';
                    break;
                
                case 'Editar':
                    $tipo = 'alterado';
                    break;
            }
            
            //verifica se é um array, ou seja, ai vai ter erros nos campo que vem das funcões de validação
            $erros = '<h5 class="mb-3 alert-heading">'.ucfirst($objeto).' não pode ser '.$tipo.'.</h5>';
            
            if(is_array($resultado)) {
               foreach($resultado as $erro) {
                   $erros .= '<li>'.$erro.'</li>';
               };
               $resultado = 0;
            }
            
            //monta a menssagem
            if ($resultado > 0) {
                $mensagem = 
                    ' 
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">Sucesso!</h4>
                            <hr>
                            <p class="mb-0">'.ucfirst($objeto).' '.$tipo.' com Sucesso.</p>
                        </div>
                    ';
            } else {
                $mensagem = 
                    ' 
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading">Falha!</h4>
                            <hr>
                            <ul>'.$erros.'</ul>
                        </div>
                    ';
            }
            
            return $mensagem;
        }
    }
?>