<div class="blocoQuemsomos index">
	<h4><?php echo __('Bloco Quem Somos (Sobre o Restaurante)'); ?></h4>
	<table cellpadding="0" cellspacing="0">
	<tr>
			
			<th><?php echo $this->Paginator->sort('restaurants_id', 'Restaurante'); ?></th>
			<th><?php echo $this->Paginator->sort('titulo', 'Título'); ?></th>
			<th><?php echo $this->Paginator->sort('texto', 'Texto'); ?></th>
			<th><?php echo $this->Paginator->sort('lingua', 'Idioma'); ?></th>
			<th class="actions"><?php echo __('Ações'); ?></th>
	</tr>
	<?php foreach ($blocoQuemsomos as $blocoQuemsomo): ?>
	<tr>
		
		<td>
			<?php echo $this->Html->link($blocoQuemsomo['Restaurants']['name'], array('controller' => 'restaurants', 'action' => 'view', $blocoQuemsomo['Restaurants']['id'])); ?>
		</td>
		<td><?php echo h($blocoQuemsomo['BlocoQuemsomo']['titulo']); ?>&nbsp;</td>
		<td><?php echo $blocoQuemsomo['BlocoQuemsomo']['texto']; ?>&nbsp;</td>
		<td><?php echo (h($blocoQuemsomo['BlocoQuemsomo']['lingua']) == '#en_')?'<img width="30" title="Inglês" alt="English" src="'.Router::url('/').'img/icone_gb_inglish.png">':'<img src="'.Router::url('/').'img/icone_br_portugues.png" width="30" title="Português" alt="Português" />'; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Visualizar'), array('action' => 'view', $blocoQuemsomo['BlocoQuemsomo']['id'])); ?>
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $blocoQuemsomo['BlocoQuemsomo']['id'])); ?>
			<?php echo $this->Form->postLink(__('Apagar'), array('action' => 'delete', $blocoQuemsomo['BlocoQuemsomo']['id']), null, __('Tem certeza de que deseja excluir # %s?', $blocoQuemsomo['BlocoQuemsomo']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Página {:page} de {:pages}, mostrando {:current} atuais registros fora de {:count} contagem total, começando no registro  {:start}, terminando em {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h4><?php echo __('Ações'); ?></h4>
	<ul>
		<li><?php echo $this->Html->link(__('Novo Bloco Sobre Nós'), array('action' => 'add')); ?></li>
		<li>
			<a href="javascript:history.back(-1);" style="width:22%;  background-color: #DA4F49;text-decoration:none !important;" class="btn btn-danger">
				Voltar
			</a>
		</li>
	</ul>
</div>
