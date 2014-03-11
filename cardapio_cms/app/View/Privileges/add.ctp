<div class="privileges form">
<?php echo $this->Form->create('Privilege'); ?>
	<fieldset>
		<h4><?php echo __('Adicionar Restrição de Privilégio de Usuário'); ?></h4>
		<hr />
	<?php
	$controle = array(
		"cards"=>'Cardápios',
		"contents"=>'Conteúdos dos Pratos',
		"groups"=>'Grupos de Usuários',
		"items"=>'Items de Menu / Sub-menu',
		"logs"=>'Log do Sistema',
		"privileges"=>'Privilégios e ACL',
		"restaurants"=>'Restaurantes',
		"users"=>'Usuários'
		);
		
		echo $this->Form->input('group_id',array('label'=>'Grupos de Usuários:', 'options'=> $goupsItems));
		echo $this->Form->input('controller', array('label'=>'Controlador de Acesso:', 'options'=> $controle));
		
		echo $this->Form->input('action', array(
			'label'=>'Ações a serem proibidas:',
			'type' => 'select',
			'options' => array(
					'index'=>		'-- Index',
					'view'=>		'-- Visualizar',
					'add'=>			'-- Adicionar',
					'edit'=>		'-- Editar',
					'delete'=>		'-- Apagar',
					'listar'=>		'-- Listagem',
					'desactivate'=>	'-- Desativar',
					'activate'=>	'-- Ativar'
			)
		));
	?>
		
			
<?php echo $this->Form->end(__('Gravar')); ?>
</div>
<div class="actions">
	<h4><?php echo __('Menu'); ?></h4>
	<hr />
	<ul>

		<li><?php echo $this->Html->link(__('Listar Privilégios'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Listar Grupos'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Novos Grupos'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
		<li> <li><button class="btn btn-danger" onClick="javascript:history.back(-1);" type="button">Voltar</button></li> </li>
	</ul>
</div>
