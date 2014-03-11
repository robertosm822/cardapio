<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserModel
 *
 * @author Daniel and Roberto
 * ultima Atualização: 21/06/2013
 */
class Item extends AppModel{
    public $name = 'Item';
    public $belongsTo = array(
        'Card',
        'Content',
        'UserCreator' => array(
            'className'=> 'User', 
            'foreignKey' => 'creator_id'),
        'ParentId' => array(
            'className'=> 'Item', 
            'foreignKey' => 'parent_id'));    
    public $hasMany = array(
        'Childrens' => array(
            'className'=> 'Item', 
            'foreignKey' => 'parent_id'));
}
?>

