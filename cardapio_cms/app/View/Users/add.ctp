 <?php echo $this->Form->create('User', array('type' => 'file'));?>
        <fieldset>
        <?php
            echo $this->Form->input('username', array('label'=>'Nome do usuário:'));
            echo $this->Form->input('email', array('label'=>'E-mail:'));
            //echo $this->Form->input('status',array('label'=>'Ativar / Inativo:','options' => array(1=>'Sim',0=>'Não')));
			echo $this->Form->input('status', array('label'=>'Ativo / Inativo:') );
			
			echo $this->Form->input('group_id', array('label'=>'Grupo de Acesso:'));
            
            echo $this->Form->input('current_restaurant_id', array('label'=>'Restaurante Associado:', 'options'=> $restauranteRelacionado));
            
            //echo $this->Form->input('User.photo', array('type' => 'file', 'label'=> 'Foto perfil:'));
            //echo $this->Form->input('User.photo_dir', array('type' => 'hidden'));
            
            echo $this->Form->input('password', array('value' => '','label'=>'Senha:'));
            
            echo $this->Form->input('confirmar_senha', array('value'=>'','type'=>'password'));
        ?>
        </fieldset>
    <?php echo $this->Form->end('Gravar');?>