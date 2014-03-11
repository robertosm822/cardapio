<?php 
//var_dump($mostraItems);
//print_r($itensKey);
echo $this->Form->create('Items', array('action'=>'precificar')); ?>

     <fieldset>
    <legend><?php echo __('Precificar em lote'); ?></legend>

    <?php 
    echo $this->Form->input('Valor', array('label'=>'Digite o valor a ser acrecentado em lote:', 'required'=>'required'));
    echo $this->Form->input('items', array('style'=>'height:100%','required'=>'required','name'=>'data[Items][items][]','label'=>'Pratos a serem alterados:', 'multiple','options'=>array($mostraItems)));
?>
</fieldset> <?php echo $this->Form->end(__('Alterar')); ?>