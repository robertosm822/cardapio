<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Card extends AppModel {
    public $name = 'Card';
    var $uses = array('Card','Restaurant' );
    
   
   public $belongsTo = array(
       'Restaurant' => array(
           'className' => 'Restaurant',
           'foreignKey'=>'restaurants_id',
           'fields' => array('id', 'name')
        )
       );
   
  /*
   public $hasOne = array(
       'Restaurant' => array(
           'className' => 'Restaurant',
           'foreignKey'=> 'restaurants_id',
           'fields' => array('id', 'name')
       )
   );
   * 
   */
      
    //validacao do formulario de cadastro
    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'rule'=> array('maxLength', 50),
            'message'=>'Campo deve ter no máximo 50 caracteres e não pode ser vazio'
        ),
        'restaurants_id' => array(
            'rule' => 'notEmpty',
            'message'=> 'Deve-se relacionar pelo menos um restaurante para o cadastro.'
        )
       
    );
    
   
}
?>

