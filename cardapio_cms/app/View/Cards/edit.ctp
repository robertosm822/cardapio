<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!-- File: /app/View/Cards/edit.ctp -->

<h1>Editar Cardápio</h1>
<?php
    echo $this->Form->create('Card', array('action' => 'edit'));
    echo $this->Form->input('name', array('label'=>'Titulo:'));
    echo $this->Form->input('active', array('type'=>'checkbox','label'=>'Ativar / Desativar:'));
    echo $this->Form->input('restaurants_id', array('label'=>'Restaurante Associado:', 'type'=> 'hidden'));
    echo $this->Form->input('creator_id', array( 'type'=> 'hidden', 'value'=> $this->Session->read('Auth.User.id')) );
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('Confirmar');
?>