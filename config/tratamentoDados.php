<?php
    class TratamentoDados {

        public function ajustarFormatosDeDadosParaBanco($dados) {

            $dados_tratados = array();

            foreach ($dados as $k => $dado) {
                if(!empty($dado)) {

                    $parte = explode('_', $k);

                    switch ($parte[0]) {
                        case 'st':
                            $dado = trim($dado);
                            $dado = strtoupper($dado);
                            $dados_tratados[$k] = $dado;
                            break;

                        case 'dt':
                            $data = explode('/', $dado);
                            $dado = $data[2].'-'.$data[1].'-'.$data[0];
                            $dados_tratados[$k] = $dado;
                            break;

                        case 'nr':
                            $dados_tratados[$k] = $dado;
                            break;

                        case 'vl':
                            $dado = str_replace('.', '', $dado);
                            $dado = str_replace(',', '.', $dado);
                            $dado = floatval ($dado);
                            $dados_tratados[$k] = $dado;
                            break;

                        default:
                            $dados_tratados[$k] = $dado;
                    }
                } else {
                    $dados_tratados[$k] = $dado;
                }
            }

            return $dados_tratados;
        }

        public function ajustarFormatosDeDadosParaTela($dados) {
            $dados_tratados = array();

            foreach ($dados as $k => $dado) {

                $parte = explode('_', $k);

                switch ($parte[0]) {

                    case 'dt':
                        $data = explode('-', $dado);
                        $dado = $data[2].'/'.$data[1].'/'.$data[0];
                        $dados_tratados[$k] = $dado;
                        break;

                    case 'vl':
                        $dado = number_format($dado, 2, ',', '.');
                        $dados_tratados[$k] = $dado;
                        break;

                    case 'st':
                        $dado = trim($dado);
                        $dado = ucwords(strtolower($dado));
                        $dados_tratados[$k] = $dado;
                        break;

                    default:
                        $dados_tratados[$k] = $dado;
                }
            }

            return $dados_tratados;
        }

        public function validacaoData($data) {
            $data = explode('-', $data);

            if(checkdate($data[1], $data[2], $data[0])) {
                return 1;
            } else {
                return 0;
            }
        }

        public function ajustarCnpjCpfParaBanco($dado){

            $dado = str_replace('.', '', $dado);
            $dado = str_replace('-', '', $dado);

            if(strlen($dado) == 15) {
                $dado = str_replace('/', '', $dado);
            }

            return $dado;
        }
    }
?>