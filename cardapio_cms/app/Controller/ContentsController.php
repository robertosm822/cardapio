<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Data: 24/06/2013 - Me Digital - Roberto S. Melo
 * //Controller de Conteúdos relacionados a Item X....
 */
class ContentsController extends AppController{
    public $helpers = array ('Html','Form');
    public $uses = array('Item','Content');
    
    public function index(){
      $this->set('contents', $this->Content->find('all')); 
   }
   public function view($id = null){
       
      
       /*
       
       $dadosView=array();
       //$this->loadModel('Contents');
         $dadosView['conteudo'] = $this->set('contents', $this->Content->find('all', array(
           'conditions' => array(
               'Content.items_id' => $id
            )
           )
          )
       );
         debug($dadosView['conteudo']);
        $this->set('contents', $dadosView);
       */
	 
	   
       
      $this->set('contents', $this->Content->find('all', array(
           'conditions' => array(
               'Content.items_id' => $id
            ),
			'order' => 'Content.position ASC',
           )
          )
       );
         
         
        
   }
   
   public function edit($id = null){
        
        //$this->set('userlevels', $this->UserLevel->find('list',array('conditions' => array('active'=>true))));
		
		//Atribui à variavel
        $content = $this->Content->findById($id);
        
        if ($this->request->is('post') || $this->request->is('put')){
            
            $this->Content->id = $id;
            
           
            
            if ($this->Content->save($this->request->data)){
                $this->Session->setFlash('Conteudo do Item alterado com sucesso.');
                $this->redirect(array('controller'=>'cards'));
                 
            }else{
                $this->Session->setFlash('Conteúdo do Item não pode ser alterado.');
            }
        }
		
		//retorna os dados aos campos do formulário de edição       
        if(!$this->request->data){
            $this->request->data = $content;
        }
		
    }
    
    public function add($id = NULL){
        /*
        $dadosView=array();
        $this->loadModel('Restaurant'); 
        $dadosView['restauranteRelacionado'] = $this->Restaurant->find('list');
        $this->set($dadosView);
        */
		$sql = "SELECT name FROM  `items` WHERE id =  '".$id."' LIMIT 1";
        $results = $this->Content->query($sql);
			//debug($results[0]['items']['name']);
			$dadosView=array();
			$dadosView['listarContents'] = $results[0]['items']['name'];
			$this->set($dadosView);
        
        if (!empty($this->request->data)) {
            $this->Content->create();         
            if ($this->Content->save($this->request->data)) {          
                $this->Session->setFlash(__('Conteúdo cadastrado com sucesso'), 'default', array('class' => 'success'));
                $this->redirect(array('action' => '../cards'));
            } else {
                $this->Session->setFlash(__('Erro no cadastro, tente de novo.'), 'default', array('class' => 'error'));
            }
        }
        
    }
    
    public function delete($id) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        if ($this->Content->delete($id)) {
            $this->Session->setFlash('Este item de id: ' . $id . ' foi corretamente apagado.');
            $this->redirect(array('action' => '../cards'));
            //header("Location: ../cards");
        }
    }
    
	public function desactivate ($id = null) {
		$this->Content->id = $id;
		if (!$this->Content->exists()) {
			throw new NotFoundException(__('Conteúdo Inválido'));
		}
		$this->request->onlyAllow('get');
		if ($this->Content->save('active', '0')) {
			$this->Session->setFlash(__('Inativado com sucesso'), 'flash_success');
			$this->redirect($this->referer());
		} else {
			$this->Session->setFlash(__('Ocorreu um erro inesperado. Por favor tente novamente.'));
		}
    }
	public function activate ($id) {
		$this->Content->id = $id;
		if (!$this->Content->exists()) {
			throw new NotFoundException(__('Item Inválido'));
		}
		$this->request->onlyAllow('get');
		if ($this->Content->save('active', '1')) {
			$this->Content->saveField('active', '1');
			$this->Session->setFlash(__('Ativado com sucesso o conteúdo.'), 'flash_success');
			$this->redirect($this->referer());
		} else {
			$this->Session->setFlash(__('Ocorreu um erro inesperado. Por favor tente novamente.'));
		}
    }
	
	
	public function ordenar($id=null,$tipo=null, $posi=null ){
		if(!$id){
            throw new NotFoundException(__('Conteúdo Inválido'));
        }
		$this->Content->id = $id;
		$tipos = $tipo;
		
		if($tipos == 'baixo'){
			//$this->request->onlyAllow('get');
				if ($this->Content->save('position', ($posi +1))) {
					$this->Content->saveField('position', ($posi +1));
					$this->Session->setFlash(__('Reposicionado para baixo com sucesso '), 'flash_success');
					$this->redirect($this->referer());
				} else {
					$this->Session->setFlash(__('Ocorreu um erro inesperado. Por favor tente novamente.'));
				}
		} 
		if($tipos == 'cima'){
			//$this->redirect('../');
			$this->request->onlyAllow('get');
				if ($this->Content->save('position', ($posi -1))) {
					$this->Content->saveField('position', ($posi -1));
					$this->Session->setFlash(__('Reposicionado para cima com sucesso'),'flash_success');
					$this->redirect($this->referer());
				} else {
					$this->Session->setFlash(__('Ocorreu um erro inesperado. Por favor tente novamente.'));
				}
		}
	}
}
?>
