
 <script src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>js/jquery.js"></script>
<script>

jQuery(document).ready(function() {
    
	jQuery("#ItemSenha").html();
		
	jQuery("#troca-ling").click(function() {
   
	   jQuery("#ItemSenha").html("<div class='input password'><label for='UserPassword'>Senha:</label><input type='password' id='UserPassword' value='' name='data[User][password]'></div><div class='input password'><label for='UserConfirmarSenha'>Confirmar senha:</label><input type='password' id='UserConfirmarSenha' name='data[User][confirmar_senha]'></div>");
	jQuery("#ItemSenha").show();
	}); 
	jQuery("#nao-troca-ling").click(function() {
        jQuery("#ItemSenha").hide();
		jQuery("#ItemSenha").html();
    }); 
	//LIMPANDO A SENHA PARA QUE ELA FIQUE EM BRANCO CASO O USUARIO NAO DIGITE NADA
	jQuery('#UserPassword').val("");
});
</script>

<h1>Editar Usuário</h1>
<?php

    echo $this->Form->create('User', array('action' => 'edit'));
    echo $this->Form->input('username', array('label'=>'Nome de usuário:'));
    echo $this->Form->input('email');
    
	if($this->Session->read('Auth.User.group_id') == 1){
		echo $this->Form->input('group_id',array('label'=>'Grupo de Acesso:'));
		
		//OBSERVE QUE A VARIAVEL $listaRestaurantes vem 
		echo $this->Form->input('current_restaurant_id',array('type'=>'select','label'=>'Administrar restaurante:', 'options'=>$listaRestaurantes));
    } else {
		echo $this->Form->input('group_id',array('label'=>'Grupo de Acesso:', 'type'=>'hidden'));
		
		//OBSERVE QUE A VARIAVEL $listaRestaurantes vem 
		echo $this->Form->input('current_restaurant_id',array('type'=>'hidden','label'=>'Administrar restaurante:', 'options'=>$listaRestaurantes));
	}
	echo $this->Form->input('password',array('label'=>'Senha:','required' => false));
    echo $this->Form->input('confirmar_senha',array('type'=>'password','label'=>'Confirmar senha:', 'required' => false));

	
	echo $this->Form->input('status', array('label'=>'Ativar:') );
            
    
    echo $this->Form->input('id');
    echo $this->Form->end('Salvar');
    
    //echo $this->Html->link('Voltar',$referer);
?>
