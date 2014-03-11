<style TYPE="text/css" > 
<!--
	/*
	* { margin: 0; padding: 0; }
	
	.container{margin: 20px auto; width: 900px; background: #fff;}
	*/
	
	#contactform {
		width: 600px;
		padding: 20px;
		background: #f0f0f0;
		overflow:auto;
	}
	
	#contactform .field{margin-bottom:7px;}
	
	#contactform label {
	font-family: Arial, Verdana; 
	
	display: block; 
	float: left; 
	font-weight: bold; 
	
	text-align:left; 
	width: 220px; 
	line-height: 25px; 
	font-size: 15px; 
	}
	
	#contactform .input{
	font-family: Arial, Verdana; 
	font-size: 14px; 
	padding: 5px; 
	 
	width: 300px; 
	color: #797979;	
	}
	
	#contactform .input:focus{
	background-color:#E7E8E7;	
	}
	
	#contactform .textarea {
	height:150px;	
	}
	
	#contactform .hint{
	display:none;
	}
	
	#contactform .field:hover .hint {  
	position: absolute;
	display: block;  
	margin: -20px 0 0 320px;
	color: #FFFFFF;
	padding: 7px 10px;
	background: rgba(0, 0, 0, 0.6);
	
	-moz-border-radius: 7px;
	-webkit-border-radius: 7px;
	border-radius: 7px;	
	}
	
	#contactform .button{
	float: right;
	margin:10px 55px 10px 0;
	font-weight: bold;
	line-height: 1;
	padding: 6px 10px;
	cursor:pointer;   
	color: #fff;
	
	text-align: center;
	text-shadow: 0 -1px 1px #64799e;
	
	/* Background gradient */
	background: #a5b8da;
	background: -moz-linear-gradient(top, #a5b8da 0%, #7089b3 100%);
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#a5b8da), to(#7089b3));
	
	
  
	/* Box shadow */
	-moz-box-shadow: inset 0 1px 0 0 #aec3e5;
	-webkit-box-shadow: inset 0 1px 0 0 #aec3e5;
	box-shadow: inset 0 1px 0 0 #aec3e5;
	
	}
	
	#contactform .button:hover {
	background: #848FB2;
    cursor: pointer;
	}
	
	.corpo{margin: 20px auto; width: 100%; background: #fff;}
    -->
   </style>

<div class="corpo">

<h4>Adicionar novo restaurante</h4>
	<?php
		echo $this->Form->create('Restaurant', array('type' => 'file', 'id'=>'contactform', 'class'=>'rounded'));
		echo '<div class="field">';
			echo $this->Form->input('name', array('label'=>'Nome:',"for"=>"name", "class"=>"input"));
			echo '<p class="hint">Digite seu nome (Obrigatório).</p>';
		echo '</div>';
		//echo $this->Form->input('cardlimit', array('label'=>'Limite de cardápios: ', "for"=>"cardlimit"));
			
			echo '<div class="field">';	
				echo $this->Form->input('active', array('label'=>'Ativar',"for"=>"active"));
				echo '<p class="hint">Cadastrar um Restaurante Ativo ou Inativo.</p>';
			echo '</div>';
			
			echo '<div class="field">';	
				echo $this->Form->input('telefone', array('label'=>'Telefone: ',"for"=>"telefone", "class"=>"input"));
				echo '<p class="hint">Digite um telefone (Ex.: +00(00) 00000-0000).</p>';
			echo '</div>';
			
			echo '<div class="field">';
				echo $this->Form->input('endereco', array('label'=>'Endereço: ',"for"=>"endereco", "class"=>"input"));
				echo '<p class="hint">Digite o endereço de seu Restaurante, número e Bairro.</p>';
			echo '</div>';
			
			echo '<div class="field">';
				echo $this->Form->input('estado', array('label'=>'Estado: ',"for"=>"estado", "class"=>"input"));
				echo '<p class="hint">Digite o Estado.</p>';
			echo '</div>';
			
			echo '<div class="field">';
				echo $this->Form->input('nacionalidade', array('label'=>'País: ',"for"=>"nacionalidade", "class"=>"input"));
				echo '<p class="hint">Digite o País.</p>';
			echo '</div>';
			
			echo '<div class="field">';
				echo $this->Form->input('Restaurant.photo', array('type' => 'file', 'label'=> 'Logo Restaurante:'));
				echo $this->Form->input('Restaurant.photo_dir', array('type' => 'hidden'));
				echo '<p class="hint">Escolha uma imagem nos formatos JPEG ou PNG,<br />com menos de 1.5MB de tamanho e 251x90 pixels.</p>';
			echo '</div>';
			
			echo $this->Form->input('creator_id',array('type'=>'hidden', 'value'=>$this->Session->read('Auth.User.id')));
		echo $this->Form->end('Confirmar');
			
			//echo $this->Html->link('Voltar',$referer);
	?>

	<a style="text-decoration:none !important; position: absolute !important; margin-top: -95px; margin-left: 280px;" href="javascript:history.back(-1);">
		<button class="btn btn-danger" type="button">Voltar</button>
	</a>

</div>