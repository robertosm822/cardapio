<?php
	$codigo = (isset($_POST['codigo'])) ? $_POST['codigo']: '' ;
	$categoria = (isset($_POST['categoria'])) ? $_POST['categoria'] : '' ;
	
	if($codigo !== "" && $categoria !== ""){
		

		require_once('controller/conn.php');
		//INSERINDO NO CONTEUDO DOS CARDAPIOS 		
		
		try {

			//INCREMENTANDO MAIS UM AO TOTAL DE ACESSOS DOS PRATOS (CONTENTS)
			$sql2 = "UPDATE  `contents` set `acesso`= (`acesso`+1)  WHERE `codigo_prato`=:codigo;";

			$statement = $conexao->prepare($sql2);
			$statement->bindValue(":codigo", $codigo);
			$count = $statement->execute();
			echo "Conteudo, ok";
			  $conn = null;        // Disconnect
			}
		catch(PDOException $e) {
			  echo $e->getMessage();
		}
		
		try {

			//INCREMENTANDO MAIS UM AO TOTAL DE ACESSOS DOS INTENS DAS CATEGORIAS (ITEMS)
			$sql = "UPDATE  `items` set `acesso`= (`acesso`+1)  WHERE  name = :categoria;";

			$statement = $conexao->prepare($sql);
			$statement->bindValue(":categoria", $categoria);
			$count = $statement->execute();
			echo "<br>Categoria, ok";
			  $conn = null;        // Disconnect
			}
		catch(PDOException $e) {
			  echo $e->getMessage();
		}
		
	}	else{
		echo "Ocorreu um Erro.";
	}
?>