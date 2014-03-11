<?php
App::uses('AppController', 'Controller');
/**
 * Privileges Controller
 *
 * @property Privilege $Privilege
 * @property PaginatorComponent $Paginator
 */
class PrivilegesController extends AppController {

	public function beforeFilter() {   
		 parent::beforeFilter();
		 // Outros códigos que precisar
	}

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Privilege->recursive = 0;
		$this->set('privileges', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Privilege->exists($id)) {
			throw new NotFoundException(__('Privilégio Inválido'));
		}
		$options = array('conditions' => array('Privilege.' . $this->Privilege->primaryKey => $id));
		$this->set('privilege', $this->Privilege->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		//LISTANDO OS GRUPOS DE USUARIOS PARA CADASTRO
		$dadosView=array();
        $this->loadModel('Group'); 
        $dadosView['goupsItems'] = $this->Group->find('list', array('fields'=>array('id','name' )));
        $this->set($dadosView);
		
		if ($this->request->is('post')) {
			$this->Privilege->create();
			if ($this->Privilege->save($this->request->data)) {
				$this->Session->setFlash(__('Privilégio salvo com sucesso.'),  'default',array('class' => 'success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('O privilégio não pode ser salvo. Favor, tente novamente.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Privilege->id = $id;
		if (!$this->Privilege->exists($id)) {
			throw new NotFoundException(__('Privilégio Inválido'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Privilege->save($this->request->data)) {
				$this->Session->setFlash(__('Privilégio salvo com sucesso.'),  'default',array('class' => 'success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Ocorreu um erro ao tentar editar, favor tente novamente.'));
			}
		} else {
			$options = array('conditions' => array('Privilege.' . $this->Privilege->primaryKey => $id));
			$this->request->data = $this->Privilege->find('first', $options);
		}
		$groups = $this->Privilege->Group->find('list');
		$this->set(compact('groups'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Privilege->id = $id;
		if (!$this->Privilege->exists()) {
			throw new NotFoundException(__('Invalid privilege'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Privilege->delete()) {
			$this->Session->setFlash(__('Privilégio apagado com sucesso.'),  'default',array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('O privilégio não pode ser excluído. Por favor, tente novamente.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	// ACESSO RESTRITO E VERIFICACAO DE PRIVILEGIOS - CRIADO POR ROBERTOMELO822@GMAIL.COM
	public function verificaAcesso ($controlador=NULL, $action=NULL, $userId=NULL){
		$userId = $this->Session->read('Auth.User.id'); 
		$usuario = $this->Privilege->query("select privileges.group_id, controller, action from privileges,groups, users where  action='$action' 
			AND controller='$controlador' 
			AND groups.id = privileges.group_id 
			AND users.group_id = groups.id 
			AND users.id='".$userId."'
			group by users.id");
		
		//tratando se o camarada tem acesso ou não as ações
		if(count($usuario) > 0){
			$nivel = $usuario[0]['privileges']['group_id'];
			$controlador = $usuario[0]['privileges']['controller'];
			$action = $usuario[0]['privileges']['action'];
		
			$this->Session->setFlash(__('Area Restrita...'));
			return $this->redirect(array('controller'=> 'users','action' => 'login'));
		}
	}

}
