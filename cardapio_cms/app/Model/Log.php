<?php
/*
-  DATA: 06/02/2014 - robertomelo822@gmail.com
*/
class Log extends AppModel {
    
    public $name = 'Log';
	
	//-- PARA FUNCIONAR O RELACIONAMENTO E LISTAGEM DO NOME DO USUARIO NA LISTA DE LOG
	public $belongsTo = array(
        'User' => array(
            'className'=> 'User', 
            'foreignKey' => 'users'
			)
    );
		
}
?>