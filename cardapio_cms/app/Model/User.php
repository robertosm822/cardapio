<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel {
    
    public $name = 'User';
	
	 //public $hasOne = 'Log';
    
    //ACRESCENTADO PARA FUNCIONAR A CONFIRMACAO DE SENHA
    public $components = array('Security');
    
    //CONTROLA O UPLOAD DE FOTOS PARA A PASTA 
   public $actsAs = array(
        'Upload.Upload' => array(
            'photo' => array(
                
                'fields' => array(
                    'dir' => 'photo_dir',
                    'deleteOnUpdate' => true
                ),
             'deleteOnUpdate' => true
            )
        )
    );
   
   public $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'dependent' => true,
			'fields' => 'Group.id,Group.name',
			'order' => ''
		),
		'Log' => array(
			'className' => 'Log',
			'foreignKey' => 'id',
			'fields' => 'Group.name'
		)
	);
	

    
    public function beforeSave($options = array()) {
        /*
        if (!empty($this->data['User']['password'])) {
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
        }
        return true;
        */
        if (isset($this->data[$this->alias]['password'])) {
		    $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
	}
        return true;
    }
    
    //relacionando Users com Restaurants
   public $hasAndBelongsToMany = array(
         'Restaurant' => array(
            'className' => 'Restaurant',
            'foreignKey' => 'users_id',
            'associationForeignKey' => 'restaurants_id',
            'joinTable' => 'restaurants_users',
             'dependent' => true
        )
    );
    
	
	
    /* VALIDACOES */
     public $validate = array(
        'username' => array(
            'NotEmpty' => array(
                'rule'     => 'notEmpty',
                'message' => 'Preencha o campo'
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Este nome já está em uso',
                'last' => true
            )
        ),
        'email' => array('NotEmpty' => array('email','rule' => 'isUnique', 'message' => 'Digite um email válido.') ),
        
         );
    
	 
     /* METODO AUXILIAR PARA CONFIRMAR A SENHA */
     public function passwordConfirmation($data){
         
        $password = $this->data['User']['password'];
        $password_confirmation = $this->data['User']['confirmar_senha'];
              
        if($password===$password_confirmation){
             
            return true;
             
        }else{
             
            return false;
             
        }
         
    }
    
     function deleteRelationship($id){
        $sql = 'DELETE FROM restaurants_users WHERE users_id = "'.$id.'"';
        return $this->query($sql);
    }
    /* Metodo adicional para fazer update na tabela que realciona restaurantes */
    function refreshCurrentRestaurant($restaurantId,$userId){
        $sql = 'UPDATE users SET current_restaurant_id = '.$restaurantId.' WHERE id = "'.$userId.'"';
        return $this->query($sql);
    }
   
}
?>