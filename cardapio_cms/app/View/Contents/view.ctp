   <?php
    //CSS
    $this->html->css('cardapio.admin',null,array('inline'=>false));
?>


       <script src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>js/jquery.js"></script>

	<!-- Tablesorter: required -->

	<script src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>js/jquery.tablesorter.js"></script>
	<script src="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>js/jquery.tablesorter.widgets.js"></script>
<script type="text/javascript" id="js">

var $j = jQuery.noConflict();
$j(function() {

//TRATANDO A EDICAO DE CODIGOS DIRETO NA TABELA -------------------------------------------
	$j("td.editar").dblclick(function () {
		
		//if($j('td > input').length > 0){
		//	return;
		//}
			var coteudoOriginal = $j(this).text();
			
			var novoElemento = $j('<input/>', {type:'text', value:coteudoOriginal});
			$j(this).html(novoElemento.bind('blur keydown',function(e){
					//armazenando o numero da tecla ENTER
					var KeyCode = e.which;
					if(KeyCode == 13 && conteudoNovo != ''){
						var conteudoNovo = $j(this).val();
						if(conteudoNovo != ''){
							//$(this).parent().html(conteudoNovo);
							$j.ajax({
								type:"POST",
								url:"<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/');?>campo_editavel/editCampo.php",
								data:{
									id:$j(this).parents('tr').children().first().text(),
									campo:$j(this).parent().attr('title'),
									valor:conteudoNovo
								},
								  success: function(result){
									$j(this).parent().html(conteudoNovo);
									$j('body').append(result);
									//location.reload();
								  }
							});
						}
					} else if(KeyCode == 27 || e.type == 'blur'){
						$j(this).parent().html(coteudoOriginal);
						location.reload();
					}
				}));
			
			$j(this).children().select();
			
		
	});
	//---------------------------------------------------------------------------------

	$j(".tablesorter")
		.tablesorter({
			theme : 'blue',
			// this is the default setting
			cssChildRow: "tablesorter-childRow",

			// initialize zebra and filter widgets
			widgets: ["zebra", "filter"],

			widgetOptions: {
				// include child row content while filtering, if true
				filter_childRows  : false,
				// class name applied to filter row and each input
				filter_cssFilter  : 'tablesorter-filter',
				// search from beginning
				filter_startsWith : false,
				// Set this option to false to make the searches case sensitive 
				filter_ignoreCase : false
			}

		});

	// hide child rows
	$j('.tablesorter-childRow td').hide();

	// Toggle child row content (td), not hiding the row since we are using rowspan
	// Using delegate because the pager plugin rebuilds the table after each page change
	// "delegate" works in jQuery 1.4.2+; use "live" back to v1.3; for older jQuery - SOL
	$j('.tablesorter').delegate('.toggle', 'click' ,function(){

		// use "nextUntil" to toggle multiple child rows
		// toggle table cells instead of the row
		$j(this).closest('tr').nextUntil('tr:not(.tablesorter-childRow)').find('td').toggle();

		return false;
	});

	// Toggle widgetFilterChildRows option
	$j('button.toggle-option').click(function(){
		var c = $('.tablesorter')[0].config.widgetOptions,
		o = !c.filter_childRows;
		c.filter_childRows = o;
		$j('.state').html(o.toString());
		// update filter; include false parameter to force a new search
		$j('input.tablesorter-filter').trigger('search', false);
		return false;
	});
	//OCULTANDO OS CAMPOS DE FILTROS JAVASCRIPT PARA QUE PERMANEÇA APENAS O ORDENADOR
	$j('input.tablesorter-filter').hide();
		
		//MELHORANDO O BOTAO DE EXCLUSAO COM JAVASCRIPT
		$j('td a.blue').html('<i class="icon-trash"></i>');
		$j('td a.blue').attr('title','Apagar');
});	
</script>
	
<style>
    #listar-content th {
        border: 1px solid #999;
        text-align: center;
    }
/* REPOSICIONADOR DOS PRATOS */
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

<!--  MENSAGEM DE EDICAO DO PRECO -->
<div id="mensagem" style="border: 1px solid red; margin-top:0px;display:none; padding: 10px; text-align:center; "></div>

    <blockquote>
    <p>Lista de items desta categoria:</p>
	<strong>Nome da categoria: <?php echo (isset($_GET['name'])) ? $_GET['name'] : '';?> </strong>
    </blockquote>



    <div id="topBar">

        <?php 
        //print_r($this->viewVars['contents'][0]['Item']['id']);
        echo $this->html->link('+ Adicionar Conteúdo',array('controller'=>'contents','action'=>'add',(isset($_GET['id'])) ? $_GET['id']:''),array('class'=>'blue'));?>

    </div>
	
<br>

<table id="listar-content" cellspacing="0" cellpadding="0" class="tablesorter">
	<colgroup>
				<col width="5" />
				<col width="70" />
				<col width="100" />
				<col width="55" />
				<col width="100" />
				<col width="10" />						
				<col width="30" />						
				<col width="70" />
			</colgroup>
	<thead>
            
			<tr>
                <th>ID</th>
                <th>Codigo do prato</th>
                <th>Título</th> 
                <th>Valor R$</th> 
                <th  style="text-align:center;width:200px;">Descrição</th> 
                 
                <th style="text-align:center;">Status</th>
                <th style="text-align:center;">Ordenar</th>
                <th data-sorter="false" data-filter="false" style="text-align:center;">Ação</th>
                
            </tr>
	</tread>
	<tbody>
<?php 
    for($x=0; $x < count($this->viewVars['contents']);$x++){
	
?>

                    
            <tr>
                <td title="id" style="color:silver;"><?php echo $this->viewVars['contents'][$x]['Content']['id'];?></td>
                <td><?php echo $this->viewVars['contents'][$x]['Content']['codigo_prato'];?></td>
                <td><?php echo $this->viewVars['contents'][$x]['Content']['nome'];?></td> 
                <td title="codigo_prato"  class="editar"><?php echo $this->viewVars['contents'][$x]['Content']['valor'];?></td> 
                <td><?php echo $this->viewVars['contents'][$x]['Content']['description'];?></td> 
                 
                <td style="text-align:center;">
					<?php 
						echo ($this->viewVars['contents'][$x]['Content']['active']==1?'<a href="http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].Router::url('/').'contents/desactivate/'.$this->viewVars['contents'][$x]['Content']['id'].'"> <img src="http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].Router::url('/').'img/ativo.png" alt="Ativo" title="Ativo"/> </a>' : '<a href="http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].Router::url('/').'contents/activate/'.$this->viewVars['contents'][$x]['Content']['id'].'"> <img src="http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].Router::url('/').'img/desable.png" alt="Inativo" title="Inativo"/> </a>');
						//echo date("d/m/Y",strtotime( $this->viewVars['contents'][$x]['Content']['created'] ));
					?>
				</td>
				<td style="text-align:center;">
				<?php
					//ORDENANDO AS POSICOES INDIVIDUAIS DOS PRATOS - 13/02/2014
					if($this->viewVars['contents'][$x]['Content']['position'] == 1 || $this->viewVars['contents'][$x]['Content']['position'] == 0){
						echo	'<span style="width:38px;">
											<a class="jgrid" href="'. Router::url('/') .'contents/ordenar/'.$this->viewVars['contents'][$x]['Content']['id'].'/baixo/' .$this->viewVars['contents'][$x]['Content']['position']. '" title="Mover para baixo">
												<span class="state downarrow">
													
												</span>
											</a>
										</span>
										
										<input style="width: 35px;" type="text" name="order[]" size="5" value="'.$this->viewVars['contents'][$x]['Content']['position'].'" class="text-area-order" disabled>';
								
							} else {
							
								echo	'<span>
											<a class="jgrid" href="'. Router::url('/') .'contents/ordenar/'.$this->viewVars['contents'][$x]['Content']['id'].'/baixo/' .$this->viewVars['contents'][$x]['Content']['position']. '" title="Mover para baixo">
												<span class="state downarrow">
													
												</span>
											</a>
										</span>';
								echo 	'<span>
											<a class="jgrid" href="'. Router::url('/') .'contents/ordenar/'.$this->viewVars['contents'][$x]['Content']['id'].'/cima/ ' .$this->viewVars['contents'][$x]['Content']['position']. '" title="Mover para cima">
												<span class="state uparrow">			
											</a>
										</span>										
								<input style="width: 35px;" type="text" name="order[]" size="7" value="'.$this->viewVars['contents'][$x]['Content']['position'].'" class="text-area-order" disabled>';
							}							
				?>
				</td>
                <td style="text-align:center;">
				
					<a href="../../edit/<?=$this->viewVars['contents'][$x]['Content']['id'];?>"><i class="icon-edit"></i></a> | 
                
                    <?php 
                    echo $this->Form->postLink(
                            'Apagar',
                            array('action' => 'delete', $this->viewVars['contents'][$x]['Content']['id']),
                            array('confirm' => 'Tem Certeta que deseja apagar?', 'class'=>'blue')
                        );
                    ?>
                    
                </td>
            </tr>


<?php }?>
        </tbody>
</table>
