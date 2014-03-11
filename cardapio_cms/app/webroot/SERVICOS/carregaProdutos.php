<?php
header('Content-type: application/json; charset=utf8');
header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Max-Age: 3628800');
header('Access-Control-Allow-Methods: GET, POST');
 

if($_GET['productsId']){ 
require_once 'Conexao.php';

//MONTANDO A CONSULTA DIN�MICA =================================================================================
$obj_produtos = $conexao->query("SELECT
(select href from `admin_cardapio`.`items` WHERE id='".$_GET['productsId']."') as URL,
(select name from `admin_cardapio`.`items` WHERE id='".$_GET['productsId']."') as CATEGORIA,
`items`.`id` as 'Principal',
`items`.`card_id`,
`items`.`creator_id`,
`contents`.`id` as 'Subcategoria',
`contents`.`items_id`,
`contents`.`active`,
`contents`.`nome`,
`contents`.`description`,
`contents`.`valor`,
`contents`.`codigo_prato`,
`contents`.`photo`,
`contents`.`photo_dir`,
`contents`.`observacao`,
`contents`.`link_video_web`,
`contents`.`link_video_local`
FROM `admin_cardapio`.`items`  
INNER JOIN `admin_cardapio`.`contents` ON `admin_cardapio`.`items`.`id`=`admin_cardapio`.`contents`.`items_id`
WHERE `items`.`parent_id`='".$_GET['productsId']."'");
//MONTANDO O ARRAY DINAMICAMENTE DA BASE DE DADOS DE MENU PRINCIPAL

    //VARENDO PARA LISTAR AS SUBCATEGORIAS RELACIONADAS A CATEGORIA PAI
    $SQL_SUBCAT = $conexao->query("SELECT name FROM `items` WHERE `parent_id`='".$_GET['productsId']."'");
    
    foreach ($SQL_SUBCAT as $key){
        if(count($key) > 1){
            $subcategorias .= $key['name'].",";
        }
    }
    //LIMPANDO A ULTIMA VIRGULA DA LISTA DE SUBCATEGORIAS    
    $subcategorias = substr($subcategorias, 0, -1);


    foreach ($obj_produtos as $key => $val) {
           
            $produtosList[] = array($key => array(
                            'Produtos' => array( 
                                $val['CATEGORIA'] => array( 
                                    $val,'Subcategorias'=> $subcategorias  
                                )
                                // $val 
                            )
                ));
            //$produtosList = $key;
           
        }  
        //echo json_encode( $produtosList );
        print_r($produtosList);
 }
 ?>
