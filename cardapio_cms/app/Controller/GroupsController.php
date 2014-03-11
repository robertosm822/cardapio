<?php
App::uses('AppController', 'Controller');
/**
 * Groups Controller
 *
 * @property Group $Group
 */
class GroupsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function beforeFilter() {   
		 parent::beforeFilter();
		 // Outros cÃ³digos que precisar
	}
 
	public function index() {
		
		//VERIFICADOR DE ACESSO RESTRITO CADASTRADO
		$this->requestAction(array('controller'=>'privileges', 'action'=>'verificaAcesso', 'params'=>'/groups/index' ));
		
		$this->Group->recursive = 0;
		//$this->set('groups', $this->paginate(array('ORDER BY Group.id DESC')));
		$this->paginate['Group']['limit'] = 5;
        /* LISTANDO SOMENTE OS USUARIOS DE STATUS = 1 OU SEJA ATIVOS */
        //$this->paginate['User']['conditions'] = array(
        //        'User.status' => 1
        //);
        $this->set('groups', $this->paginate() );
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		
		if (!$this->Group->exists($id)) {
			throw new NotFoundException(__('Grupo Inválido'));
		}
		$options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
		$this->set('group', $this->Group->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			//$this->Group->create();
			if ($this->Group->save($this->request->data)) {
				
				$this->Session->setFlash('O grupo foi salvo com sucesso!', 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('O grupo não pode ser salvo. Por favor, tente novamente.'));
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
		if (!$this->Group->exists($id)) {
			throw new NotFoundException(__('Grupo inválido'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			debug($this->request->data);
			
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash('O grupo foi editado e salvo com sucesso!', 'flash_success');
								
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('O grupo não pode ser salvo. Por favor, tente novamente.'));
			}
		} else {
			$options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
			$this->request->data = $this->Group->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException(__('Grupo inválido, operação falhou.'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Group->delete()) {
			$this->Session->setFlash(__('Grupo apagado do sistema!'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Grupo não pode ser apagado do sistema.'));
		$this->redirect(array('action' => 'index'));
	}
}
