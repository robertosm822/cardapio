<?php
header('Content-type: application/json; charset=utf8');
header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Max-Age: 3628800');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    
if($_GET['name'] == 'produtos' ){
        
require_once 'Conexao.php';
//CONSULTA QUE RETORNA OS ITEMS DE MENU PRINCIPAIS DA ESQUERDA
$query_categorias = $conexao->query("SELECT * FROM items WHERE level = '2'");

//$query_categorias = $OBJcategorias->execute();

$categorias = $query_categorias->fetchAll();

//MONTANDO O ARRAY DINAMICAMENTE DA BASE DE DADOS DE MENU PRINCIPAL
foreach ($categorias as $key => $value) {
    
    $produtos = $conexao->query("SELECT * FROM contents WHERE items_id='".$value['id']."'");
    
    if ($produtos) {    
        $categorias[$key]['Produtos'] = $produtos->fetchAll();            
    }
}

    echo var_dump($categorias);
  //echo json_encode($categorias);
}
if($_GET['name'] == 'categorias' ){
        
//=====================================================================================================================
require_once 'Conexao.php';

//MONTANDO A CONSULTA DINÂMICA =================================================================================

//CONSULTA QUE RETORNA OS ITEMS DE MENU PRINCIPAIS DA ESQUERDA
$obj_categoria = $conexao->query("SELECT * FROM items WHERE level = '1'");
//trazendo o total de linhas da consulta com "PDO->rowCount()"
//$total = $obj_categoria->rowCount();

//MONTANDO O ARRAY DINAMICAMENTE DA BASE DE DADOS DE MENU PRINCIPAL
foreach ($obj_categoria as $key => $val) {
    
    $categoriasList[] = array( 
                    'Categorias' =>  $val  
                    );         
    }
echo json_encode( $categoriasList );
}
?>