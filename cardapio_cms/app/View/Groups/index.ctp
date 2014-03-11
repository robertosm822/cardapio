<?php
$valorPermission = $this->Session->read('Auth.User'); //CONSTROI UM ARRAY COM AS INFORMACOES RELACIONADAS AO USER
$idPermi = $valorPermission['group_id']; 
if( $idPermi == 4){
	echo "Área Restrita...";
}
	else{
?>

<div class="groups index">
	<h4><?php echo __('Lista de Grupos de usuários.'); ?></h4>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			
			<?php 
			if($idPermi == 2 || $idPermi == 3 || $idPermi == 4){
				echo "";
			}
				else{
			?>
			<th class="actions"><?php echo __('Actions'); ?></th>
			<?php }?>
	</tr>
	<?php foreach ($groups as $group): ?>
	<tr>
		<td><?php echo h($group['Group']['id']); ?>&nbsp;</td>
		<td><?php echo h($group['Group']['name']); ?>&nbsp;</td>
		<td><?php echo h($group['Group']['created']); ?>&nbsp;</td>
		<td><?php echo h($group['Group']['modified']); ?>&nbsp;</td>
		
		<?php 
		if($idPermi == 2 || $idPermi == 3 || $idPermi == 4){
			echo "";
		}
			else{
		?>
		<td class="actions">
			<?php echo $this->Html->link(__('Visualizar'), array('action' => 'view', $group['Group']['id'])); ?>
			
				
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $group['Group']['id'])); ?>
			<?php echo $this->Form->postLink(__('Excluir'), array('action' => 'delete', $group['Group']['id']), null, __('Are you sure you want to delete # %s?', $group['Group']['id'])); ?>
			
		</td>
		<?php }?>
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
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	
	<hr />
	<ul>
		<?php 
		if($idPermi == 2 || $idPermi == 3 || $idPermi == 4){
			echo "";
		}
			else{
		?>
		<li><?php echo $this->Html->link(__('Novo Grupo'), array('action' => 'add')); ?></li>
		<?php }?>
		<li> <button class="btn btn-danger" onClick="javascript:history.back(-1);" type="button">Voltar</button> </li>
	</ul>
</div>
<?php }?>
 
