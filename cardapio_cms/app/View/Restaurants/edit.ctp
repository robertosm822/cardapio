<style>
.redes_sociais{
	border: 1px solid silver;
	padding: 20px;
}
</style>
<h1>Editar Restaurante</h1>
<div class="privileges index">
		<?php
		
		echo $this->Form->create('Restaurant', array('type'=>'file','enctype' => 'multipart/form-data'));
		echo $this->Form->input('name', array('label'=>'Nome: '));
		echo $this->Form->input('active', array('label'=>'Ativar: '));
		echo $this->Form->input('telefone', array('label'=>'Telefone: '));
		echo $this->Form->input('endereco', array('label'=>'Endereço: '));
		echo $this->Form->input('estado', array('label'=>'Estado: '));
		echo $this->Form->input('nacionalidade', array('label'=>'País: '));
		//echo $this->Form->input('cardlimit', array('label'=>'Limite de cardápios: ', 'style'=>'height:30px;'));

		//echo $this->Form->input('Restaurant.photo', array('type' => 'file', 'label'=> 'Logo Restaurante:'));
		
		echo $this->Form->input('Restaurant.foto', array(  'type' => 'file', 'label'=> 'Logo Restaurante:' ));
		
		echo "<div class='redes_sociais'>";
		echo $this->Form->input('Restaurant.icone_rede1', array(  'type' => 'text', 'label'=> 'Icone Rede Social 1:' ));
		echo $this->Form->input('Restaurant.link_rede1', array(  'type' => 'text', 'label'=> 'Link Rede Social 1:' ));
		echo $this->Form->input('Restaurant.desc_rede1', array(  'type' => 'text', 'label'=> 'Descrição Rede Social 1:' ));
		echo "</div>";
		
		echo "<div class='redes_sociais'>";
		echo $this->Form->input('Restaurant.icone_rede2', array(  'type' => 'text', 'label'=> 'Icone Rede Social 2:' ));
		echo $this->Form->input('Restaurant.link_rede2', array(  'type' => 'text', 'label'=> 'Link Rede Social 2:' ));
		echo $this->Form->input('Restaurant.desc_rede', array(  'type' => 'text', 'label'=> 'Descrição Rede Social 2:' ));
		echo "</div>";
		
		echo "<div class='redes_sociais'>";
		echo $this->Form->input('Restaurant.icone_rede3', array(  'type' => 'text', 'label'=> 'Icone Rede Social 3:' ));
		echo $this->Form->input('Restaurant.link_rede3', array(  'type' => 'text', 'label'=> 'Link Rede Social 3:' ));
		echo $this->Form->input('Restaurant.desc_rede3', array(  'type' => 'text', 'label'=> 'Descrição Rede Social 3:' ));
		echo "</div>";
		//echo $this->Form->input('Restaurant.photo_dir', array('type' => 'hidden')); 
		echo $this->Form->input('id', array('type' => 'hidden'));
		echo $this->Form->end('Salvar');

		//echo $this->Html->link('Voltar',$referer);
		?>
</div>
<div class="actions">
	<?php  if(isset($this->data['Restaurant']['foto'])){ ?>
		<img src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/')."app/webroot".$this->data['Restaurant']['foto'];?>" width="350" class="img-polaroid" >
	<?php } else { ?>
		<img src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>img/no_image.jpg" width="200" height="200" class="img-polaroid" >
	<?php }?>
	<br /><hr />
	<ul>
		<li><?php echo $this->Html->link(__('Listar Quem Somos'), array('controller' => 'blocoquemsomos', 'action' => 'index')); ?> </li>
	</ul>
</div>

