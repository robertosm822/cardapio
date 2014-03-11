<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 //echo $this->fetch('beautiful-data.min');

	//CONDICAO PARA MOSTRAR AS BANDEIRAS DAS LINGUAS
if(isset($this->request->params['pass'][1])){
	$lingua = "#".$this->request->params['pass'][1];
} else {
		print_r($this->request->params['pass'][1]);
	$lingua = "#".$this->request->params['pass'][1];
}					

	switch($lingua."_"){ //LINGUA PADRONIZADA COMO #en_ ou #pt_
						case '#en_':
							$language= $this->html->Image('icone_gb_inglish.png', array('width'=>'30', 'alt'=>'English', 'title'=>'English'));
						break;
						case '#pt_':
							$language= $this->html->Image('icone_br_portugues.png', array('width'=>'30', 'alt'=>'Português', 'title'=>'Português'));
						break;
						case '':
							$language= '';
						break;
					}
					
	?>
   <script src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>js/jquery.js"></script>

	<!-- Tablesorter: required -->

	<script src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>js/jquery.tablesorter.js"></script>
	<script src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>js/jquery.tablesorter.widgets.js"></script>
<script id="js">
var $j = jQuery.noConflict();
$j(function() {

	
	//OCULTANDO OS CAMPOS DE FILTROS JAVASCRIPT PARA QUE PERMANEÇA APENAS O ORDENADOR
	$j('input.tablesorter-filter').hide();
	
	$j('td a.blue').html('<i class="icon-trash"></i>');
	$j('td a.blue').attr('title','Apagar');

});</script>
<style>
	td span {
		float: left;
		width: 20px;
		text-align: center;
		background-repeat: no-repeat;
		height: 13px;
	}
	.jgrid span.uparrow {
		background-image: url(<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>img/uparrow.png);
	}
	.jgrid span.downarrow {
		background-image: url(<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>img/downarrow.png);
	}
</style>	
<legend> Cardápio: <b> <?php echo $card['Card']['name'];  ?> </b></legend>


    <p>
        
        <small><b>Criado em:</b> <?php echo date("d/m/Y",strtotime($card['Card']['created']));?></small> |
        <small><b>Ultima Modificação:</b> <?php   echo date("d/m/Y H:i:s",strtotime($listarContents));?></small>  |
        <small><b>Status: </b></small><?php if($card['Card']['active'] == 0){ echo "Inativo";} else { echo "Ativo";} ?>
        
    </p>
    <legend><?php  echo $language;?>  Itens    <span style="font-size: 13px; margin-left:80%;"><a href="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>../cardapio-front/?rest=<?php echo $card['Card']['restaurants_id'];?>&card=<?php echo $card['Card']['id'];?>" title="Visualizar Cardápio" target="_blank"> <i class="icon-search"></i> Visualizar Cardápio</span></a></legend> 
	
<?php 
	
	//FILTRO PADRAO QUE FOI SUBTITUIDO PARA MELHORAR O LAYOUT
	/*
	$options = array('1'=>'Ativo', '0'=>'Inativo');
		echo $this->Form->create('Card', array('action'=>'view/'.$card['Card']['id']));
		echo $this->Form->input('busca', array('label'=>'Pesquisar:'));
		echo $this->Form->input('filtro', array('label'=>'Status','type'=>'select','options'=> $options));
		echo $this->Form->submit('Buscar', array('class' => 'ui-state-default
		ui-corner-all'));
		echo $this->Form->end();
	
		//dentro array descubro quem é o ultimo e quem é o primeiro
		
	*/
	echo $this->Form->create('Card', array('action'=>'view/'.$card['Card']['id']));
?>
<!-- 
<span style="padding:30px !important;margin-top:30px !important;">
	Pesquisar:
	<input name="data[Card][busca]" type="text" value="">
	
	Status:
	<select name="data[Card][filtro]">
		<option value="1" selected="selected">Ativo</option>
		<option value="0">Inativo</option>
	</select>
</span>
	<span style="padding:10px !important;">
		<input class="btn btn-warning" type="reset" value="Limpar" />
	</span>
	<span style="padding:10px !important;">	
		<input class="btn btn-primary" type="submit" value="Filtrar" />
	</span>
</form>	
-->
    <?php
	//CSS
    $this->html->css('cardapio.admin',null,array('inline'=>false));
?>


<div id="topBar">
    
    <?php 
	//excluindo o caracter especial # para que nao de erro de parametro ao adicionar
	$lingua = explode('#',$lingua);
	echo $this->html->link('+ Adicionar Item',array('controller'=>'items','action'=>'add',$card['Card']['id'],$lingua[1]),array('class'=>'blue'));?>
    
</div>

<div id="itemList">



    <table class="tablesorter">
			<colgroup>
				<col  />
				<col  />
				<col  />
				<col  />
				<col  />
			</colgroup>
        <thead>
            <tr>
                <th data-sorter="false">Item</th>
                <th style="text-align:center;">Tipo</th>
                <th style="text-align:center;">Status</th>
				
				<th style="text-align:center;">Ordem</th>
                <th style="text-align:center;" data-sorter="false" data-filter="false">Editar Título</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $image = $this->Html->image('br_line.png');
                $data = array();
				
                foreach ($items as $key => $value) {
                    if($value['Item']['level']==1)
                        recursive($value,$items,$data);
                }
                foreach ($data as $key => $value) {
                    echo'<tr>';
						
						
						
                    if($value['Item']['level']==1)
                        echo '<td class="first"><strong>'.$value['Item']['name'].'</strong></td>';
                    else
                        echo '<td class="first">'.str_repeat('    ', $value['Item']['level']-1).$this->html->Image('br_line.png').' '. ( ($value['Item']['level'] == '2') ? $this->html->link( $value['Item']['name'] ,array('controller'=> 'contents','action'=>'view/'.$value['Item']['id'],$value['Item']['content_id']."?name=".$value['Item']['name']."&id=".$value['Item']['id']))  : '' ) .'</td>';
                    
					
					
                    echo '<td style="text-align:center;">'.(($value['Item']['level']== '1')?'Menu':'Sub-Menu').'</td>
                            <td style="text-align:center;">'.( ($value['Item']['active']=='1')?'<a href="http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].Router::url('/').'items/desactivate/'.$value['Item']['id'].'"> <img src="http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].Router::url('/').'img/ativo.png" alt="Ativo" title="Ativo"/> </a>' : '<a href="http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].Router::url('/').'items/activate/'.$value['Item']['id'].'"> <img src="http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].Router::url('/').'img/desable.png" alt="Inativo" title="Inativo"/> </a>').'</td>
                            
							<td style="text-align:center;">';
								
						//if($value['Item']['level']== '1'){
							
							if($value['Item']['position'] == 1 || $value['Item']['position'] == 0){
								
								echo	'<span style="width:38px;">
											<a class="jgrid" href="'. Router::url('/') .'items/ordenar/'.$value['Item']['id'].'/baixo/' .$value['Item']['position']. '" title="Mover para baixo">
												<span class="state downarrow">
													
												</span>
											</a>
										</span>
										
										<input style="width: 35px;" type="text" name="order[]" size="5" value="'.$value['Item']['position'].'" class="text-area-order" disabled>';
								
							} else {
							
								echo	'<span>
											<a class="jgrid" href="'. Router::url('/') .'items/ordenar/'.$value['Item']['id'].'/baixo/' .$value['Item']['position']. '" title="Mover para baixo">
												<span class="state downarrow">
													
												</span>
											</a>
										</span>';
								echo 	'<span>
											<a class="jgrid" href="'. Router::url('/') .'items/ordenar/'.$value['Item']['id'].'/cima/ ' .$value['Item']['position']. '" title="Mover para cima">
												<span class="state uparrow">			
											</a>
										</span>										
								<input style="width: 35px;" type="text" name="order[]" size="7" value="'.$value['Item']['position'].'" class="text-area-order" disabled>';
							}
						//}
					
					echo '</td>
                            <td style="text-align:center;">
								<a href="../../../items/edit/'.$value['Item']['id'].'" title="Editar"><i class="icon-edit"></i></a>   |
								'.$this->Form->postLink("Apagar",  array('controller'=>'items','action' => 'delete', $value['Item']['id']), array('confirm' => 'Você tem certeza que deseja excluir?', 'class'=>'blue')  ).'
							</td>
                        </tr>';
                    
                }
                
                
            ?>
            
        </tbody>
    </table>
</div>

<?php 

function recursive($item,$items,&$data){
    $data[] = $item;
    
    foreach ($items as $key => $value) {
        if(($value['Item']['level']==$item['Item']['level']+1) && ($value['Item']['parent_id']==$item['Item']['id']))
            recursive($value,$items,$data);
    }
}
?>   

