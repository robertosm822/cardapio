<style>
	dd{
		padding: 5px;
		margin-left: 120px;
	}
</style>
<div class="privileges view">
<h4><?php  echo __('Grupo de usuário'); ?></h4>
<hr />
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo h($group['Group']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('GRUPO'); ?></dt>
		<dd>
			<?php echo h($group['Group']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('CRIAÇÃO'); ?></dt>
		<dd>
			<?php echo h($group['Group']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('MODIFICAÇÃO'); ?></dt>
		<dd>
			<?php echo h($group['Group']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h4><?php echo __('Menu'); ?></h4>
	<hr />
	<ul>
		<li><?php echo $this->Form->postLink(__('Apagar grupo'), array('action' => 'delete', $group['Group']['id']), null, __('Tem certeza que deseja apagar este privilégio # %s?', $group['Group']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Listar grupos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Novo grupo'), array('action' => 'add')); ?> </li>
		<li><button class="btn btn-danger" onClick="javascript:history.back(-1);" type="button">Voltar</button></li>

	</ul>
	
	
</div>
