<?php
$valorPermission = $this->Session->read('Auth.User'); //CONSTROI UM ARRAY COM AS INFORMACOES RELACIONADAS AO USER
$idPermi = $valorPermission['group_id'];
if($idPermi == 2 || $idPermi == 3 || $idPermi == 4){
				echo "Área restrita...";
			} else {
?>
<div class="privileges form">
	<h4>Adicionar novo grupo de usuário:</h4>
	<hr />
	 
	<?php
	/*
	 * Data: 04/07/2013 - Melhorado:  03/02/2014
	 * Adicionar novo Grupo de usuarios
	 */
		echo $this->Form->create('Group');
		echo $this->Form->input('title', array('label'=>'Título:'));
		
		echo $this->Form->end('Confirmar');
	?>
</div>
<div class="actions">
	<hr />
	<ul>
		<li> <li><button class="btn btn-danger" onClick="javascript:history.back(-1);" type="button">Voltar</button></li> </li>
	</ul>
	
</div>
<?php }?>