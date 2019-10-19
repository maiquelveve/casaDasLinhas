<?php
    $BASE_DIR = realpath(filter_input(INPUT_SERVER, 'DOCUMENT_ROOT')) . '/CasaDasLinhas';

    define('DS'      , DIRECTORY_SEPARATOR);
    define('DIR_BASE', $BASE_DIR . DS);
    define('DIR_CONEXAOBD' , DIR_BASE  . 'conexaoBD' . DS);
    define('DIR_DAO' , DIR_BASE  . 'dao' . DS);
    define('DIR_VALIDACOES' , DIR_BASE  . 'validacoes' . DS);
    define('DIR_PARTS', DIR_BASE . 'parts' . DS);
    define('DIR_CONFIG', DIR_BASE . 'config' . DS);
    define('LOCALHOST', 'localhost/casaDasLinhas' . DS);
?>
