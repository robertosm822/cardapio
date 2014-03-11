<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//echo $this->params['pass'][0];
?>
<h4>Adicionar novo conteúdo ao Item <b><?php echo $listarContents;?></b>:</h4>
 
<?php
    echo $this->Form->create('Content', array('type' => 'file'));
    echo $this->Form->input('nome');
    
	echo $this->Form->input('active', array('label'=>'Ativar / Desativar'));
    
    
    //echo $this->Form->input('item_type_id',array('type'=>'select','options'=>$itemtypes));
    echo $this->Form->input('description',array('label'=>'Descrição:'));
    echo $this->Form->input('valor',array('label'=>'Valor R$:'));
	echo $this->Form->input('valor_duplo',array('label'=>'Valor Duplo R$:'));
    echo $this->Form->input('codigo_prato',array('label'=>'Código do prato:'));
    echo $this->Form->input('observacao',array('label'=>'Observação:'));
    
    echo $this->Form->input('Content.photo', array('type' => 'file', 'label'=> 'Foto prato:'));
    echo $this->Form->input('Content.photo_dir', array('type' => 'hidden'));
    
    echo $this->Form->input('items_id',array('type'=>'hidden','value'=>$this->params['pass'][0]));
    echo $this->Form->input('creator_id',array('type'=>'hidden', 'value'=>$this->Session->read('Auth.User.id')));
    //echo $this->Form->end('Confirmar');
    //echo $this->Html->link('Voltar','#',array);
?>
	<div class="submit">
		<input type="submit" value="Confirmar">
		<button class="btn btn-danger" style="height: 38px; margin-left: 80px; " onclick="history.back(-1)" type="button">Voltar</button>
		
	</div>
</form>
