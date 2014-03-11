<?php
/**
 * Description of pesquisar
 *
 * @author ROBERTO
 */

// Na view "pesquisar.ctp" vc coloca
 
$options = array('1'=>'Nome do Especialista', '2'=>'Especialidade',
'3'=>'Endereço');
 
echo $this->Form->create('Card', array('action'=>'pesquisar'));
echo $this->Form->input('busca', array('label'=>'Pesquisar:'));
echo $this->Form->input('filtro', array('label'=>'Filtro','type'=>'select','options'=> $options));
echo $this->Form->submit('Buscar', array('class' => 'ui-state-default
ui-corner-all'));
echo $this->Form->end();

debug($resultados);
?>
