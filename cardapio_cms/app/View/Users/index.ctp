<?php
$valorPermission = $this->Session->read('Auth.User'); //CONSTROI UM ARRAY COM AS INFORMACOES RELACIONADAS AO USER
$idPermi = $valorPermission['group_id']; 
//debug($users);
if($idPermi == 5){
	echo "Área Restrita...";
}
	else{
?>
<div class="breadcrumb">
    <h1 id="id_breadcrumbs"><img style="padding:5px; width: 16px; height:16px;" src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>img/ativo.png">Usuários Ativos</h1>
    <div id="breadcrumbs_menu">
    <?php
    //echo $this->Html->image('loader.gif', array('class' => 'hide', 'id' => 'loader'));
        $this->Html->addCrumb('Home', '/');
        $this->Html->addCrumb('Usuários', '/users', array('class'=>'active'));
        echo $this->Html->getCrumbs(' / ');
    ?>
    </div>
</div>

<div id="loader"></div>

	<div class="input-append">
		<form method="get">
			<div class="btn-group">
				<button data-toggle="dropdown" style="height: 35px;" class="btn dropdown-toggle">Filtrar por Nome de usuário:</span></button>	
			</div>
			<input  style="height: 30px;" name="filtrar" id="appendedInputButton" type="text">
			<input class="btn" style="height: 35px;" type="submit" value="Filtrar" />
		</form>
	</div>

<table cellspacing='0' cellpadding='0'>
	<?php
		$tableHeaders = $this->Html->tableHeaders( array(
				$this->Paginator->sort('username', 'Nome de Usuário'),
				$this->Paginator->sort('email', 'Email'),
                                $this->Paginator->sort('Group.GRUPO','Grupo'),
								$this->Paginator->sort('Log.created', 'Ultimo - Acesso'),
                                $this->Paginator->sort('status', 'Status'),
                                $this->Paginator->sort('Ação', 'Editar'),
                                //$this->Paginator->sort('Ação', 'Inativar')
                    
			)
		);
		echo $tableHeaders;
		$rows = array();
           
		foreach($users as $user){
			//print_r($user['User']['group_id']);
			if($this->Session->read('Auth.User.group_id') == 1){
								$rows[] = array(
				$user['User']['username'],
					$user['User']['email'],
					$user['Group']['GRUPO'],
									date("d/m/Y H:i:s",strtotime($user[0]['ultimmo'])),
									($user['User'] ['status'] == 1)? 'Ativo': 'Inativo',
					//RESTRINGINDO OS USUARIOS A PARTIR DO NIVEL DOIS PARA NAO EDITAR OS MASTERS MEDIGITAL E OS MASTER PRINCIPAL 
								($user['User']['group_id'] == 1)?  '<a href="/cardapio_desenv/cardapio_cms/users/edit/'.$user['User']['id'].'"><i class=\"icon-edit\"></i><a/>' :'',
					$this->Html->link('Editar', array('action' => 'edit', $user['User']['id'])),
					
					/*  GERENCIAR RESTAURANTE -> $this->Html->link('Gerenciar Restaurantes', array('action' => 'managerestaurants', $user['User']['id'])) */
								
								//($user['User']['status']==1)?
								//$this->Form->postLink('Inativar',array('action' => 'inactivate', $user['User']['id']),array('confirm' => 'Tem certeza que deseja inativar este usuário?'))
								
								//$this->Html->link("Inativar",array('controller' => 'users', 'action' => 'inactivate', $user['User']['id']),array('confirm' => 'Tem certeza que deseja inativar este usuário?'))
								//:
								//$this->Form->postLink('Ativar',array('action' => 'activate', $user['User']['id']),array('confirm' => 'Tem certeza que deseja ativar este restaurante?'))
						 
				);

			} else {
				$rows[] = array(
				$user['User']['username'],
					$user['User']['email'],
					$user['Group']['GRUPO'],
									date("d/m/Y H:i:s",strtotime($user[0]['ultimmo'])),
									($user['User'] ['status'] == 1)? 'Ativo': 'Inativo',
					//RESTRINGINDO OS USUARIOS A PARTIR DO NIVEL DOIS PARA NAO EDITAR OS MASTERS MEDIGITAL E OS MASTER PRINCIPAL 
								($user['User']['group_id'] == 1)?  '<a href="/cardapio_desenv/cardapio_cms/users/edit/'.$user['User']['id'].'"><i class=\"icon-edit\"></i><a/>' :'',
					( $valorPermission['group_id'] == $user['User']['group_id'] || $user['User']['group_id'] > 2 )? $this->Html->link('Editar', array('action' => 'edit', $user['User']['id'])) : '',
					
					/*  GERENCIAR RESTAURANTE -> $this->Html->link('Gerenciar Restaurantes', array('action' => 'managerestaurants', $user['User']['id'])) */
								
								//($user['User']['status']==1)?
								//$this->Form->postLink('Inativar',array('action' => 'inactivate', $user['User']['id']),array('confirm' => 'Tem certeza que deseja inativar este usuário?'))
								
								//$this->Html->link("Inativar",array('controller' => 'users', 'action' => 'inactivate', $user['User']['id']),array('confirm' => 'Tem certeza que deseja inativar este usuário?'))
								//:
								//$this->Form->postLink('Ativar',array('action' => 'activate', $user['User']['id']),array('confirm' => 'Tem certeza que deseja ativar este restaurante?'))
						 
				);
			}
		}
		echo $this->Html->tableCells($rows);
		//echo $tableHeaders;
	?>
</table><?php
                     
                ?>
<div class='paging'>
	<?php
            
		//SUFICIENTE PARA MOSTRAR A PAGINAÇÃO PADRAO
		echo $this->Paginator->prev('Anterior', null, null, array('class' => 'disable'));
		echo $this->Paginator->numbers();
		echo $this->Paginator->next('Próximo', null, null, array('class' => 'disable'));
	
        ?>
            
</div>
<br />
<a style="text-decoration:none !important;" href="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/users/add');?>">
<button class="btn btn-primary" type="button">Adicionar Usuário</button></a>
 
<button class="btn btn-danger" onclick="javascript:history.back(-1);" type="button">Voltar</button>
<?php echo $this->Js->writeBuffer();?>

<?php }?>