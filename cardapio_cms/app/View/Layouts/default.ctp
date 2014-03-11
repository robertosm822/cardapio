<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

//METODO requestAction() QUE RETORNA UMA FUNCAO CRIADA NO CONTROLADOR RESTAURANTS
$IdUser=$this->Session->read('Auth.User.id');
//SOMENTE SE LOGADO PODERA TRAZER O RESTAURANTE ASSOCIADO AO USUARIO LOGADO - 14-02/2014
$mostraIdRest = 0;
if(isset($IdUser)){
 $mostraIdRest = $this->requestAction('/restaurants/mostraIdRest/'.$this->Session->read('Auth.User.id'));
}
 
//restringindo itens de menu - 11-02-2014
$valorPermission = $this->Session->read('Auth.User'); //CONSTROI UM ARRAY COM AS INFORMACOES RELACIONADAS AO USER
$idPermi = $this->Session->read('Auth.User.group_id'); 
   //debug($this->Session->read('Auth.User'));
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br">
<head>
	<?php echo $this->Html->charset(); ?>
    <title>
		<?php echo "CMS Cardápio - Web"; ?>
	</title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0" />
		<?php
		echo $this->Html->meta('icon');
                //IMPORTACAO DO CSS DE TODAS AS PAGINAS
		echo $this->Html->css('cake.generic');
                
                //CSS PERSONALIZADO
                //echo $this->Html->css('cardapio.default');
                //Acrescimo de CSS no sistema - 11/06/2013
                //echo $this->Html->css('menu.faleconosco');
                //importando o bootstrap
                echo $this->Html->css('bootstrap.min');
                
                //echo $this->Html->css('menu.principal');
				echo $this->Html->css('bootstrap-responsive');
                
		echo $this->fetch('meta');
		
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
	  
	  
#profilePhoto{
    float: right;
    margin-right: -550px;
    margin-top: 2.5px;
    border-right: 3px solid #46464B;
    height: 100%;
}
.breadcrumb {
    background-color: #F5F5F5;
    border-radius: 4px 4px 4px 4px;
    list-style: none outside none;
    margin: 0 0 20px;
    padding: 8px 15px;
    font-size: 11px;
}
.breadcrumb ul > li {
    display: inline-block;
    text-shadow: 0 1px 0 #FFFFFF;
}
.breadcrumb li {
    line-height: 20px;
}
.breadcrumb a {
    color: #769D13;
}
.breadcrumb a {
    color: #0088CC;
    text-decoration: none;
}
.breadcrumb .active {
    color: #999999;
}
#id_breadcrumbs {
   float:left; background-color: #F5F5F5; font-size:16px; padding-right: 380px; 
}
#breadcrumbs_menu {
    margin-right: -10px !important;
}
	@media screen and (max-width:980px){
		body{
			padding-top:0;
		}
	}
 </style>
  
</head>
<body>
    
   <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
		<div class="container">
			
		  <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  
		  
		<a class="brand" href="http://<?php echo $_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/')."";?>">
			<img style="-webkit-user-select: none" src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/')."img/logo-header.png";?>">
			Cardápio CMS
		</a>
		  
		  <div class="nav-collapse collapse" style="margin-top: 10px;">
			 <?php if($this->Session->read('Auth.User.id') !== null){ ?>
			   <div class="pull-right btn-group">
					<button class="btn btn-danger"><i class="icon-user icon-white" style="text-decoration: none; color: white;"></i> &nbsp; Olá <?php echo "<span style='padding: 5px;'>".$this->Session->read('Auth.User.username')."</span>";?></a></button>
					<button class="btn btn-info dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
					<ul class="dropdown-menu">
						
						<li>
							<a style="text-decoration:none !important;" href="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/')."users/edit/".$this->Session->read('Auth.User.id');?>">
								<i class="icon-edit"></i> Editar Perfil
							</a>
						</li>
						
						<li class="divider"></li>
						
						<li>
							<a style="text-decoration:none !important;" href="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/')."users/logout";?>">
								<i class="icon-off"></i> Sair
							</a>
						</li>
						
					</ul>
				
				</div>
			</div>
				
			<ul class="nav">
					<?php  //RESTINGINDO ACESSO SOMENTE AO MASTER DIGITAL / MASTER PRINCIPAL / ADMINISTRADOR
					if($idPermi == 1 || $idPermi == 2 || $idPermi == 3){
					?>
					<li style="margin-left: 10px; ">				
					<div class="btn-group">
							<button class="btn btn-info" onclick="javascript:window.location='<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>users/index/';">
							<!--	<a href="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>users/index/" style="text-decoration: none; color: white;"> Usuários</a> -->
								<a  style="text-decoration: none; color: white;"> Usuários</a>
								
							</button>
							<button class="btn btn-info dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li><a href="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>users/index"><img style="margin-left: -15px; width: 16px;" src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>img/ativo.png"> Usuários Ativos </a></li>
								<li><a href="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>users/inativos"><img style="margin-left: -15px; width: 16px; height:16px;" src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>img/desable.png"> Usuários Inativos </a></li>
								<li><a href="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>groups/"><img style="margin-left: -15px; width: 16px;" src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>img/group-icon.png"> Grupo de Usuários</a></li>
								
							</ul>
					</div>
					</li>
					<?php }?>
					
					<li>
						
							<div class="btn-group">
									
									<button class="btn btn-info" onClick="javascript:window.location='<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>cards';">
										<a href="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>cards" style="text-decoration: none; color: white;" alt="cardapio"> Cardápios</a>
									</button>
									
									
							</div>
						
					</li>
					
					<?php  //RESTINGINDO ACESSO SOMENTE AO ADMINISTRADOR
					if($idPermi == 1){
					?>
					<li>
							<div class="btn-group">
									<!--  onClick="javascript:window.location='<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>logs';" -->
									<button class="btn btn-info" style="text-decoration: none; color: white;font-weight: bold;" >
										Administrar
									</button>
							
							<button class="btn btn-info dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
							
							<ul class="dropdown-menu" style="width:200px;">
								<li><a href="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>privileges/index"><img style="margin-left: -15px; width: 16px;" src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>img/cadeado-icon.png"> Privilégios </a></li>			
								<li><a href="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>logs/listar" style="text-decoration: none;" alt="Logs do Sistema"> <img style="margin-left: -15px; width: 16px;" src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>img/Log_B-20-26.png">  Logs do Sistema</a></li>
								<li><a href="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>restaurants/view/<?php echo $mostraIdRest;?>" style="text-decoration: none;" alt="Logs do Sistema"> <img style="margin-left: -15px; width: 16px;" src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>img/estabelecimento.jpg">  Estabelecimento</a></li>
								<li><a href="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>restaurants/edit/<?php echo $mostraIdRest;?>" style="text-decoration: none;" alt="Logs do Sistema"> <span class="icon-pencil" style="margin-left: -15px;"></span> Editar Estabelecimento</a></li>
								<li><a href="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>items/precificar/<?php echo $mostraIdRest;?>" style="text-decoration: none;" alt="Logs do Sistema"> <img style="margin-left: -15px; width: 16px;" src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>img/icone_precificacao.png" /> Precificar em Lote</a></li>
								
							</ul>
					</div>
					</li>
					<?php }?>
					
					<!-- DESATIVADO POR SE TRATAR DE UM RECURSO QUE NAO SERA USADO NESTE MOMENTO
					<li style="margin-left: 10px;">
						<div class="btn-group">
							<button class="btn btn-info">
								<a href="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>restaurants" style="text-decoration: none; color: white;"> 
									<img style="margin-left: -5px; width: 15px;" src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>img/restaurant-icon.png">
									&nbsp; Restaurantes &nbsp; 
								</a>
							</button>
							
							<button class="btn btn-info dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
							<ul class="dropdown-menu">
							  <li><a href="#"><i class="icon-th-list"></i> Dados da Empresa</a></li>
							 
							</ul>
						</div>
					</li>
					-->
              
			</ul>
                         <?php }?>
		 </div>
		</div>
      
    </div> <!-- FIM DO MENU DO TOPO --> 

	<div id="container">
             
            
		<div id="content" style=" overflow: auto;">                    
                        <?php echo $this->Session->flash(); ?>
                        
                        <?php echo $this->Session->flash('auth'); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
    
       <script src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>js/jquery.js"></script>
    <script src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>js/bootstrap-transition.js"></script>
    <script src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>js/bootstrap-alert.js"></script>
    <script src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>js/bootstrap-modal.js"></script>
    <script src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>js/bootstrap-dropdown.js"></script>
    <script src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>js/bootstrap-scrollspy.js"></script>
    <script src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>js/bootstrap-tab.js"></script>
    <script src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>js/bootstrap-tooltip.js"></script>
    <script src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>js/bootstrap-popover.js"></script>
    <script src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>js/bootstrap-button.js"></script>
    <script src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>js/bootstrap-collapse.js"></script>
    <script src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>js/bootstrap-carousel.js"></script>
    <script src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>js/bootstrap-typeahead.js"></script>
</body>
</html>
