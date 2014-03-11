<div class="blocoQuemsomos form">
<?php echo $this->Form->create('BlocoQuemsomo'); ?>
	<fieldset>
		<legend><?php echo __('Adicionar Bloco Quem Somos'); ?></legend>
	<?php
		echo $this->Form->input('restaurants_id', array('type'=>'hidden','value'=>$restaurants));
		echo $this->Form->input('titulo', array('label'=>'Titulo do Menu:'));
		echo $this->Form->input('texto', array('label'=>'Texto de apresentação:'));
		echo $this->Form->input('lingua', array('label'=>'Idioma:', 'options'=>array('#pt_'=>'Português', '#en_'=>'Inglês')));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Salvar')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Ações'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Listar Bloco Quem Somos'), array('action' => 'index')); ?></li>
		<li><a href="javascript:history.back(-1);" style="width:22%;  background-color: #DA4F49;text-decoration:none !important;" class="btn btn-danger">
				Voltar
			</a> </li>	
	</ul>
	
</div>
