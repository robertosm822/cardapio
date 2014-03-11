<?php
/*
	Desenvolvido por: Roberto S. Melo - 12/02/2014
	Empresa: Me Digital Tecnologia
	Contato: robertomelo822@gmail.com
*/
  $dados['id'] = (integer)$_POST['id'];
  $dados['campo'] = $_POST['campo'];
  $dados['valor'] = $_POST['valor'];
  
  //var_dump($dados);
  //verifica se ID NAO EH PASSSADO VAZIO OU NAO CORRESPONDE A UM NUMERO
  
if(isset($dados['id']) && is_integer($dados['id'])){  
	require_once('conn.php');
	
	/*
	//faz consulta para verificar se ja existe o mesmo codigo na base
	$ultimo_cod = $conexao->query("SELECT * FROM `contents` WHERE `codigo_prato`=".$dados['valor'].";")->fetchAll();;
	foreach ($ultimo_cod as $ult){
		$codigoUlt = $ult['id'];	
	}
	//verificando se codigo do prato eh repetido e impossibilitando o cadastro
	if($codigoUlt !== NULL || $codigoUlt >0){
		echo '<script>alert("Não é permitido o cadastro de codigo repetido!");</script>';
		exit;
	}  //fim da verificacao de codigo repetido
	*/
		
		//editando o codigo do prato
		$query = "UPDATE  `contents` SET  `valor` =  :valor WHERE  `id` =:id";
		// o método PDO::prepare() retorna um objeto da classe PDOStatement ou FALSE se ocorreu algum erro (neste caso use $pdo->errorInfo() para descobrir o que deu errado)
		$stmt = $conexao->prepare($query);
			 
		// utilizamos o método PDOStatement::bindValue() que aceita como parâmetros a posição do :nome_do_campo que a variável irá substituir
		$stmt->bindValue(":valor", $dados['valor']);
		$stmt->bindValue(":id", $dados['id']);
		
		//TRATAMENTO DE ERROS DO PDO	 
		try {
			// executamos o statement
			$ok = $stmt->execute();
		} catch (PDOException $e) {
			var_dump($e->errorInfo[0]);
			exit;
		}
		
		echo '<script>$("#mensagem").show();$("#mensagem").css({"border":"1px solid green", "background-color":"#90EE90", "margin":"-15px 10px 10px 10px","opacity":"1.0"}); $("#mensagem").append("Alterado com sucesso!");</script>';
	} else {
		echo '<script>$("#mensagem").show();$("#mensagem").css({"border":"1px solid red", "margin":"0px 10px 10px 10px", "background-color":"#FF7256"}); $("#mensagem").append("Ocorreu um erro.");</script>';
		
	}

?>