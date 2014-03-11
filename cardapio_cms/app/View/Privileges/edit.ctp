<div class="privileges form">
<?php echo $this->Form->create('Privilege'); ?>
	<fieldset>
	
		<h4><?php echo __('Editar Privilégio'); ?></h4>
	<hr />	
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('group_id',array('label'=>'Grupos de Usuários'));
		echo $this->Form->input('controller',array('label'=>'Controlador'));
		echo $this->Form->input('action',array('label'=>'Ação'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Salvar')); ?>
</div>

<div class="actions">
	<h4><?php echo __('Menu'); ?></h4>
	<hr />	
	<ul>

		<li><?php echo $this->Form->postLink(__('Apagar'), array('action' => 'delete', $this->Form->value('Privilege.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Privilege.id'))); ?></li>
		<li><?php echo $this->Html->link(__('Listar Privilégios'), array('action' => 'index')); ?></li>
		<li><button class="btn btn-danger" onClick="javascript:history.back(-1);" type="button">Voltar</button></li>
</div>
