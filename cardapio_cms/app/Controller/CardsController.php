<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class CardsController extends AppController {
    public $helpers = array ('Html','Form');
	
    public $name = 'Cards';
    public $uses = array('Card','Item', 'Restaurant', 'Restaurants_user');
	public $components = array('Acesso');
    
    //visualizador de todos os posts vindos do banco
    function index() {
        
		//TRAZENDO A DATA DE ULTIMA MODIFICACAO
			$dadosView=array();
			$this->loadModel('Content'); 
			$dadosView['listarContents'] = $this->Content->find('all',array('order'=>array("Content.modified" => "desc"), 'limit' => 1 ) );
			$this->set($dadosView);

		//$this->fields = array('Card.*', 'Content.*, (SELECT modified FROM contents WHERE ) as modificacao');
        //$card = $this->Card->findById($id);
        $this->set('cards', $this->Card->find('all'));
    }
    

    //vuncao de visualizacao de detalhes do post
    public function view($id = null,$ling=null) {
              
        $this->Card->id = $id;
		
			//TRAZENDO A DATA DE ULTIMA MODIFICACAO 
			$sql = "SELECT * FROM `cards`,`items` 
			INNER JOIN contents ON contents.items_id = items.id WHERE cards.id=".$id."   
			GROUP BY contents.modified
			ORDER BY contents.modified desc LIMIT 1";
			$results = $this->Card->query($sql);
			//debug($results[0]['contents']['modified']);
			$dadosView=array();
			$dadosView['listarContents'] = $results[0]['contents']['modified'];
			$this->set($dadosView);
        
		if($ling == 'en'){
				 //debug($this->Card); //die; 
				$dadosView=array();
				$this->loadModel('Restaurant'); 
				$dadosView['listaRestaurant'] = $this->Restaurant->find('all');
				$this->set($dadosView);
				
				
				$maxLevel = $this->Item->find('first',array('fields'=>array('MAX(Item.level) as max'),'conditions'=>array('Item.card_id'=>$id)));
				$items = $this->Item->find('all',array('conditions'=>array('Item.card_id'=>$id, 'Item.language'=>'#en_'),'order'=>(' Item.position, Item.language ASC'),'recursive'=>-1,'fields'=>array('id','name','level','active','position','language','parent_id','content_id','panel_id','item_type_id')));
			   
			   //adicionar filtro =================================================
			   if($this->request->is('post')){
					$conditions = array('Item.name LIKE' => '%'.$this->request->data['Card']['busca'].'%', 'Item.active'=>$this->request->data['Card']['filtro'] );
					
					$items = $this->Item->find('all', array('conditions' => $conditions));
					//== APROVEITA este conteudo padrao de $items e card
						$this->set('card', $this->Card->read());
						
						$this->set('items', $items);
				} else {
					$this->set('card', $this->Card->read());
					$this->set('items', $items);
				}
		}
		//se linguagem for portugues
		if($ling == 'pt'){
				 //debug($this->Card); //die; 
				$dadosView=array();
				$this->loadModel('Restaurant'); 
				$dadosView['listaRestaurant'] = $this->Restaurant->find('all');
				$this->set($dadosView);
				
				
				$maxLevel = $this->Item->find('first',array('fields'=>array('MAX(Item.level) as max'),'conditions'=>array('Item.card_id'=>$id)));
				$items = $this->Item->find('all',array('conditions'=>array('Item.card_id'=>$id, 'Item.language'=>'#pt_'),'order'=>(' Item.position, Item.language ASC'),'recursive'=>-1,'fields'=>array('id','name','level','active','position','language','parent_id','content_id','panel_id','item_type_id')));
			   
			   //adicionar filtro =================================================
			   if($this->request->is('post')){
					$conditions = array('Item.name LIKE' => '%'.$this->request->data['Card']['busca'].'%', 'Item.active'=>$this->request->data['Card']['filtro'] );
					
					$items = $this->Item->find('all', array('conditions' => $conditions));
					//== APROVEITA este conteudo padrao de $items e card
						$this->set('card', $this->Card->read());
						
						$this->set('items', $items);
				} else {
					$this->set('card', $this->Card->read());
					$this->set('items', $items);
				}
		}		
    }
	
	//===== Adiciona filtro ===============================================
	public function pesquisar(){
			if($this->request->is('post')){
			 
				  $resultados = null;
			 
				  if(!empty($this->request->data['Card']['filtro'])){
					 
					$conditions = array('Item.name LIKE' => "%".$this->request->data['Card']['busca']);				 
					$resultados = $this->Item->find('all', array('conditions' => $conditions));
				  }
				 
				  $this->set('resultados', $resultados);
			   }
		}
	
		
    //metodo de adicao de novo post
    public function add() {
        
		$this->requestAction(array('controller'=>'users', 'action'=>'gravaLog', 'params'=>'/[cards-add]' ));
		//VERIFICADOR DE ACESSO RESTRITO CADASTRADO
		$this->requestAction(array('controller'=>'privileges', 'action'=>'verificaAcesso', 'params'=>'/cards/add' ));
		
        //RECURSO PARA QUE APARECA AS OPÇÕES DE RESTAURANTES PARA ASSOCIAR AO USUÁRIO
        $dadosView=array();
        $this->loadModel('Restaurant'); 
        $dadosView['restauranteRelacionado'] = $this->Restaurant->find('list');
        $this->set($dadosView);
        
        if ($this->request->is('post')) {
            //debug($this->request->data);
			
			
			if ($this->Card->save($this->request->data)) {
                $this->Session->setFlash('Seu Cardapio Foi Salvo com sucesso.');
                $this->redirect(array('action' => 'index'));
            }
			
        }
    }
    //editanto os Posts
    function edit($id = null) {
        
		/*  LOG DE USUARIOS ACESSAM ESTA TELA  */
		$this->requestAction(array('controller'=>'users', 'action'=>'gravaLog', 'params'=>'/[cards-edit]' ));
	
		//VERIFICADOR DE ACESSO RESTRITO CADASTRADO
		//$this->requestAction(array('controller'=>'privileges', 'action'=>'verificaAcesso', 'params'=>'/cards/edit/' ));
		
        //RECURSO PARA QUE APARECA AS OPÇÕES DE RESTAURANTES PARA ASSOCIAR AO USUÁRIO
        $dadosView=array();
        $this->loadModel('Restaurant'); 
        $dadosView['restauranteRelacionado'] = $this->Restaurant->find('list');
        $this->set($dadosView);
        
             
        $this->Card->id = $id;
        if ($this->request->is('get')) {
            $this->request->data = $this->Card->read();
        } else {
            if ($this->Card->save($this->request->data)) {
                $this->Session->setFlash('Cadapio atualizado com sucesso.');
                $this->redirect(array('action' => 'index'));
            }
        }
    }
    //apagando os posts
    public function delete($id) {
		/*
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
		*/
        if ($this->Card->delete($id)) {
            $this->Session->setFlash('O Cardapio de id: ' . $id . ' foi corretamente apagado.');
			
			/*  LOG DE USUARIOS ACESSAM ESTA TELA  */
			$this->requestAction(array('controller'=>'users', 'action'=>'gravaLog', 'params'=>'/[cards-delete]' ));
            
			$this->redirect(array('action' => 'index'));
        }
    }
}
?>
