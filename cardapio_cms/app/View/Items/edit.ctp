 <script src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>js/jquery.js"></script>
<script>

jQuery(document).ready(function() {
    jQuery("#ItemLanguage").hide();
	
	jQuery("#troca-ling").click(function() {
       jQuery("#ItemLanguage").show();
    }); 
	jQuery("#nao-troca-ling").click(function() {
        jQuery("#ItemLanguage").hide();
    }); 
	jQuery('div#content .blue').css({
						'color': 'red',
						'text-decoration':'none', 
						'padding':'5px 20px 5px 25px',
						'border':'1px solid red',
						'background-image': 'url("../../img/design/cross.png")',
						'background-repeat': 'no-repeat',
						'background-position': '5px center',
						'text-align':'right'
						});
	
});
</script>
<style>
#btn-delete{ 
	position: absolute; 
	width: 200px; 
	height: 50px;  
	margin-left: 260px;
	top:110;
}
</style>

<h1>Editar Categoria</h1>
<br> <br>
<?php
    echo $this->Form->create('Item', array('action' => 'edit'));
    echo $this->Form->input('name', array('label' =>'Nome do Item:'));
	
		
	echo $this->Form->input('language', array('label'=>'Mudar lingua:','type'=>'hidden'));
	
    echo $this->Form->input('href', array('type'=>'hidden','label'=> 'URL do conteúdo:', 'onKeyUp'=>''));
    
    //echo $this->Form->input('position', array('label'=>'Posição', 'style'=>'height:30px;width:80px;'));
	echo $this->Form->input('active', array('label'=>'Ativar / Desativar'));
    
    echo $this->Form->input('id', array('type' => 'hidden'));
    //echo $this->Form->end('Salvar');
    ?>
	<div class="submit">
		<input type="submit" value="Salvar">
				
		<button class="btn btn-danger" style="height: 38px; margin-left: 80px; " onclick="history.back(-1)" type="button">Voltar</button>
		
	</div>
</form>
	
<div id="btn-delete">	
 <?php
	//$price = $this->_requestAction('user/set_price/' . $this->data['Item']['id'] );
    echo $this->Form->postLink(
                "Delete",
                array('action' => 'delete', $this->Form->fields['Item.id']),
                array('confirm' => 'Você tem certeza que deseja excluir?', 'class'=>'blue')
            );

    ?>
	</div>