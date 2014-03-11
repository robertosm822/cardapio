<div class="blocoQuemsomos form">
<?php echo $this->Form->create('BlocoQuemsomo'); ?>
	<fieldset>
		<legend><?php echo __('Editar Bloco Quem Somos'); ?></legend>
	<?php
		
		echo $this->Form->input('restaurants_id', array('type'=>'hidden'));
		echo $this->Form->input('titulo', array('label'=>'Título'));
		echo $this->Form->input('texto', array('label'=>'Texto'));
		echo $this->Form->input('lingua', array('type'=>'hidden'));
		echo $this->Form->input('id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Gravar')); ?>
</div>
<div class="actions">
	<h4><?php echo __('Ações'); ?></h4>
	<ul>

		<li><?php echo $this->Form->postLink(__('Apagar'), array('action' => 'delete', $this->Form->value('BlocoQuemsomo.id')), null, __('Tem certeza de que deseja excluir # %s?', $this->Form->value('BlocoQuemsomo.id'))); ?></li>
		<li><?php echo $this->Html->link(__('Listar Bloco Quem Somos'), array('action' => 'index')); ?></li>
	
		<li><a href="javascript:history.back(-1);" style="width:22%;  background-color: #DA4F49;text-decoration:none !important;" class="btn btn-danger">
				Voltar
			</a> </li>
	</ul>
</div>
