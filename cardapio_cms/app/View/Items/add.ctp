<h2>Adicionar novo item</h2>
 
<script src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>js/jquery.js"></script>


<?php
 $array = Array();
    $array[NULL] = 'Principal';
    
    foreach ($items as $key => $value) {
        $array[$key] = $value;
    }
	
    echo $this->Form->create('Item');
    echo $this->Form->input('name', array('label' =>'Nome do Item:'));
	
	/*
	$options = array('#pt_'=>'Português', '#en_'=>'Inglês');
	echo '<br /><select id="ItemLanguage" name="data[Item][language]" style="display: inline-block;">
			<option selected="selected" value="#pt_">Português</option>
			<option value="#en_">Inglês</option>
		  </select>';
	*/
	
	//RESGATANDO O PARAMETRO PASSADO PELA URL DENTRO DO CAKEPHP
	//debug($this->request->params['pass'][1]);
	$linguas = "#".$this->request->params['pass'][1]."_";
	echo $this->Form->input('language', array('label'=>'Mudar lingua:','type'=>'hidden', 'value'=>$linguas));
	
    echo $this->Form->input('href', array('type'=>'hidden','label'=> 'URL do conteúdo:', 'onKeyUp'=>''));
    
    //echo $this->Form->input('position', array('label'=>'Posição'));
	
	echo $this->Form->input('parent_id',array('label'=>'Item Pai:','type'=>'select','options'=>$array));
    echo $this->Form->input('item_type_id',array('label'=>'Tipo de Item:','type'=>'select','options'=>$itemtypes));
	
	echo $this->Form->input('active', array('label'=>'Ativar / Desativar'));
    echo $this->Form->input('card_id',array('type'=>'hidden', 'value'=>$this->params['pass'][0]));
	echo $this->Form->input('creator_id',array('type'=>'hidden', 'value'=>$this->Session->read('Auth.User.id')));
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('Salvar');
    ?>

	
