<?php
date_default_timezone_set('America/Sao_Paulo');
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');
//Configure::write('Config.language', 'pt_BR');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
   
    public $components = array(        
        'Session',
		'Acesso',
		'Auth' => array(
            'loginRedirect' => array( 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
			'authorize' => array('Controller') // Added this line
        )
        
		
    );
    //ATRIBUTO PAGINADOR
    public $paginate = array(
		'limit' => 5,
		'order' => array('id' => 'Desc')
	);
   
   public $helpers = array(
			'Html', 
			'Form', 
			'Session'
	);
	

      
   public function beforeFilter()
   {
		
		ini_set('memory_limit', '512M');
		
        $this->Auth->authenticate = array(
            AuthComponent::ALL => array(
                'userModel' => 'User',
                'fields' => array(
                    'username' => 'username',
                    ),
                'scope' => array(
                    'User.status' => 1,
                    ),
                ),
            'Form',
            );
		
		/*
			AUTORIZACAO EH SETADO COMO CONTROLLER
		*/
		/*
        $this->Auth->authorize = 'Controller';
       
        $this->Auth->loginAction = array(
            'plugin' => null,
            'controller' => 'users',
            'action' => 'login',
        );
       
        $this->Auth->logoutRedirect = array(
            'plugin' => null,
            'controller' => 'users',
            'action' => 'login',
        );
     
        $this->Auth->loginRedirect = array(
            'plugin' => null,
            //'controller' => 'cards',
            'action' => '../',
        );

        $this->Auth->authError = __('Você não possui autorização para executar esta ação.');
        
        $this->Auth->allowedActions = array('display');  
        
        //possivel configuracao da linguagem
        if ($this->Session->check('Config.language')) {
            Configure::write('Config.language', $this->Session->read('Config.language'));
        }
        */
		//$this->Auth->allow('users/login'); // Somente a index Ã© pÃºblica

		if($this->action != 'index'){ 

			$controller=$this->params['controller']; 
			$action=$this->params['action']; 
			$this->Acesso->access($controller,$action); 
	 
			if($this->Acesso->redir==true){ 
				$this->redirect(array('controller' => 'users','action' => 'login')); 
			} 
		} 
   }
   
   public function isAuthorized($user){
     //somente o admin tem acesso a /admin/controller/action
    if (!empty($this->request->params['admin'])) {
 		return $user['groups_id'] == 1;
 	}
 	return !empty($user); 
		//return true;	
   }

}
