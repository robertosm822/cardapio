<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsersController
 *
 * @author Daniel And Roberto
 * Ultima Atualizacao: 21/06/2013
 */

class ItemsController extends AppController{
    public $helpers = array ('Html','Form');    
    public $uses = array('Item','Card','ItemType','Content');
    
    public function index(){
        //
    }
    public function limitar($string, $tamanho, $encode = 'UTF-8') {
		if( strlen($string) > $tamanho )
			$string = mb_substr($string, 4, $tamanho +100, $encode);
		else
			$string = mb_substr($string, 0, $tamanho, $encode);
	 
		return $string;
	}
	
	
	public function removeAcentos($str, $enc = "UTF-8"){
            
            $acentos = array(
                'A' => '/&Agrave;|&Aacute;|&Acirc;|&Atilde;|&Auml;|&Aring;/',
                'a' => '/&agrave;|&aacute;|&acirc;|&atilde;|&auml;|&aring;/',
                'C' => '/&Ccedil;/',
                'c' => '/&ccedil;/',
                'E' => '/&Egrave;|&Eacute;|&Ecirc;|&Euml;/',
                'e' => '/&egrave;|&eacute;|&ecirc;|&euml;/',
                'I' => '/&Igrave;|&Iacute;|&Icirc;|&Iuml;/',
                'i' => '/&igrave;|&iacute;|&icirc;|&iuml;/',
                'N' => '/&Ntilde;/',
                'n' => '/&ntilde;/',
                'O' => '/&Ograve;|&Oacute;|&Ocirc;|&Otilde;|&Ouml;/',
                'o' => '/&ograve;|&oacute;|&ocirc;|&otilde;|&ouml;/',
                'U' => '/&Ugrave;|&Uacute;|&Ucirc;|&Uuml;/',
                'u' => '/&ugrave;|&uacute;|&ucirc;|&uuml;/',
                'Y' => '/&Yacute;/',
                'y' => '/&yacute;|&yuml;/',
                'a.' => '/&ordf;/',
                'o.' => '/&ordm;/'
                );

            return strtolower(preg_replace($acentos,array_keys($acentos),htmlentities($str,ENT_NOQUOTES, $enc)) );
        }
	
    public function add($id = null){
        if(!$id){
            throw new NotFoundException(__('Cardápio Inválido'));
        }
        
				
        $card = $this->Card->findById($id);
		
		
		/*  LOG DE USUARIOS ACESSAM ESTA TELA  */
		$this->requestAction(array('controller'=>'users', 'action'=>'gravaLog', 'params'=>'/[items-add]' ));
        
		
        if (!$card){
            throw new NotFoundException(__('Cardápio Inválido'));
        }
        
        $this->set('items', $this->Item->find('list',array('conditions' => array('active'=>true,'card_id'=>$id))));
        $this->set('itemtypes', $this->ItemType->find('list'));
        
		//debug($this->request->data);
        
        if ($this->request->is('post')){
			$lingua = $this->request->data['Item']['language'];			
			$lingua = $lingua.trim( strtolower(self::removeAcentos($this->request->data['Item']['name'])));			
			$this->request->data['Item']['href'] = str_replace(" ", "-",  $lingua );
		
			//tratando o nome o aquivo dado para nao ser cadastado com espaco
			//$this->request->data['Item']['href']= str_replace(" ","-",$this->request->data['Item']['name']);
            $this->Item->create();
            
			if($this->request->data['Item']['item_type_id']==1){
				debug($this->request->data['Item']);
			
            }
          
            
            if($this->request->data['Item']['parent_id']!=NULL){
                $parentItem = $this->Item->findById($this->request->data['Item']['parent_id']);
                $this->request->data['Item']['level'] = $parentItem['Item']['level'] + 1;
            }
            else{
                $this->request->data['Item']['level'] = 1;
            }
            
            if ($this->Item->save($this->request->data)){
                
				$this->Session->setFlash('Item criado com sucesso.', 'flash_success');
                $this->redirect(array('controller'=>'cards','action' => 'index'));
            }else{
                $this->Session->setFlash('Falha na criação do Item =(');
            }
		}   
		
		
    }

        
           
	public function edit($id = null){
        
        //$this->set('userlevels', $this->UserLevel->find('list',array('conditions' => array('active'=>true))));
		/*  LOG DE USUARIOS ACESSAM ESTA TELA  */
		$this->requestAction(array('controller'=>'users', 'action'=>'gravaLog', 'params'=>'/[items-edit]' ));
		
		//Atribui à variavel
        $item = $this->Item->findById($id);
        
		        
        if ($this->request->is('post') || $this->request->is('put')){
            
            $this->Item->id = $id;
			
			//$tiraPrefixo = self::limitar($this->request->data['Item']['href'],3);
			
			$lingua = $this->request->data['Item']['language'];			
			$lingua = $lingua.trim( strtolower(self::removeAcentos($this->request->data['Item']['name'])));			
			$this->request->data['Item']['href'] = str_replace(" ", "-",  $lingua );			
			
			   
            if ($this->Item->save($this->request->data)){
                $this->Session->setFlash('Item alterado com sucesso.');
                $this->redirect(array('controller'=>'cards','action' => 'index'));
            }else{
                $this->Session->setFlash('Item não pode ser alterado.');
            }
		
        }
		
		//retorna os dados aos campos do formulário de edição       
        if(!$this->request->data){
            $this->request->data = $item;
        }
		
    }
	public function ordenar($id=null,$tipo=null, $posi=null ){
		if(!$id){
            throw new NotFoundException(__('Menu Inválido'));
        }
		$this->Item->id = $id;
		$tipos = $tipo;
		
		if($tipos == 'baixo'){
			//$this->request->onlyAllow('get');
				if ($this->Item->save('position', ($posi +1))) {
					$this->Item->saveField('position', ($posi +1));
					$this->Session->setFlash(__('Reposicionado para baixo com sucesso o Item') , 'flash_success');
					$this->redirect($this->referer());
				} else {
					$this->Session->setFlash(__('Ocorreu um erro inesperado. Por favor tente novamente.'));
				}
		} 
		if($tipos == 'cima'){
			//$this->redirect('../');
			$this->request->onlyAllow('get');
				if ($this->Item->save('position', ($posi -1))) {
					$this->Item->saveField('position', ($posi -1));
					$this->Session->setFlash(__('Reposicionado para cima com sucesso o Item'), 'flash_success');
					$this->redirect($this->referer());
				} else {
					$this->Session->setFlash(__('Ocorreu um erro inesperado. Por favor tente novamente.'));
				}
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
    
     public function delete($id) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        if ($this->Item->delete($id)) {
            $this->Session->setFlash('Este item de id: ' . $id . ' foi corretamente apagado.');
			/*  LOG DE USUARIOS ACESSAM ESTA TELA - CHAMADA DE METODO CRIADO NA CLASSE (CONTROLLER) DE USUARIOS  */
			$this->requestAction(array('controller'=>'users', 'action'=>'gravaLog', 'params'=>'/[items-delete]' ));
            
			$this->redirect(array('action' => '../cards'));
            //header("Location: ../cards");
        }
    }
	
	
	public function desactivate ($id = null) {
		$this->Item->id = $id;
		if (!$this->Item->exists()) {
			throw new NotFoundException(__('Item Inválido'));
		}
		$this->request->onlyAllow('get');
		if ($this->Item->save('active', '0')) {
			$this->Session->setFlash(__('Inativado com sucesso'), 'flash_success');
			/*  LOG DE USUARIOS ACESSAM ESTA TELA  */
			$this->requestAction(array('controller'=>'users', 'action'=>'gravaLog', 'params'=>'/[items-desactivate]' ));
			$this->redirect($this->referer());
		} else {
			$this->Session->setFlash(__('Ocorreu um erro inesperado. Por favor tente novamente.'));
		}
    }
	public function activate ($id) {
		$this->Item->id = $id;
		if (!$this->Item->exists()) {
			throw new NotFoundException(__('Item Inválido'));
		}
		$this->request->onlyAllow('get');
		if ($this->Item->save('active', '1')) {
			$this->Item->saveField('active', '1');
			$this->Session->setFlash(__('Ativado com sucesso o Item'), 'flash_success');
			/*  LOG DE USUARIOS ACESSAM ESTA TELA  */
			$this->requestAction(array('controller'=>'users', 'action'=>'gravaLog', 'params'=>'/[items-activate]' ));
			$this->redirect($this->referer());
		} else {
			$this->Session->setFlash(__('Ocorreu um erro inesperado. Por favor tente novamente.'));
		}
    }
	
	public function precificar(){
			
		//MONTANDO OS DADOS PARA O SELECT MULTIPLO DE PRATOS
		$dadosView=array();
        $this->loadModel('Content'); 
        $dadosView['mostraItems'] = $this->Content->find('list', array('fields'=>array('id','nome' )));
        $this->set($dadosView);
		 
		 if ($this->request->is('post')) {
            
			$itemsT=NULL;
			for($y=0;$y< count($this->request->data['Items']['items']);$y++){
				$itemsT .= $this->request->data['Items']['items'][$y].",";
			}
			//removendo a ultima virgula
			$valorPassado = (float)$this->request->data['Items']['Valor'];
			$itemsT = substr($itemsT,0,-1);
			debug($itemsT."|".$valorPassado);
			if($itemsT !== "" && $valorPassado !== "" && $itemsT !== NULL){
				//EXECUTANDO A ALTERACAO DE TODOS OS PRECOS AO REAJUSTE PASSADO
				$results = $this->Item->query("UPDATE `contents` SET valor = (`valor`+".$valorPassado.") WHERE `contents`.`id` IN( $itemsT);");
				$this->Session->setFlash(__('Todos os preços atualizados com sucesso!'), 'flash_success');
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('Ocorreu um erro inesperado. Por favor tente novamente.'));
			}
        }
		
	}
}

?>

