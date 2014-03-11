 <style type="text/css">
      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>

    <?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'login'), 'class'=>'form-signin'));?>
        <h2><?php echo __('Login'); ?></h2>
		<fieldset>
        <?php
            echo $this->Form->input('username', array('label'=>'Nome de Usuário:'));
            echo $this->Form->input('password', array('label'=>'Senha::'));
        ?>
        </fieldset>
    <?php echo $this->Form->end('Entrar');?>
	
