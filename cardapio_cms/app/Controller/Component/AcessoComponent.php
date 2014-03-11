<?php
/**
 * Component Acesso
 * Versão 2 para Cake 2.x
 * Autor: Ribamar FS
 *
 * Este componente tem como finalidade controlar o acesso dos usuários ao
 * aplicativo através de uma interface web.
 *
 * Licenciado sob The MIT License
 * Redistribuições deste arquivo precisa reter o aviso de copyright.
 *
 * @copyright     Copyright (c) Ribamar FS (http://ribafs.org)
 * @link          http://ribafs.org
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Component', 'Controller');

class AcessoComponent extends Component{
	public $uses = array('Privilege');
	public $components = array('Session','Auth');
	public $redir=false;

	public function startup(Controller $controller) {
		// Em Component redirect requer o Controller: 
		//http://stackoverflow.com/questions/16697723/cakephp-how-to-redirect-in-a-component
		$this->Controller = $controller;
	}

	public function admin() {
		// Capturar id do usuario logado
		$valor = $this->Session->read('Auth.User');  //Retorna o array com o id, nome do usuario e 
		$userauth=$valor['group_id'];//$valor['id'];
		if(isset($userauth) && $userauth == 1){
			return true;
		}else{
			return false;
		}
	}	

	public function adminAcesso() {
		if(!$this->admin()){
			$this->Session->setFlash(__('Acesso Negado!1'));
			//$this->Controller->redirect(array('controller'=>'users','action' => 'login'));
	        $this->log($this->Auth->redirect());
	        //$this->Auth->redirect();
			$this->redir = true;
			return $this->redir;
		}
	}

	public function adminAccess() {
		if(!$this->admin()){
			$this->Session->setFlash(__('Acess Denied!'));
			$this->redir = true;
			return $this->redir;
		}
	}

	
	public function gerente() {
		$valor = $this->Session->read('Auth.User');
		$userauth=$valor['group_id'];
		
		if((isset($userauth) && $userauth == 2) || $userauth == 1)	{
			return true;
		}else{
			return false;
		}
	}
	public function manager() {
		$value = $this->Session->read('Auth.User');
		$groupauth=$value['Group']['name'];
		if((isset($groupauth) && $groupauth == 'managers') || $groupauth == 'admins')	{
			return true;
		}else{
			return false;
		}
	}	

	public function gerenteAcesso() {
		
		if($this->gerente()){
			echo "";
		} else {
			$this->Session->setFlash(__('Acesso Negado2!'));
			//$this->Controller->redirects(array('controller'=>'users','action' => 'login'));
			$this->redir = true;
			return $this->redir;
		}
	}
	
	
	
	public function usuario() {
		$valor = $this->Session->read('Auth.User');
		$userauth=$valor['group_id'];
		//debug($userauth);
		if( $userauth == 2 || $userauth == 1)	{
			return true;
		}else{
			return false;
		}
	}	

	public function usuarioAcesso() {
		if(!$this->usuario()){
			$this->Session->setFlash(__('Acesso Negado3!'));
			//$this->Controller->redirect(array('controller'=>'users','action' => 'login'));
			$this->redir = true;
			return $this->redir;
		}
	}
	// Dica sobre o código de $userauth em: https://groups.google.com/forum/#!topic/cakephp-pt/jzEDyhPHG1I

	public function acessoUser($controller,$action){
		//$this->Cliente = ClassRegistry::init('Cliente');// Permitir uso de model em component
		$this->Privilege = ClassRegistry::init('Privilege');// Permitir uso de model em component
		$usuario = $this->Privilege->query("select group_id from privileges where controller='".$controller."' and action='".$action."'");
		if(isset($usuario[0]['privileges']['group_id'])){
			return $usuario[0]['privileges']['group_id'];
		}else{
			return false;		
		}
	}

	
	public function access($controller,$action){
		
				
		if($this->acessoUser($controller,$action) == 1) {
			$this->adminAcesso();
			
			$this->Privilege = ClassRegistry::init('Privilege');// Permitir uso de model em component
			//RESGATANDO QUEM ESTA ONLINE LOGADO
			$userId = $this->Session->read('Auth.User.id');
			//$userId;
			
			//RESGATANDO A PAGINA QUE ESTA SENDO ACESSADA PELO USUARIO
			$paginaAtual = $controller."||".$action;
			$paginaAtual = explode('||',$paginaAtual);
				$controlador = $paginaAtual[0];
				$acao = $paginaAtual[1];
			//VERIFICANDO PERMISSOES CADASTADAS
			$usuario = $this->Privilege->query("select privileges.group_id, controller, action from privileges,groups, users where  action='edit' 
			AND controller='users' 
			AND groups.id = privileges.group_id 
			AND users.group_id = groups.id 
			AND users.id='".$userId."'
			group by users.id");
			//CONTROLANDO O ACESSO
			if($usuario[0]['privileges']['controller'] == $controlador && $usuario[0]['privileges']['action'] == $acao){
				echo "Tem permissão de acesso!";
				//$this->Session->setFlash(__('Tem permissão de acesso!'));
			} else {
				$this->Session->setFlash(__('Não possui permissão de acesso!'));
				$this->Auth->redirect(array('controller'=>'users', 'action'=>'login'));
				$this->redir = true;
			}
			
			
		}elseif($this->acessoUser($controller,$action) == 2){
			$this->gerenteAcesso();
			
		}elseif($this->acessoUser($controller,$action) == 3){	
			$this->usuarioAcesso();
		}else{
			//$this->Session->setFlash(__('Você não tem permissão cadastrada para esta ação!'));//Permissão não cadastrada!
			//$this->Controller->redirects(array('controller'=>'users','action' => 'login'));
			//$this->redir = true;
			//return $this->redir;
			
			//RESGATANDO QUEM ESTA ONLINE LOGADO
			$userId = $this->Session->read('Auth.User.id');
			$userId;
			
			//RESGATANDO A PAGINA QUE ESTA SENDO ACESSADA PELO USUARIO
			$paginaAtual = $controller."||".$action;
			
			$paginaAtual = explode('||',$paginaAtual);
				$controlador = $paginaAtual[0];
				$acao = $paginaAtual[1];
				
			$paginaAtual = $controller."||".$action;
			//VERIFICANDO PERMISSOES CADASTADAS
			$usuario = $this->Privilege->query("select privileges.group_id, controller, action from privileges,groups, users where  action='$acao' 
			AND controller='$controlador' 
			AND groups.id = privileges.group_id 
			AND users.group_id = groups.id 
			AND users.id='".$userId."'
			group by users.id");
			//CONTROLANDO O ACESSO
			
			//$this->Session->setFlash(__('Área Restrita!5'));//Permissão não cadastrada!
			return $this->redir;	
			
			
		}
	}

	
	
}
