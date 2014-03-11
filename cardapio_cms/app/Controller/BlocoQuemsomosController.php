<?php
App::uses('AppController', 'Controller');
/**
 * BlocoQuemsomos Controller
 *
 * @property BlocoQuemsomo $BlocoQuemsomo
 */
class BlocoQuemsomosController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->BlocoQuemsomo->recursive = 0;
		$this->set('blocoQuemsomos', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->BlocoQuemsomo->exists($id)) {
			throw new NotFoundException(__('Invalid bloco quemsomo'));
		}
		$options = array('conditions' => array('BlocoQuemsomo.' . $this->BlocoQuemsomo->primaryKey => $id));
		$this->set('blocoQuemsomo', $this->BlocoQuemsomo->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->BlocoQuemsomo->create();
			if ($this->BlocoQuemsomo->save($this->request->data)) {
				$this->Session->setFlash(__('The bloco quemsomo has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bloco quemsomo could not be saved. Please, try again.'));
			}
		}
		
		$restaurantOnline = $this->Session->read('Auth.User.current_restaurant_id');
        
		$this->loadModel('Restaurant');
		$restaurants = $this->Restaurant->find('list', array('conditions'=>'Restaurant.id ='.$restaurantOnline, 'fields'=>'Restaurant.id'));
		
		$blocoquemsomos = $this->BlocoQuemsomo->find('list');
		$this->set(compact('BlocoQuemsomo', 'restaurants'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->BlocoQuemsomo->exists($id)) {
			throw new NotFoundException(__('Invalid bloco quemsomo'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->BlocoQuemsomo->save($this->request->data)) {
				$this->Session->setFlash(__('The bloco quemsomo has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bloco quemsomo could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('BlocoQuemsomo.' . $this->BlocoQuemsomo->primaryKey => $id));
			$this->request->data = $this->BlocoQuemsomo->find('first', $options);
		}
		//$restaurants = $this->Restaurant->find('list');
		//$this->set(compact('restaurants'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->BlocoQuemsomo->id = $id;
		if (!$this->BlocoQuemsomo->exists()) {
			throw new NotFoundException(__('Invalid bloco quemsomo'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->BlocoQuemsomo->delete()) {
			$this->Session->setFlash(__('Bloco quemsomo deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Bloco quemsomo was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
