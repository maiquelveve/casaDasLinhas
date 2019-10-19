<?php
    class ConexaoPDO {
        public static $instance;
        
        public static function getInstance () {
            if(!isset(self::$instance)){
                try {
                    self::$instance = new PDO('mysql:host=localhost;dbname=casadaslinhas', 'root', '');
                    self::$instance->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                    self::$instance->exec("set names utf8");
                } catch (PDOException $e) {
                    echo "Hovem algum problema com a CONEXAO com o Banco de Dados". $e->getMessage();
                    return false;
                }  
            }
            
            return self::$instance;
        }
    }
?>