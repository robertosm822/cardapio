<?php
//METODO requestAction() QUE RETORNA UMA FUNCAO CRIADA NO CONTROLADOR RESTAURANTS
$IdUser=$this->Session->read('Auth.User.id');
	/* debug($this->Session->read('Auth.User.group_id')); */
//SOMENTE SE LOGADO PODERA TRAZER O RESTAURANTE ASSOCIADO AO USUARIO LOGADO - 14-02/2014
$mostraIdRest = 0;
/* 	
	//CHAMADA DE METODO (ACTION) DA CLASSE DO CONTROLLER DE RESTAURANTS
	if(isset($IdUser)){
	 //$mostraIdRest = $this->requestAction('/restaurants/mostraIdRest/'.$this->Session->read('Auth.User.id'));
	} 
*/

?>
<div class="breadcrumb">
<h1 id="id_breadcrumbs">Restaurantes</h1>

<div id="breadcrumbs_menu">
<?php
    $this->Html->addCrumb('Home', '/');
    $this->Html->addCrumb('Usuários', '/users');
    $this->Html->addCrumb('Cardápios', '/cards');
    $this->Html->addCrumb('Restaurantes', '/restaurants', array('class'=>'active'));
    

    echo $this->Html->getCrumbs(' / ');
?>
</div>
</div>

<table>
    <tr>
        <th>Name</th>
        <th>Status</th>
        <th>Cardápios Criados</th>
        <th>Limite de Cardápios</th>
        
        <th>Criado em</th>
        <th>Ações</th>
    </tr>
    
    <?php foreach ($restaurants as $restaurant): ?>
        <tr>
            <td><?php echo $this->Html->link($restaurant['Restaurant']['name'],array('controller' => 'restaurants', 'action' => 'view', $restaurant['Restaurant']['id'])); ?></td>
            <td><?php echo ($restaurant['Restaurant']['active']==1)?'Ativo':'Inativo'; ?></td>
            <td><?php echo sizeof($restaurant['Card']); ?></td>
            <td><?php echo $restaurant['Restaurant']['cardlimit']; ?></td>
            
            
            <td><?php echo date("d/m/Y",strtotime($restaurant['Restaurant']['created'])); ?></td>
            <td>
                <?php 
                    echo $this->Html->link('Editar', array('action' => 'edit', $restaurant['Restaurant']['id'])); 
                ?>
                <?php 
                    if($restaurant['Restaurant']['active']==1)
                        echo $this->Form->postLink('Inativar',array('action' => 'inactivate', $restaurant['Restaurant']['id']),array('confirm' => 'Tem certeza que deseja inativar este restaurante?'));
                    else
                        echo $this->Form->postLink('Ativar',array('action' => 'activate', $restaurant['Restaurant']['id']),array('confirm' => 'Tem certeza que deseja ativar este restaurante?'));
                ?>
                <?php 
				
				echo $this->Form->postLink(
					'Apagar',
					array('action' => 'delete', $restaurant['Restaurant']['id']),
					array('confirm' => 'Tem Certeta que deseja apagar?')
				);
				
				?>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php unset($post); ?>
</table>

<?php /* RESTRICAO PARA SOMENTE USUARIO MASTER MEDIGITAL CADASTRE NOVO RESTAURANTE */ 
if($this->Session->read('Auth.User.group_id') == 1){?>
	<a style="text-decoration:none !important;" href="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/restaurants/add');?>">
	<button class="btn btn-primary" type="button">Adicionar Restaurante</button></a>
<?php  }?> 

<a style="text-decoration:none !important;" href="javascript:history.back(-1)"><button class="btn btn-danger" type="button">Volta</button></a>