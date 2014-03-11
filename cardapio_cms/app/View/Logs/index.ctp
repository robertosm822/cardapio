<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//debug($logs);
?>

<div class="breadcrumb">
    <h1 id="id_breadcrumbs">Relatório de acessos ao sistema.</h1>
    <div id="breadcrumbs_menu">
    <?php
    //echo $this->Html->image('loader.gif', array('class' => 'hide', 'id' => 'loader'));
        $this->Html->addCrumb('Home', '/');
        $this->Html->addCrumb('Logs', '/logs', array('class'=>'active'));
        echo $this->Html->getCrumbs(' / ');
    ?>
    </div>
</div>

<div id="loader"></div>
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