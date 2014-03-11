
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//EXTENDENDO AS PERMISSOES NAO CONTROLADAS PELA CLASSE - 05/02/2014
 $valorPermission = $this->Session->read('Auth.User'); //CONSTROI UM ARRAY COM AS INFORMACOES RELACIONADAS AO USER
$idPermi = $valorPermission['group_id'];

 //TRATANDO O RETORNO DE DADOS DA IMAGEM, SE FOR ARRAY OU STRING
$imagem = '';
       (is_array($this->data['Content']['photo']) ) ? $imagem = $this->data['Content']['photo']['name'] : $imagem=$this->data['Content']['photo'];
?>
<div class="privileges index">
<h1>Editar Conteúdo de Item:</h1>

<?php
    echo $this->Form->create('Content', array('type' => 'file'));
   
	//CONTROLANDO AS PERMISSOES DA VIEW DOS BOTOES ADMIN
if($idPermi == 1){
	echo $this->Form->input('nome', array('label'=>'Titulo:'));
    echo $this->Form->input('active', array('type'=>'checkbox','label'=>'Ativar / Desativar:'));
} else{
	echo $this->Form->input('nome', array('label'=>'Titulo:', 'disabled'=>'disabled'));
    echo $this->Form->input('active', array('type'=>'checkbox','label'=>'Ativar / Desativar:', 'disabled'=>'disabled'));
}   
if($idPermi == 1 || $idPermi == 2){
	echo $this->Form->input('valor', array('label'=>'Valor:'));
	echo $this->Form->input('valor_duplo',array('label'=>'Valor Duplo R$:'));
	//echo $this->Form->input('codigo_prato',array('label'=>'Código do prato:'));
} else {
	echo $this->Form->input('valor', array('label'=>'Valor:', 'disabled'=>'disabled'));
	echo $this->Form->input('valor_duplo',array('label'=>'Valor Duplo R$:', 'disabled'=>'disabled'));
}
    //echo $this->Form->input('restaurants_id', array('label'=>'Restaurante Associado:', 'options'=> $restauranteRelacionado));
    echo $this->Form->input('description', array('label'=>'Descrição:'));
//CONTROLANDO AS PERMISSOES DA VIEW DOS BOTOES ADMIN
if($idPermi == 1){
    echo $this->Form->input('observacao', array('label'=>'Observação:'));    
    echo $this->Form->input('link_video_web', array('label'=>'Link Vídeo Web:'));
    
    echo $this->Form->input('Content.photo', array('type' => 'file', 'label'=> 'Foto prato:'));
    echo $this->Form->input('Content.photo_dir', array('type' => 'hidden'));
} else {
	echo $this->Form->input('observacao', array('label'=>'Observação:', 'disabled'=>'disabled'));    
    echo $this->Form->input('link_video_local', array('label'=>'Link Vídeo Local:', 'disabled'=>'disabled'));
    echo $this->Form->input('link_video_web', array('label'=>'Link Vídeo Web:', 'disabled'=>'disabled'));
 
    echo $this->Form->input('Content.photo', array('type' => 'file', 'label'=> 'Foto prato:', 'disabled'=>'disabled'));
    echo $this->Form->input('Content.photo_dir', array('type' => 'hidden'));
}
    
    echo $this->Form->input('id', array('type' => 'hidden'));
    //echo $this->Form->end('Confirmar');
    //print_r($this->data['Content']['photo']['name']);
?>
	<div class="submit">
		<input type="submit" value="Confirmar">
		<button class="btn btn-danger" style="height: 38px; margin-left: 80px; " onclick="history.back(-1)" type="button">Voltar</button>
		
	</div>
</form>
</div>
<div class="actions">

    <?php if(isset($imagem)){ ?>
		<img src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/')."app/webroot/files/content/photo/".$this->data['Content']['photo_dir']."/".$imagem;?>" width="200" height="200" class="img-polaroid" >
	<?php } else { ?>
		<img src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>img/no_image.jpg" width="200" height="200" class="img-polaroid" >
	<?php }?>
</div>
