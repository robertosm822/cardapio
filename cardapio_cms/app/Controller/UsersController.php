<?php
App::uses('AppController', 'Controller');
class UsersController extends AppController {

    public $helpers = array ('Html','Form');
    public $name = 'Users';
    
    public $uses = array('User', 'Log');
    
    public $components = array('Security');

    public function beforeFilter()
    {
        parent::beforeFilter(); 

		$this->Security->validatePost = true;  	
    }

    public function admin_index()
    {
       
    }

    public function gravaLog($url){
            /*  LOG DE USUARIOS QUE SAIRAM  */
            $IP = $_SERVER['REMOTE_ADDR'] ;
            $usuarioOnline = $this->Session->read('Auth.User.id');
            $sql = "INSERT INTO `logs` (`id`, `ip`, `users`, `created`) VALUES (NULL, '".$IP.$url."', '".$usuarioOnline."', NOW());";
            $results = $this->User->query($sql);
    }
	
    public function index($value=NULL)
    {
                
		 /*  LOG DE USUARIOS QUE CONSULTARAM A LISTA DE USUARIOS  */
		self::gravaLog("[users-index]");
				
        $value = (isset($_GET['filtrar']))? $_GET['filtrar']: "";
		/* LISTANDO SOMENTE OS USUARIOS DE STATUS = 1 OU SEJA ATIVOS */
       
		/* TRABALAHNDO RELACIONAMENTO COM GROUPS, RESTAURANTS, USERS E LOGS */
	
		$this->paginate['User']['recursive'] = -1;
		$this->paginate['User']['fields'] = array('Log.*,(SELECT MAX(created) FROM logs WHERE users = User.id ORDER BY created DESC LIMIT 1) as ultimmo','User.*', 'Group.name as GRUPO');
		
		$this->paginate['User']['joins'] = array(	
				array(
					'alias' => 'Log',
					'table' => 'logs',
					'conditions' => '`User`.`id` = `Log`.`users` AND (SELECT created FROM logs WHERE users = User.id ORDER BY created DESC LIMIT 1)'
				),
				array(
					'alias' => 'Group',
					'table' => 'groups',
					'conditions' => '`User`.status = 0 AND `User`.`group_id` = `Group`.`id` AND User.current_restaurant_id = '.$this->Session->read('Auth.User.current_restaurant_id').''
				)
		);
		if($this->Session->read('Auth.User.group_id') == 1){		
			$this->paginate['User']['joins'] = array(	
					array(
						'alias' => 'Log',
						'table' => 'logs',
						'conditions' => '`User`.`id` = `Log`.`users` AND (SELECT created FROM logs WHERE users = User.id ORDER BY created DESC LIMIT 1)'
					),
					array(
						'alias' => 'Group',
						'table' => 'groups',
						'conditions' => '`User`.`group_id` = `Group`.`id`'
					)
			);
			
			$this->paginate['User']['conditions'] = "User.status= 1 AND User.username like '%".$value."%'";
			$this->paginate['User']['group'] = 'User.id';
			$this->paginate['User']['order'] = array('Log.created'=>'desc');
			$this->paginate['User']['limit'] = 10;
			$this->set('users',$this->paginate()  );
		} else {	
			//FARA A PAGINACAO SE OS USUARIOS FOREM DO MESMO RESTAURANTE CADASTRADO
			$this->paginate['User']['joins'] = array(	
					array(
						'alias' => 'Log',
						'table' => 'logs',
						'conditions' => '`User`.`id` = `Log`.`users` AND (SELECT created FROM logs WHERE users = User.id ORDER BY created DESC LIMIT 1)'
					),
					array(
						'alias' => 'Group',
						'table' => 'groups',
						'conditions' => ' `User`.status = 1 AND `User`.`group_id` = `Group`.`id` AND User.current_restaurant_id = '.$this->Session->read('Auth.User.current_restaurant_id').''
					)
			);
			
			$this->paginate['User']['conditions'] = "User.status= 1  AND User.username like '%".$value."%' AND User.group_id = ".$this->Session->read('Auth.User.group_id')."  OR User.group_id > 2";
			$this->paginate['User']['group'] = 'User.id';
			$this->paginate['User']['order'] = array('Log.created'=>'desc');
			$this->paginate['User']['limit'] = 10;
			$this->set('users',$this->paginate()  );
		}
		
	}

	public function inativos()
    {
      	
		 /*  LOG DE USUARIOS QUE CONSULTARAM A LISTA DE USUARIOS  */
		self::gravaLog("[users-inativos]");
				
        $value = (isset($_GET['filtrar']))? $_GET['filtrar']: "";
		/* LISTANDO SOMENTE OS USUARIOS DE STATUS = 0 OU SEJA inativos */
       
		/* TRABALAHNDO RELACIONAMENTO COM GROUPS, RESTAURANTS, USERS E LOGS */
	
		$this->paginate['User']['recursive'] = -1;
		$this->paginate['User']['fields'] = array('Log.*,(SELECT MAX(created) FROM logs WHERE users = User.id ORDER BY created DESC LIMIT 1) as ultimmo','User.*', 'Group.name as GRUPO');
		
		$this->paginate['User']['joins'] = array(	
				array(
					'alias' => 'Log',
					'table' => 'logs',
					'conditions' => '`User`.`id` = `Log`.`users` AND (SELECT created FROM logs WHERE users = User.id ORDER BY created DESC LIMIT 1)'
				),
				array(
					'alias' => 'Group',
					'table' => 'groups',
					'conditions' => '`User`.`group_id` = `Group`.`id` AND User.current_restaurant_id = '.$this->Session->read('Auth.User.current_restaurant_id').''
				)
		);
		if($this->Session->read('Auth.User.group_id') == 1){		
			$this->paginate['User']['joins'] = array(	
					array(
						'alias' => 'Log',
						'table' => 'logs',
						'conditions' => '`User`.`id` = `Log`.`users` AND (SELECT created FROM logs WHERE users = User.id ORDER BY created DESC LIMIT 1)'
					),
					array(
						'alias' => 'Group',
						'table' => 'groups',
						'conditions' => '`User`.`group_id` = `Group`.`id`'
					)
			);
			
			$this->paginate['User']['conditions'] = "User.status= 0 AND User.username like '%".$value."%'";
			$this->paginate['User']['group'] = 'User.id';
			$this->paginate['User']['order'] = array('Log.created'=>'desc');
			$this->paginate['User']['limit'] = 10;
			$this->set('users',$this->paginate()  );
		} else {	
			//FARA A PAGINACAO SE OS USUARIOS FOREM DO MESMO RESTAURANTE CADASTRADO
			$this->paginate['User']['joins'] = array(	
					array(
						'alias' => 'Log',
						'table' => 'logs',
						'conditions' => '`User`.`id` = `Log`.`users` AND (SELECT created FROM logs WHERE users = User.id ORDER BY created DESC LIMIT 1)'
					),
					array(
						'alias' => 'Group',
						'table' => 'groups',
						'conditions' => '`User`.`group_id` = `Group`.`id` AND User.current_restaurant_id = '.$this->Session->read('Auth.User.current_restaurant_id').' AND User.status= 0'
					)
			);
			
			$this->paginate['User']['conditions'] = "User.status= 0 OR User.username like '%".$value."%' AND User.group_id = ".$this->Session->read('Auth.User.group_id')." ";
			$this->paginate['User']['group'] = 'User.id';
			$this->paginate['User']['order'] = array('Log.created'=>'desc');
			$this->paginate['User']['limit'] = 10;
			$this->set('users',$this->paginate()  );
		}
    }
	
    public function add()
    {
        /*  LOG DE USUARIOS QUE ADICIONARAM  */
		self::gravaLog("[users-add]");
		
		$dadosView=array();
        $this->loadModel('Restaurant'); 
        $dadosView['restauranteRelacionado'] = $this->Restaurant->find('list');
        $this->set($dadosView);
        
        if (!empty($this->request->data)) {
            $this->User->create();         
            if ($this->User->save($this->request->data)) {          
                $this->Session->setFlash(__('Usuario cadastrado com sucesso'), 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Erro no cadastro, tente de novo.'), 'default', array('class' => 'error'));
            }
        }
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
    }
    /* METODO DE EDITAR USUARIOS */
    public function edit($id = null){
        
		//VERIFICADOR DE ACESSO RESTRITO CADASTRADO
		$this->requestAction(array('controller'=>'privileges', 'action'=>'verificaAcesso', 'params'=>'/users/edit' ));
		
		
		 /*  LOG DE USUARIOS QUE EDITARAM  */
		self::gravaLog("[users-edit]");
		
		$dadosView = array( );
        		
        //CONFIGURANDO UMA CHAMADA DAS INFORMACOES DA TABELA `restaurants` PARA SEREM LISTADA NA COMBO DAS VIEWS (EXEMPLO EDIT.CTP)
       $this->loadModel('Restaurant'); 
       $dadosView['listaRestaurantes'] = $this->Restaurant->find('list');
       $this->set($dadosView);
       
       $dadosGrupo = array( );
        //CONFIGURANDO UMA CHAMADA DAS INFORMACOES DA TABELA `restaurants` PARA SEREM LISTADA NA COMBO DAS VIEWS (EXEMPLO EDIT.CTP)
       /*$this->loadModel('Group'); 
		   $dadosGrupo['listaGrupos'] = $this->Group->find('list');
		   $this->set($dadosGrupo);
       
			//$this->User->find('all');  
		*/
        
        if(!$id){
            throw new NotFoundException(__('Usuário Inválido'));
        }
        
        $user = $this->User->findById($id);
        //$this->User->id = $id;
		
		$senha = $user['User']['password'];
        
        if(!$user){
            throw new NotFoundException(__('Usuário Inválido'));
        }
        
        if ($this->request->is('post') || $this->request->is('put')){
            			
			// Se vier o campo Senha, adicionamos a validação da senha no model User
			if ( isset($this->request->data['User']['password']) && $this->request->data['User']['password'] !=='' || $this->request->data['User']['confirmar_senha'] !=='' ) {
				//print_r($this->request->data['User']['password']);
				//print_r($this->User);
				//exit;
				if($this->request->data['User']['password'] !== '' && $this->request->data['User']['confirmar_senha'] !== '' && $this->request->data['User']['confirmar_senha'] == $this->request->data['User']['password']){
					if ($this->User->saveAll($this->request->data,array('validate'=>array(
					'password' => array(
							
							'notempty' => array(

							'rule' => array('notempty'),

							'message' => 'Valor de preenchimento obrigatório.',

							),
					
							'minlength' => array(

									'rule' => array('minlength', 6),

									'message' => 'A Senha deve possuir pelomenos 6 caracteres alfanuméricos.',

							),

							'alphanumeric' => array(

									'rule' => array('alphanumeric'),

									'message' => 'A Senha deve possuir somente letras e números.',
							),

							),

					 'confirmar_senha' => array(
								'notEmpty' => array(
										'rule' => 'notEmpty',
										'required' => true,
										'message' => 'Confime sua senha.'
								),
								'minLength' => array(
										'rule' => array('minLength', 6),
										'required' => true,
										'message' => 'Sua senha precisa conter pelo menos 6 caracteres.'
								),
								'passwordConfirmation' => array(
										'rule'    => array('passwordConfirmation'),
								'message' => 'As duas senhas não conferem.'
								),
								
						))
					))){
						$this->Session->setFlash('Usuário alterado com sucesso.');
						$this->redirect("/");
					}else{
						$this->Session->setFlash('Usuário não pode ser alterado.');
					}
				} else {  $this->Session->setFlash('Usuário não pode ser alterado. Senha não confere ou estão vazias.'); }
				
			} else {
				$dadosValidados = array(
					'User'=> array(
						'username' => $this->request->data['User']['username'], 
						'email' => $this->request->data['User']['email'], 
						'group_id' => $this->request->data['User']['group_id'], 
						'current_restaurant_id' => $this->request->data['User']['current_restaurant_id'],
						'status' => $this->request->data['User']['status'], 
						'id' => $this->request->data['User']['id'],
					)
				);
				//print_r($dadosValidados);
				//exit;
				if ($this->User->save($dadosValidados)){
					
					$this->Session->setFlash('Usuário alterado com sucesso.', 'flash_success');
					$this->redirect("/");
				}else{
					$this->Session->setFlash('Usuário não pode ser alterado.');
				}
			}
        } else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
			
		}
        
        if(!$this->request->data){
            $this->request->data = $user;
        }
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
			
    }
    
    public function login()
    {
        $this->set('title_for_layout', __('Log in'));
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
				//REDIRECIONANDO PARA O PADRAO CONFIGURADO EM AppController::$this->Auth->loginRedirect()
                return $this->redirect($this->Auth->redirect('/'));
            } else {
                $this->Session->setFlash($this->Auth->authError, 'default', array(), 'auth');
                $this->redirect($this->Auth->loginAction);
            }
        }
    }
	
	
    public function logout()
    {
        self::gravaLog("[users-logout]");
		
		$this->Session->setFlash(__('Deslogado com sucesso.'), 'default', array('class' => 'success'));
        $this->redirect($this->Auth->logout());
    }

    public function admin_logout()
    {
        $this->Session->setFlash(__('Deslogado com sucesso.'), 'default', array('class' => 'success'));
        $this->redirect($this->Auth->logout());
    }
    
    /* METODO DE INATIVAR USUARIO */
    public function inactivate($id = null){
    
      //$this->request->data['User']['status'] = '0';
	   $this->User->findById($id);
	  debug($this->User);
	  $user['User']['status'] = false;
	  
		$this->User = $user;
		//debug($this->User);
        //exit;
        //if (!$this->request->is('post') && !$this->request->is('put')) {
          //  throw new MethodNotAllowedException();
        //}
    
        if (!$this->User) {
            throw new NotFoundException(__('Usuário Inválido'));
        }
		
        if ($this->request->is('post')  || $this->request->is('put') ) {
            
           //$this->request->data['User']['id'] = $id;
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('Usuário  inativado com sucesso.', 'flash_success');
               
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Usuário não pode ser inativado, tente novamente');
                
               
            }
        }
        
    }
    //Controla as permissoes de restaurantes que cada usuario ira administrar
    public function managerestaurants($id = null){
        
        
        $user = $this->User->findById($id);
        
        if (!$user){
            throw new NotFoundException(__('Usuário Inválido'));
        }
        
        $this->set('user', $user);
        $this->loadModel('Restaurant');
        $this->set('restaurant', $this->Restaurant->find('all'));
        
        if(!$id){
            throw new NotFoundException(__('Usuário Inválido'));
        }
         
        if ($this->request->is('post') || $this->request->is('put')){
            
            $this->User->id = $id;
            
            $currentRestaurantId = $user['User']['current_restaurant_id'];
            $restaurants = array();
            if(isset($this->request->data['Restaurant']) && sizeof($this->request->data['Restaurant'])>0){
                foreach ($this->request->data['Restaurant'] as $key=>$val){
                    $restaurants[] = $val;
                    print_r($restaurants[0]."|||".$user['User']['id']);
                }
            }
            
            if(sizeof($restaurants) == 0){
                if(!in_array($currentRestaurantId, $restaurants)){
                    $this->User->refreshCurrentRestaurant($restaurants[0],$user['User']['id']);
                }
            }else{
                $this->User->refreshCurrentRestaurant('NULL',$id);
            }
            
            $this->User->deleteRelationship($id);
            
            if ($this->User->saveAssociated($this->request->data)){
                $this->Session->setFlash('Restaurantes associados com sucesso.');
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Session->setFlash('Restaurantes não podem ser alterados.');
            }
        }
        
        if(!$this->request->data){
            $this->request->data = $user;
            
            
        }
    }
	
	public function view($id = null){
		
		if(!$id){
            throw new NotFoundException(__('Usuário Inválido'));
        }
        
        $user = $this->User->findById($id);
        
        if (!$user){
            throw new NotFoundException(__('Usuário Inválido'));
        }
        $this->set('user', $user);
	}
 }

?>