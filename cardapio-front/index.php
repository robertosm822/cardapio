<?php
require_once('controller/conn.php');
	//trazendo a ultima atulizacao do cardapio
	$ultimo_data = $conexao->query("SELECT  DATE_FORMAT(  `modified`, '%d/%c/%Y - %H:%i:%s' ) as 'modificacao' FROM `contents` WHERE 1 ORDER BY `modified` DESC LIMIT 0,1")->fetchAll();;
	foreach ($ultimo_data as $ult){
		$data_update = $ult['modificacao'];	
	}

/*
	PROJETAR CONSTRUIR A VERSÃO DESTE LAYOUT DINÂMICO COM APENAS A PASSAGEM DO PARAMETRO ID DO RESTAURANTE
	ADICIONANDO A URL O SEGINTE FORMATO /cardapio-front/?rest=11#home
	MODIFICAR AS CONSULTAS RELACIONANDO AO RESTAURANTE TODO O CONTEUDO
	*/	
//primeira verificacao se é um numero ou não eh vazio	
if(isset($_GET['rest']) && is_numeric((integer)$_GET['rest']) && isset($_GET['card']) && is_numeric((integer)$_GET['card'])){

$restaurante = (integer)$_GET['rest'];
$card= (integer)$_GET['card'];

//VERIFICAR SE O CARDÁPIO EXISTE
$existes = $conexao->query("SELECT * FROM `restaurants` WHERE `id`=".$restaurante." ")->fetchAll();
	foreach ($existes as $ult){
		$existe 		= (integer)$ult['id'];
		$endereco 		= $ult['endereco'];
		$telefone 		= $ult['telefone'];
		$estado 		= $ult['estado'];
		$nacionalidade 	= $ult['nacionalidade'];
		$email 			= $ult['email'];
	}
	// MENSAGEM DE QUEM SOMOS AMBAS AS LINGUAS
	$SQL_QUEMSOMOS_EN = $conexao->query("SELECT * FROM bloco_quemsomos WHERE restaurants_id='$existe' AND lingua='#en_'")->fetchAll();
	foreach($SQL_QUEMSOMOS_EN as $ln){
		$titulo_quem_somos_en = $ln['titulo'];
		$texto_quem_somos_en = $ln['texto'];
	}
	$SQL_QUEMSOMOS_PT = $conexao->query("SELECT * FROM bloco_quemsomos WHERE restaurants_id='$existe' AND lingua='#pt_'")->fetchAll();
	foreach($SQL_QUEMSOMOS_PT as $ln){
		$titulo_quem_somos_pt = $ln['titulo'];
		$texto_quem_somos_pt = $ln['texto'];
	}
if($existe !== $restaurante){
	echo "Inexistente!";
	exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<title>Card&aacute;pio Digital | Opium</title>
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
	<!-- JS: Plugin jQuery e Easing -->
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.min.js"></script>

<!-- JS: Scripts livres -->
<script type="text/javascript" src="js/scripts.js"></script>
	<script>
		function 	enviaValor(valor, categ=""){
			var valor = valor;
			
			$(document).ready(function(){
					//efetuando a gravação e contabilização de pratos mais acessados
					$.post( 
						"./actions.php",
						{ codigo: valor, categoria: categ  },
						function(data) {
							//console.log(data);
						}
					  );
			});
		}
	</script>
</head>
<body>
	<!-- Iniciando tela Home -->
	<a href="#inicio" id="inicio" class="loadAjax"></a>	
	
	<!-- Foto Zoom -->
	<div id="photoZoom"><div class="close">&nbsp;</div></div>

	<!-- Div Pai -->
	<div id="all">
		<div id="interna">
			<div id="backtotop" name="backtotop"></div>
			<!-- Header / Cabecalho -->
			<header id="header">
				

				<!-- SEM IDIOMA: Header -->
				<div class="content" id="topo" name="topo" style="display:block;">
					<a href="#home" class="loadAjax">
						<div id="logo">
							
							<?php 
								//EXIBINDO A LOGO DINAMICAMENTE
								$sql_restaurant_photo = $conexao->query("SELECT * FROM restaurants Where id=$restaurante;")->fetchAll();
								foreach ($sql_restaurant_photo as $lnRest){	
									$idRest = $lnRest['id'];
									$logoRest = '<img src="../cardapio_cms/app/webroot'.$lnRest['foto'].'" alt="Opium Logo" />';
								}
								if(isset($idRest) && $idRest !== ''  ){
									echo $logoRest;
								} else { echo '<img src="img/logo/no_image.jpg" alt="Opium Logo" style="width:25% !important;"  />'; }
							?>
						<!--	<img src="img/logo/logo_opium.png" alt="Logo Opium" /> -->
						</div>
					</a>
					
				</div>
				<!-- SEM IDIOMA: Fim Header -->

				<!-- PT: Inicio Header -->
				<div class="content" id="pt_topo">
					<a href="#pt_menu" class="loadAjax">
						<div id="logo">
							<?php 
								//EXIBINDO A LOGO DINAMICAMENTE
								$sql_restaurant_photo = $conexao->query("SELECT * FROM restaurants Where id=$restaurante;")->fetchAll();
								foreach ($sql_restaurant_photo as $lnRest){	
									$idRest = $lnRest['id'];
									$logoRest = '<img src="../cardapio_cms/app/webroot'.$lnRest['foto'].'" alt="Opium Logo" />';
								}
								if(isset($idRest) && $idRest !== ''  ){
									echo $logoRest;
								} else { echo '<img src="img/logo/no_image.jpg" alt="Opium Logo" style="width:25% !important;"  />'; }
							?>	
						<!--	<img src="img/logo/logo_opium.png" alt="Logo Opium" /> -->
						</div>
					</a>
					
					
					<a href="#" onclick="return false;" class="menu-mobile">MENU</a>
					<nav class="categ">
						<ul>
						<?php
							//EXIBINDO O MENU DINÂMICO EM PORTUGUES
							$sql_sub_tit = $conexao->query("SELECT i.href,i.name FROM `items` as i INNER JOIN cards as c ON c.id= $card AND c.restaurants_id = $restaurante WHERE i.card_id='$card' AND i.level = '1' AND i.active = '1' AND i.`href` <> 'NULL' AND i.language='#pt_' ORDER BY i.position ASC")->fetchAll();
								if(!$sql_sub_tit){
								  //print_r($conexao->errorInfo());
								}
							foreach ($sql_sub_tit as $lnSub){
								//var_dump($lnSub);
								echo '<li><a href="'.$lnSub['href'].'" class="subtitulo loadAjax">'.$lnSub['name'].'</a></li>';
							}
							?>
						
							<div class="clear"></div>
						</ul>
						<div class="clear"></div>
					</nav>
					<div class="clear"></div>
				</div>
				<!-- PT: Fim Header -->

				<!-- EN: Inicio Header -->
				<div class="content" id="en_topo">
					<a href="#en_menu" class="loadAjax">
						<div id="logo">
							<?php 
								//EXIBINDO A LOGO DINAMICAMENTE
								$sql_restaurant_photo = $conexao->query("SELECT * FROM restaurants Where id=$restaurante;")->fetchAll();
								foreach ($sql_restaurant_photo as $lnRest){	
									$idRest = $lnRest['id'];
									$logoRest = '<img src="../cardapio_cms/app/webroot'.$lnRest['foto'].'" alt="Opium Logo" />';
								}
								if(isset($idRest) && $idRest !== ''  ){
									echo $logoRest;
								} else { echo '<img src="img/logo/no_image.jpg" alt="Opium Logo" style="width:25% !important;"  />'; }
							?>
							
							<!-- <img src="img/logo/logo_opium.png" alt="Opium Logo" /> -->
						</div>
					</a>
					
					
					<a href="#" onclick="return false;" class="menu-mobile">MENU</a>
					<nav class="categ">
						<ul>
						<?php
							//EXIBINDO O MENU DINÂMICO EM INGLES
							$sql_sub_tit = $conexao->query("SELECT i.href,i.name FROM `items` as i INNER JOIN cards as c ON c.id= $card AND c.restaurants_id = $restaurante WHERE i.card_id='$card' AND i.level = '1' AND i.active = '1' AND i.`href` <> 'NULL' AND i.language='#en_' ORDER BY i.position ASC")->fetchAll();
								if(!$sql_sub_tit){
								  //print_r($conexao->errorInfo());
								}
							foreach ($sql_sub_tit as $lnSub){
								echo '<li><a href="'.$lnSub['href'].'" class="subtitulo loadAjax">'.$lnSub['name'].'</a></li>';
							}
							?>
				
							<div class="clear"></div>
						</ul>
						<div class="clear"></div>
					</nav>
					<div class="clear"></div>
				</div>
				<!-- EN: Fim Footer -->
			</header>

			<!-- Body / Corpo -->
			<div id="corpo">
				<!-- SEM IDIOMA: Inicio Home -->
				<div class="content" id="home" style="display:block;">
					<div class="bg_home">
						<hgroup>
							<h1 class="titulo intro">Escolha a l&iacute;ngua</h1>
							<h2 class="subtitulo intro">Choose language</h2>
						</hgroup>
						<div id="flags">
							<a class="loadAjax flag" href="#pt_menu"><img src="img/button/lang-pt.png" alt="Portugu&ecirc;s" /></a>
							<a class="loadAjax flag" href="#en_menu"><img src="img/button/lang-en.png" alt="English" /></a>
							<div class="clear"></div>
						</div>
					</div>
				</div>
				<!-- SEM IDIOMA: Fim Home -->

				<!-- PT: Inicio Menu -->
				<div class="content" id="pt_menu">
					<div class="bg_home">
						<nav class="intro">
							<h1 class="menuTitulo">Menu</h1>
							<?php
							//EXIBINDO O MENU DINÂMICO EM PORTUGUES
							$sql = $conexao->query("SELECT i.href,i.name FROM `items` as i INNER JOIN cards as c ON c.id= $card AND c.restaurants_id = $restaurante WHERE i.card_id='$card' AND i.level = '1' AND i.active = '1' AND i.`href` <> 'NULL' AND i.language='#pt_' ORDER BY i.position ASC")->fetchAll();
								if(!$sql){
								  //print_r($conexao->errorInfo());
								}
							foreach ($sql as $ln){
								echo '<a href="'.$ln['href'].'" class="loadAjax menuCategoria cor_3">'.$ln['name'].'</a>';
							}
							?>
							
							<div class="clear"></div>
						</nav>
					</div>
				</div>
				<!-- PT: Fim Menu -->
				
				<!-- PT: Inicio Ajuda -->
				<div class="content" id="pt_ajuda">
					<div class="bg_home">
						<hgroup style="padding: 15px 0px 30px 0px;">
							<h1 class="titulo">Ajuda!</h1>
							<!-- <h2 class="subtitulo">Problemas com o Card&aacute;pio Digital?</h2> -->
						</hgroup>
						<div class="box-help">
							<p class="help-question"	id="hp-pt1">1. Como mudar o idioma?</p>
							<p class="help-answer"		id="ha-pt1">
								<strong>1&ordm; Modo:</strong>
								Clicar na logomarca do Restaurante até voltar ao início do sistema.
								Na página inicial do sistema, existem os idiomas suportados, basta clicar na bandeira do idioma.<br/><br/>
								
								<strong>2&ordm; Modo:</strong>
								Clicar no link <strong>"Idiomas"</strong>, que fica localizado no rodapé do sistema, na parte esquerda.
								Ele também exibirá a tela com as bandeiras para a escolha do idioma, basta tocar na bandeira.
							</p>
							<p class="help-question"	id="hp-pt2">2. Como visualizar as fotos dos produtos?</p>
							<p class="help-answer"		id="ha-pt2">
								Ao escolher uma categoria no menu, será exibida uma tela com os produtos relacionados a esta categoria.
								Os produtos que tem foto cadastrada no sistema, exibem em sua lateral direita, uma miniatura da foto.
								Para ampliar esta imagem, basta tocar diretamente nela. Se isso não funcionar, verifique o problema
								junto com um funcionário do estabelecimento.
							</p>
							
						</div>
						<div class="clear"></div>
						<br><br>
						<div class="update"><p>Atualizado em: <span class="dateTime"><?php echo $data_update;?></span></p></div>
						
					</div>
				</div>
				<!-- PT: Fim Ajuda -->

				<!-- PT: Inicio O Opium -->
				<div class="content" id="pt_historia">
					<div class="bg_home">
						<hgroup style="padding-top:80px;">
							<h1 class="titulo"><?php echo $titulo_quem_somos_pt;?></h1>
							<!-- <h2 class="subtitulo">Era uma vez...</h2> -->
						</hgroup>
						<div style="margin-top:20px; padding: 0px 30px;">
							<!-- <p style="text-align:left; font-weight:normal;">
								Requintado e &uacute;nico, o restaurante Opium esbanja charme ao trazer um novo conceito em
								culin&aacute;ria asi&aacute;tica contempor&acirc;nea. Com influ&ecirc;ncias da China,
								Jap&atilde;o, Vietn&atilde;, &Iacute;ndia e Tail&acirc;ndia, o preparo e apresenta&ccedil;&atilde;o
								dos pratos mesclam sabores inusitados e tradicionais, surpreendendo todos os paladares.<br/>
							</p>
							<p>
								E para harmonizar os pratos, o restaurante conta com cerca de 50 r&oacute;tulos de vinhos. Do aroma
								das especiarias &agrave; escolha dos ingredientes locais, passando pela decora&ccedil;&atilde;o com
								toques orientais, o Opium, localizado no t&eacute;rreo do hotel Ipanema Plaza na esquina movimentada
								da Farme de Amoedo com a Prudente de Morais, oferece aos clientes uma experi&ecirc;ncia sensorial.
							</p> -->
							<?php echo $texto_quem_somos_pt;?>
						</div>
					</div>
				</div>
				<!-- PT: Fim O Opium -->


				<!-- PT: Inicio de Todos os Pratos Dinamicamente -->
				<?php
				$sql_titulo = $conexao->query("
					SELECT i.href,i.id,i.name FROM  `items` as i 
					INNER JOIN cards as c ON c.id= $card AND c.restaurants_id = $restaurante
					WHERE i.level = '1' AND i.active = '1' AND i.`href` <> 'NULL' AND i.language='#pt_' ORDER BY i.position ASC")->fetchAll();
					if(!$sql_titulo){
					  //print_r($conexao->errorInfo());
					  //echo "Deu ruim aqui";
					}
				foreach ($sql_titulo as $href){
					//retira o caracter # que vem cadastrado no banco
				 $subst = str_replace("#","",$href['href']);
				 $id_categoria = $href['id']."|";
					//EXIBE A DIV COM O ID DO JAVASCRIPT CORRESPONDENTE
			?>
			
			<div class="content" id="<?php echo $subst;?>">
			
				<?php
				//$sql_pratos_princi = $conexao->query("SELECT * FROM `items` WHERE `parent_id` = '".$id_menu."'")->fetchAll();
				$sql_pratos_princi = $conexao->query("
					SELECT i.id,i.name FROM  `items` AS i INNER JOIN cards AS c ON c.id =".$card."
					AND c.restaurants_id =".$restaurante."
					WHERE i.card_id='".$card."' AND i.`parent_id` =  '".$id_categoria."'
					AND i.`active` =  '1' ORDER BY i.position ASC")->fetchAll();
					if(!$sql_pratos_princi){
					  print_r($conexao->errorInfo());
					}			
				foreach ($sql_pratos_princi as $titulo){		
					echo '<h1 class="subcategoria"> '.$titulo['name'].' </h1>';
						$sql_mostra_prato = $conexao->query("
						SELECT c.codigo_prato, c.nome, c.valor, c.id,c.photo, c.description FROM `contents` as c 
						INNER JOIN items as i ON i.id = c.items_id AND i.card_id= '".$card."'
						WHERE i.card_id='".$card."' AND c.items_id = '".$titulo['id']."' AND c.`active`='1' ORDER BY c.position ASC")->fetchAll();
							if(!$sql_mostra_prato){
							  //print_r($conexao->errorInfo());
						   }
						foreach ($sql_mostra_prato as $prato){
							echo '
								<div id="pratoStatic" onclick="enviaValor('.$prato['codigo_prato'].', \''.$titulo['name'].'\');" class="item">
								<div class="info">
									<p class="produto">
										<span class="codigo">'.$prato['codigo_prato'].'</span> '.$prato['nome'].'
										<span class="preco">R$ '.$prato['valor'].'</span>
									</p>
									
									';
								//verifica se existe imagem cadastrada
								
								echo (!is_null($prato['photo']))? '<div class="imagem"> <img src="../cardapio_cms/app/webroot/files/content/photo/'.$prato['id'].'/'.$prato['photo'].'" class="photo" /></div>':''; 
								echo	'<p class="descricao">
										'.$prato['description'].'
									</p>
								</div>
							</div>
							
							';
						}
				}
				
				?>
					<div class="clear"></div>
			</div>  <!-- FIM DO TESTE PHP -->
			
			<?php
				}  //FIM DA ADAPTACAO PHP PARA PORTUGUES
				?>
		

				<!-- EN: Inicio Menu -->
				<div class="content" id="en_menu">
					<div class="bg_home">
						<nav class="intro">
							<h1 class="menuTitulo">Menu</h1>
							<?php
							//EXIBINDO O MENU DINÂMICO EM INGLES
							//echo "SELECT i.href,i.name FROM `items` as i INNER JOIN cards as c ON c.id='$card' AND c.restaurants_id = $restaurante WHERE i.level = '1' AND i.active = '1' AND i.`href` <> 'NULL' AND i.language='#en_' ORDER BY i.position ASC";
							$sql = $conexao->query("SELECT i.href,i.name FROM `items` as i INNER JOIN cards as c ON c.id='$card'  AND c.restaurants_id = $restaurante WHERE i.card_id='$card' AND i.level = '1' AND i.active = '1' AND i.`href` <> 'NULL' AND i.language='#en_' ORDER BY i.position ASC")->fetchAll();
								if(!$sql){
								  //print_r($conexao->errorInfo());
								}
							foreach ($sql as $ln2){
								echo '<a href="'.$ln2['href'].'" class="loadAjax menuCategoria cor_3">'.$ln2['name'].'</a>';
							}
							?>
							<!--<a href="#en_drinks"	class="loadAjax menuCategoria cor_3">DRINKS</a>-->
							<div class="clear"></div>
						</nav>
					</div>
				</div>
				<!-- EN: Fim Menu -->

				<!-- EN: Inicio Help -->
				<div class="content" id="en_help">
					<div class="bg_home">
						<hgroup style="padding: 15px 0px 30px 0px;">
							<h1 class="titulo">Help!</h1>
							<!-- <h2 class="subtitulo">Problems with this Menu?</h2> -->
						</hgroup>
						<div class="box-help">
							<p class="help-question"	id="hp-en1">1. How can I change the language?</p>
							<p class="help-answer"		id="ha-en1">
								<strong>1&ordm; Mode:</strong>
								Click on the restaurant logo to return to the beginning of the system.
								On the homepage of the system, there are the supported languages​​, just click the flag language.<br/><br/>				
								<strong>2&ordm; Mode:</strong>
								Click on the <strong>"Languages​​"</strong>, which is located at the bottom of the system, on the left.
								It also displays the screen with the flags for language selection, simply tap the banner.
							</p>
							<p class="help-question"	id="hp-en2">2. How to view the photos of the products?</p>
							<p class="help-answer"		id="ha-en2">
								When choosing a category from the menu, a screen appears with the products related to this category.
								Products which have photo registered in the system, they'll be display on your right side, in a thumbnail photo. To enlarge, just touch it directly. If it does not work, check the problem with an employee of the establishment..
							</p>
						</div>
						
						<div class="clear"></div>
						<br><br>
						<div class="update"><p>Update: <span class="dateTime"><?php echo $data_update;?></span></p></div>
						
						
					</div>
				</div>
				<!-- EN: Fim Help -->

				<!-- EN: Inicio The Opium -->
				<div class="content" id="en_history">
					<div class="bg_home">
						<hgroup style="padding-top:80px;">
							<h1 class="titulo"><?php echo $titulo_quem_somos_en;?></h1>
							
						</hgroup>
						<div style="margin-top:20px; padding: 0px 30px;">
							<!-- <p style="text-align:left; font-weight:normal;">
								Exquisite and unique, the restaurant Opium  is full of charm and bring a new concept of contemporany asian cuisine. With influences from China, Japan, Vietnam, India
								and Thailand, the preparation and presentation of the dishes blend traditional
								and unusual flavors, surprising all palates.
							</p>
							<p>
								And to harmonize the dishes, the restaurant has about 50 wine labels. The aroma
								of the spices to the choice of local ingredients, through decor with oriental
								touches, Opium, located downstairs from Ipanema Plaza hotel in bustling corner
								of Farme de Amoedo with Prudente de Morais, offers guests a sensory experience.
							</p> -->
							<?php echo $texto_quem_somos_en;?>
						</div>
					</div>
				</div>
				<!-- EN: Fim The Opium -->

				<!-- EN: Inicio Starters -->
				
<?php
				$sql_titulo_en = $conexao->query("
					SELECT i.href,i.id,i.name FROM  `items` as i 
					INNER JOIN cards as c ON c.id= $card AND c.restaurants_id = $restaurante
					WHERE i.card_id='$card' AND i.level = '1' AND i.active = '1' AND i.`href` <> 'NULL' AND i.language='#en_' ORDER BY i.position ASC")->fetchAll();
					if(!$sql_titulo_en){
					  //print_r($conexao->errorInfo());
					  //echo "Deu ruim aqui";
					}
				foreach ($sql_titulo_en as $categ){
					//retira o caracter # que vem cadastrado no banco
				 $subst2 = str_replace("#","",$categ['href']);
				 $id_categoria2 = $categ['id']."|";
					//EXIBE A DIV COM O ID DO JAVASCRIPT CORRESPONDENTE
			?>
			
			<div class="content" id="<?php echo $subst2;?>">
			
				<?php
				//$sql_pratos_princi = $conexao->query("SELECT * FROM `items` WHERE `parent_id` = '".$id_menu."'")->fetchAll();
				$sql_pratos_princi_en = $conexao->query("
					SELECT i.id,i.name FROM  `items` AS i INNER JOIN cards AS c ON c.id =".$card."
					AND c.restaurants_id =".$restaurante."
					WHERE i.card_id='$card' AND i.`parent_id` =  '".$id_categoria2."'
					AND i.`active` =  '1' ORDER BY i.position ASC")->fetchAll();
					if(!$sql_pratos_princi_en){
					  print_r($conexao->errorInfo());
					}			
				foreach ($sql_pratos_princi_en as $titulo2){		
					echo '<h1 class="subcategoria"> '.$titulo2['name'].' </h1>';
						$sql_mostra_prato_en = $conexao->query("SELECT * FROM `contents` WHERE items_id = '".$titulo2['id']."' AND `active`='1' ORDER BY position ASC;")->fetchAll();
							if(!$sql_mostra_prato_en){
							  //print_r($conexao->errorInfo());
						   }
						foreach ($sql_mostra_prato_en as $prato2){
							echo '
								
								<div id="pratoStatic" onclick="enviaValor('.$prato2['codigo_prato'].', \''.$titulo2['name'].'\');" title="'.$prato2['codigo_prato'].'" class="item">
								<div class="info">
									<p class="produto">
										<span class="codigo">'.$prato2['codigo_prato'].'</span> '.$prato2['nome'].'
										<span class="preco">R$ '.$prato2['valor'].'</span>
									</p>
									
									';
								//verifica se existe imagem cadastrada
								
								echo (!is_null($prato2['photo']))? '<div class="imagem"> <img src="../cardapio_cms/app/webroot/files/content/photo/'.$prato2['id'].'/'.$prato2['photo'].'" class="photo" /></div>':''; 
								echo	'<p class="descricao">
										'.$prato2['description'].'
									</p>
								</div>
							</div>
							
							
							';
						}
				}
				
				?>
					<div class="clear"></div>
			</div>  <!-- FIM DO TESTE PHP -->
			
			<?php
				}  //FIM DA ADAPTACAO PHP PARA INGLES
				?>
			<div class="clear"></div>
			
			<!-- Footer / Rodape -->
			<footer id="footer">
				<!-- SEM IDIOMA: Inicio Footer -->
				<div class="content" id="rodape" style="display:block;">
					<div id="links_esquerda">&nbsp;</div>
					<div id="links_direita">&nbsp;</div>
					<div class="clear"></div>
					<div id="copyright">
						<div id="copytext"><?php echo $endereco ." ".$estado." - ".$nacionalidade." | "." Tel.: ".$telefone = $ult['telefone'];?></div>
						<div id="developed">Desenvolvido por: Me Digital</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
				<!-- SEM IDIOMA: Fim Footer -->

				<!-- PT: Inicio Footer -->
				<div class="content" id="pt_rodape">
					<div id="links_esquerda"><a href="#backtotop">Ir para o topo</a></div>
					<div id="links_esquerda"><a class="loadAjax" href="#home">Idiomas</a></div>
					<div id="links_direita">
						<a class="loadAjax" href="#pt_ajuda">Ajuda</a>
						<a class="loadAjax" href="#pt_historia">O Opium</a>
						<!-- <a class="loadAjax" href="#pt_creditos">Cr&eacute;ditos</a> -->
					</div>
					<div class="clear"></div>
					<div id="copyright">
						<div id="copytext"><?php echo $endereco ." ".$estado." - ".$nacionalidade." | "." Tel.: ".$telefone = $ult['telefone'];?></div>
						<div id="developed">Desenvolvido por: Me Digital</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
				<!-- PT: Fim Footer -->

				<!-- EN: Inicio Footer -->
				<div class="content" id="en_rodape">
					<div id="links_esquerda"><a href="#backtotop">Back to top</a></div>
					<div id="links_esquerda"><a class="loadAjax" href="#home">Language</a></div>
					<div id="links_direita">
						<a class="loadAjax" href="#en_help">Help</a>
						<a class="loadAjax" href="#en_history">The Opium</a>
						<!-- <a class="loadAjax" href="#en_credits">Credits</a> -->
					</div>
					<div class="clear"></div>
					<div id="copyright">
						<div id="copytext"><?php echo $endereco ." ".$estado." - ".$nacionalidade." | "." Tel.: ".$telefone = $ult['telefone'];?></div>
						<div id="developed">Developed by: Me Digital</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
				<!-- EN: Fim Footer -->
			</footer>
		</div>
	</div>

	<!-- Like Button -->
	<div id="fb-root"></div>
	

	
</body>



</html>
<?php }?>