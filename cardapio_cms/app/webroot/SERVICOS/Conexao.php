<?php
function anti_injection($sql)
{
	// remove palavras que contenham sintaxe sql
	$sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$sql);
	$sql = trim($sql);//limpa espaços vazio
	$sql = strip_tags($sql);//tira tags html e php
	$sql = addslashes($sql);//Adiciona barras invertidas a uma string
	return $sql;
}
//ESTABELECENDO A CONEXÃO COM A BASE

class Conexao {
    private static $instance;
    private function __construct() {
        //construtor privado - nao consegue dar um new ou instaciar ela
    }
    public static function getInstance(){
       if(!isset( self::$instance )){
            try {
                self::$instance = new PDO("mysql:host=localhost;dbname=admin_cardapio;", "medigital03", "d3i8g5i8t5a1l9");
            } 
            catch (PDOException $e){
                echo "Erro: ".$e->getMessage();
            }
            return self::$instance;
       }
    }
}

$conexao = Conexao::getInstance();

?>