<style>
dd {padding: 10px;}
dt {padding: 10px; margin: 10px;}
</style>
<div class="blocoQuemsomos view">
<h4><?php  echo __('Bloco Quem Somos / Menu'); ?></h4>
	<dl>
		
		
		<dt><?php echo __('Restaurante:'); ?></dt>
		<dd>
			<?php echo $this->Html->link($blocoQuemsomo['Restaurants']['name'], array('controller' => 'restaurants', 'action' => 'view', $blocoQuemsomo['Restaurants']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Título:'); ?></dt>
		<dd>
			<?php echo h($blocoQuemsomo['BlocoQuemsomo']['titulo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Texto:'); ?></dt>
		<dd>
			<?php echo $blocoQuemsomo['BlocoQuemsomo']['texto']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Idioma:'); ?></dt>
		<dd>
			<?php echo (h($blocoQuemsomo['BlocoQuemsomo']['lingua']) == '#en_')? 'Inglês' : 'Português'; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h4><?php echo __('Actions'); ?></h4>
	<ul>
		<li><?php echo $this->Html->link(__('Editar Bloco Quem Somos'), array('action' => 'edit', $blocoQuemsomo['BlocoQuemsomo']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Apagar Bloco'), array('action' => 'delete', $blocoQuemsomo['BlocoQuemsomo']['id']), null, __('Tem certeza de que deseja excluir # %s?', $blocoQuemsomo['BlocoQuemsomo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Bloco'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Novo Bloco'), array('action' => 'add')); ?> </li>
		<li><a href="javascript:history.back(-1);" style="width:22%;  background-color: #DA4F49;text-decoration:none !important;" class="btn btn-danger">
				Voltar
			</a> </li>
	</ul>
</div>
