<style>
	dd{
		padding: 5px;
		margin-left: 120px;
	}
</style>
<div class="privileges view">
<h4><?php  echo __('Privilégio'); ?></h4>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo h($privilege['Privilege']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('GRUPO'); ?></dt>
		<dd>
			<?php echo $this->Html->link($privilege['Group']['name'], array('controller' => 'groups', 'action' => 'view', $privilege['Group']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('CONTROLADOR'); ?></dt>
		<dd>
			<?php echo h($privilege['Privilege']['controller']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ação'); ?></dt>
		<dd>
			<?php echo h($privilege['Privilege']['action']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h4><?php echo __('Menu'); ?></h4>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Privilege'), array('action' => 'edit', $privilege['Privilege']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Privilege'), array('action' => 'delete', $privilege['Privilege']['id']), null, __('Are you sure you want to delete # %s?', $privilege['Privilege']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Privileges'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Privilege'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
