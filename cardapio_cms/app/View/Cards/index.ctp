<?php
/*
 * Listagem geral de cardápios cadastrados e submenu com opções de inserção de novos
 * Roberto S. Melo - 11/06/2013
 * Adicionado BreadCrumb - 22/08/2013
 */
?>
<div class="breadcrumb">
    <h1 id="id_breadcrumbs">Cardápios</h1>
    <div id="breadcrumbs_menu">
    <?php
        $this->Html->addCrumb('Home', '/');
        $this->Html->addCrumb('Usuários', '/users');
        $this->Html->addCrumb('Cardápios', '/cards', array('class'=>'active'));
        echo $this->Html->getCrumbs(' / ');
    ?>
    </div>
</div>

<?php //echo $this->Html->link('Adicionar Novo Cardápio:', array('controller' => 'cards', 'action' => 'add')); ?>

<br />
<table>
    <tr>
        <th>Id</th>
		<th style="text-align:center;">Língua</th>
        <th>Título</th>
        
		<th style="text-align:center;">Status</th>
        
        <th style="text-align:center;">Ação</th>
		
    </tr>

    <!-- Aqui é onde nós percorremos nossa matriz $posts, imprimindo
         as informações dos posts -->

    <?php foreach ($cards as $card): ?>
    <tr>
        <td><?php echo $card['Card']['id']; ?></td>
		
		<td style="text-align:center;">	<?php 
				//CONDICAO PARA MOSTRAR AS BANDEIRAS DAS LINGUAS
	
				echo '<span style="padding: 10px;">'.$this->Html->image("/img/icone_br_portugues.png", array(
						"alt" => "POrtuguês",
						'url' => "../../../". Router::url('/')."cards/view/".$card['Card']['id']."/pt",
						'width'=>'30', 'alt'=>'Português', 'title'=>'Português'
					)).'</span>';
				echo '<span style="padding: 10px;">'.$this->Html->image("/img/icone_gb_inglish.png", array(
						"alt" => "Inglês",
						'url' => "../../../". Router::url('/') ."cards/view/".$card['Card']['id']."/en",
						'width'=>'30', 'alt'=>'English', 'title'=>'Inglês'
					)).'</span>';
				
			
				?>
		</td>
		
        <td>
            <?php echo $card['Card']['name']; ?>
        </td>
       
        <td style="text-align:center;"><?php if($card['Card']['active'] == 0){ echo "Inativo";} else { echo "Ativo";} ?></td>
		
        <td style="text-align:center;">
            <?php 
			/*
			echo $this->Form->postLink(
                'Apagar',
                array('action' => 'delete', $card['Card']['id']),
                array('confirm' => 'Tem Certeta que deseja apagar?')
            );  */
			?>
            <?php echo $this->Html->link('Editar', array('action' => 'edit', $card['Card']['id']));?>
        </td>
		 
    </tr>
    <?php endforeach; ?>

</table>
<br />

<a style="text-decoration:none!important;" href="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Router::url('/cards/add');?>">
    <button class="btn btn-primary" type="button">Adicionar Novo Cardápio</button></a>
 
<button class="btn btn-danger" onclick="history.back(-1)" type="button">Voltar</button>

