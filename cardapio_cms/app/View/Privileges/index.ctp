<?php
$valorPermission = $this->Session->read('Auth.User'); //CONSTROI UM ARRAY COM AS INFORMACOES RELACIONADAS AO USER
$idPermi = $valorPermission['group_id']; 
if($idPermi == 3 || $idPermi == 2 || $idPermi > 2){
	echo "Área Restrita...";
}
	else{
?>
<div class="privileges index">
	<h4><?php echo __('Privilégios'); ?></h4>
	<hr />
	
	    <div class="alert">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Atenção!</strong> Para restringir o usuário basta cadastrar a url.
			      <br /> <span class="badge badge-success">!</span> Exemplo: Para que um usuário acesse a edição dos cardápios  terá de cadastrar em CONTROLE "cards" e na ação EXECUTAR "edit".
		</div>
		<div class="input-append">
			<form method="get">
				<div class="btn-group">
					<button data-toggle="dropdown" class="btn dropdown-toggle">Filtrar por Grupo, Controle e Ação:</span></button>
					
				  </div>
				<input class="span2" name="filtrar" id="appendedInputButton" type="text">
				<!-- <button  type="button">Go!</button> -->
                                <input class="btn" type="submit" value="Filtrar" />
			</form>
		</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th> ID			</th>
			<th> GRUPO		</th>
			<th> CONTROLE	</th>
			<th> EXECUTAR	</th>
			<th class="actions">AÇÕES</th>
	</tr>
	<?php foreach ($privileges as $privilege): ?>
	<tr>
		<td><?php echo h($privilege['Privilege']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($privilege['Group']['name'], array('controller' => 'groups', 'action' => 'view', $privilege['Group']['id'])); ?>
		</td>
		<td><?php echo h($privilege['Privilege']['controller']); ?>&nbsp;</td>
		<td><?php echo h($privilege['Privilege']['action']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Visualizar'), array('action' => 'view', $privilege['Privilege']['id'])); ?>
		<!--	
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $privilege['Privilege']['id'])); ?>
			<?php echo $this->Form->postLink(__('Apagar'), array('action' => 'delete', $privilege['Privilege']['id']), null, __('Are you sure you want to delete # %s?', $privilege['Privilege']['id'])); ?>
		-->
			<?php
			//CONTROLANDO AS PERMISSOES DA VIEW DOS BOTOES
			if($idPermi == 1 || $idPermi == 2){
				echo $this->Html->link(__('Editar'), array('action' => 'edit', $privilege['Privilege']['id']));
			}
			?>
			<?php 
			//CONTROLANDO AS PERMISSOES DA VIEW DOS BOTOES ADMIN
			if($idPermi == 1){	
				echo $this->Form->postLink(__('Apagar'), array('action' => 'delete', $privilege['Privilege']['id']), null, __('Deseja realmente apagar o cliente # %s?', $privilege['Privilege']['id']));
			}
			?>
		
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('Anterior'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('Próximo') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h4><?php echo __('Menu'); ?></h4>
	<hr />
	<ul>
		<li><?php echo $this->Html->link(__('Novo Privilégio'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Listar Grupos'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Novo Grupo'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
<?php }?>