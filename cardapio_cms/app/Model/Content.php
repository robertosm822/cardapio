<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Content extends AppModel{
    public $name = 'Content';
   
    public $belongsTo = array(
        'Item' => array(
            'className'=> 'Item', 
            'foreignKey' => 'items_id')
    );
    
    //controlador de Upload de fotos 
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
   
   //validando o formulario de edição e adição
   public $validate = array(
        'nome' => array(
            'rule' => 'notEmpty',
            'rule'=> array('maxLength', 100),
            'message'=>'Campo deve ter no máximo 100 caracteres e não pode ser vazio'
        ),
		'codigo_prato' => array(
            'NotEmpty' => array(
                'rule'     => 'notEmpty',
                'message' => 'Preencha o campo'
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Este código já está em uso',
                'last' => true
            )
        ),
		'photo' => array(
			'rule' => array('isValidMimeType', array('image/jpg','image/jpeg', 'image/png')),
			'message' => 'Foto não pode ultrapassar 1 MB ou formato não aceito (jpg/png somente)'
		)
       
    );

    
 }
?>
