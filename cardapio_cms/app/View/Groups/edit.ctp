<?php
$valorPermission = $this->Session->read('Auth.User'); //CONSTROI UM ARRAY COM AS INFORMACOES RELACIONADAS AO USER
$idPermi = $valorPermission['group_id'];
if($idPermi == 2 || $idPermi == 3 || $idPermi == 4){
				echo "Área restrita...";
			} else {

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<h1>Editar Grupo de Usuário:</h1>
<?php
    echo $this->Form->create('Group', array('action' => 'edit'));
    echo $this->Form->input('name', array('label'=>'Título: '));
   
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('Salvar');
    
    //echo $this->Html->link('Voltar',$referer);
}
?>
