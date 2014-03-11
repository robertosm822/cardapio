<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserModel
 *
 * @author Daniel e Roberto
 */
// TRABALHANDO COM UPLOAD SEM PLUGIN - 06/03/2014 
App::uses('Folder', 'Utility');  
App::uses('File', 'Utility');
 
class Restaurant extends AppModel{
    public $name = 'Restaurant';
  
    //public $hasMany = array('Card');
    public $belongsTo = array(
        'UserCreator' => array(
            'className'=> 'User', 
            'foreignKey' => 'creator_id'
         )
    );
    

    //relacionando  Restaurants com Cards (1:n)
    public $hasMany = array(
        'Card' => array(
            'className' => 'Card',
            'foreignKey' => 'restaurants_id',
            'dependent' => true
        )
        
    );
	
    //relacionando Restaurants com Users
    public $hasAndBelongsToMany = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'users_id',
            'associationForeignKey' => 'restaurants_id',
            'joinTable' => 'restaurants_users',
            'dependent' => true
        )
    );
    
    
   //controlador de Upload de fotos 
   public $actsAs = array(
        'Upload.Upload' => array(
            'photo' => array(
                
                'fields' => array(
                    'dir' => 'photo_dir'
                )
            )
        )
    );
   //C:/xampp/htdocs/CARDAPIO_APP/CARDAPIO_CAKE/app/webroot/file/photo/
    
    public $validate = array(
        'name' => array(
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
        'cardlimit' => array(
            'Numeric' => array(
                'rule' => 'numeric',
                'message' => 'Somente Números'
            )
        )
    );
	
		//TESTE DE FUNCAO PARA UPLOAD SEM PLUGIN
	    public function upload (Array $arquivo, $diretorio=NULL){
		
			
			//Se nenhum erro foi enviado e o aruivo tem tamanho diferente de 0
			if ((!$arquivo['error']) and ($arquivo['size'])){
				
							//removo a primeira / do titulo
							$diretorio_local=substr($diretorio, 0, -1);
				
				//declaro aonde salvar os arquivos
				$diretorio_local=WWW_ROOT.str_replace(array('/'),DS,$diretorio);
				$diretorio_local = str_replace(array(DS.DS), DS, $diretorio_local);
					
				//verifica se existe a pasta
				if(!is_dir($diretorio_local)){
					
					//caso não exista eu chamo o Utilitie Folder
					$folder = new Folder();

					//crio a pasta já verificando se conseguiu
					if($folder->create($diretorio_local)){
						//se conseguiu criar o diretório eu dou permissão
						$folder->chmod($diretorio_local, 0755, true);
					} else {
						//se não foi possível informo um erro
						throw new NotFoundException(__('Erro ao criar a pasta'));
					}
				}
				
				//Ok, com diretório devidamente criado, vamos declarar o arquivo temporário
				$arquivo_tmp = new File($arquivo['tmp_name'],false);
				
				//pegar os dados dele
				$dados = $arquivo_tmp->read();
				
				//e fecha-lo
				$arquivo_tmp->close();
				
				//agora vamosc riar nosso arquivo
				$arquivo_nome = new File($diretorio_local.DS.$arquivo['name'],false,0644);
				
				//cria-lo
				$arquivo_nome->create();
				
				//escrever os dados armazenados
				$arquivo_nome->write($dados);
				
				//e feixar o arquivo
				$arquivo_nome->close();
				
				//retorno só nome do arquivo para salvar no banco, mas poderia ser o diretório web também
				return $diretorio . '/' . $arquivo['name'];
				
			} else {
				//se deu erro no upload
				throw new NotFoundException(__('Erro ao enviar arquivo'));
			}
		}

}

?>
