<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//debug($logs);
?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="<?php echo Router::url('/');?>js/jquery.js"></script>
  <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<div class="breadcrumb">
    <h1 id="id_breadcrumbs">Logs de acessos ao sistema.</h1>
    <div id="breadcrumbs_menu">
    <?php
    //echo $this->Html->image('loader.gif', array('class' => 'hide', 'id' => 'loader'));
        $this->Html->addCrumb('Home', '/');
        $this->Html->addCrumb('Logs', '/logs/listar', array('class'=>'active'));
        echo $this->Html->getCrumbs(' / ');
    ?>
    </div>
</div>

<div id="loader"></div>

<div class="input-append">
		<form method="get">
			<div class="btn-group">
				<button data-toggle="dropdown" class="btn dropdown-toggle">Filtrar período inicial:</span></button>	
			</div>
			<input style="width: 60px;height:30px; margin-right: 20px;"  id="dataIni"  name="inicio"  type="text"> 
			<div class="btn-group">
				<button data-toggle="dropdown" class="btn dropdown-toggle">período final:</span></button>	
			</div>
			
			<input style="width: 60px;height:30px" id="dataFim"  name="fim"  type="text">
			<input class="btn" type="submit" value="Filtrar" />
		</form>
	</div>

<table cellspacing='0' cellpadding='0'>
	<?php
		$tableHeaders = $this->Html->tableHeaders( array(
				$this->Paginator->sort('ip', 'IP - ACESSO'),
				$this->Paginator->sort('users', 'Usuário'),
                                $this->Paginator->sort('created', 'Data - Hora do Log'),
                                //$this->Paginator->sort('Ação', 'Inativar')
                    
			)
		);
		echo $tableHeaders;
		$rows = array();
               
		foreach($logs as $row){
			$rows[] = array(
				$row['Log']['ip'],
				'<a href="'.Router::url('/').'users/view/'.$row['User']['id'].'">'.$row['User']['username']."</a>",
                                date("d/m/Y - H:i:s",strtotime($row['Log']['created'])),
                            /*  GERENCIAR RESTAURANTE -> $this->Html->link('Gerenciar Restaurantes', array('action' => 'managerestaurants', $row['User']['id'])) */
                     
			);
		}
		echo $this->Html->tableCells($rows);
		//echo $tableHeaders;
	?>
</table><?php
                     
                ?>
<div class='paging'>
	<?php
            
		//SUFICIENTE PARA MOSTRAR A PAGINAÇÃO PADRAO
		echo $this->Paginator->prev('Anterior', null, null, array('class' => 'disable'));
		echo $this->Paginator->numbers();
		echo $this->Paginator->next('Próximo', null, null, array('class' => 'disable'));
	
        ?>
            
</div>
<br />
<?php echo $this->Js->writeBuffer();?>


<script>
/*jQuery(function() {
    jQuery("#dataIni").datepicker({
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']
    });
});
*/
jQuery(function($) { $( "#dataIni,#dataFim" ).datepicker(
	
	{
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']}
	
	); 
});
</script>