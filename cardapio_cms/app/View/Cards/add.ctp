<?php

/*
 * Me Digital - 13/06/2013 - 
 */
?>
<!-- File: /app/View/Cards/add.ctp -->

<h1>Adicionar Novo Cardápio:</h1>
<?php
//este camarada acrescenta ao inicio do form a seguinte estrutura: "<form id="PostAddForm" method="post" action="/posts/add">"
echo $this->Form->create('Card');
echo $this->Form->input('name', array('type'=>'text','style'=>'width:220px; height:18px; font-size: 12px;','label'=>'Titulo do Cardápio:'));
echo $this->Form->input('restaurants_id', array('label'=>'Restaurante Associado:', 'options'=> $restauranteRelacionado));
echo $this->Form->input('creator_id', array( 'type'=> 'hidden', 'value'=> $this->Session->read('Auth.User.id')) );
echo $this->Form->input('active', array('type'=>'hidden','label'=>'Deixe marcado para ativar:', 'value'=>'1','checked' => true));
//echo $this->Form->end('Salvar');
?>
<div class="submit"><input type="submit" value="Salvar"><button class="btn btn-danger" style="height: 37px; margin-left: 80px; " onclick="history.back(-1)" type="button">Voltar</button>
</div>
</form>

